<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\CategoryName;
use App\Models\accountDeletionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAccountDeletionConfirmation;
use App\Mail\MailReportProblem;
use App\Mail\MailGeneralTemplate;
use App\Mail\MailTestTemplateBlade;
use App\Models\Projects;
use App\Models\NotificationsUsers;
use App\Models\ReportProblems;
use App\Models\NdaProjects;
use App\Models\FavoriteProject;

use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (User::checkAdmin()){
            return redirect(route("admin.dashboard"));
        }
        if (User::checkInvestor()){
            return redirect(route("homeInvestor"));
        }

        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        if (!$user_detail && !User::checkAdmin()){
            return redirect(route("profile"));
        }
        $data['title_page'] = 'My Projects';
        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        $data['user_photo'] = $user_detail->photo;

        $data['projects'] = Projects::where("user_id", Auth::id())->get();

        return view('home', ['data' => $data]);
    }

    public function profile(){

//        $user_id_email = Auth::id();
//        if(User::checkInvestor($user_id_email)){
//            echo 'investor';
//            $user_investor_info = User::where('id', $user_id_email)->first();
//            $user_investor_email = $user_investor_info->email;
//
//            if(isset($user_investor_info->detail) && !empty($user_investor_info->detail) && $user_investor_info->detail->notification_email){
//                echo 'true';
//            }
//        }

        $data['title_page'] = 'My Profile';
        $data['user'] = Auth::user();
        $data['userDetail'] = null;

        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        if ($user_detail){
            $data['userDetail'] = $user_detail;
        }

        //$data['category'] = CategoryName::all();
        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();

        $data['allCountry'] = (new CountryController)->allCountries();
        unset($data['allCountry']['EU']);
        asort($data['allCountry']);
        //array_unshift($data['allCountry'], "Åland Islands");

        if(User::checkOwner()){
            return view("owner.profile-dashboard-founder", ['data' => $data]);
        }
        if (User::checkInvestor()){
            return view("investor.profile-dashboard-co-founder", ['data' => $data]);
        }

    }

    public function profileSave(Request $request){

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'photo' => 'image|max:2048',
        ]);


        $user = Auth::user();
        $user_id = $user->id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();

        $data = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'date_of_birth' => $request->get('date_of_birth'),
            'phone' => $request->get('code_phone') . ' ' . $request->get('phone'),
            'about_you' => $request->get('about_you'),
            'company_name' => $request->get('company_name'),
            'occupation' => $request->get('occupation'),
            'street' => $request->get('street'),
            'house' => $request->get('house'),
            'postal_code' => $request->get('postal_code'),
            'salutation' => $request->get('salutation'),
            'country' => $request->get('country'),
            'city' => $request->get('city'),
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = public_path('profile-photos/');
            $photo->move($path, $filename);
            $data['photo'] = 'profile-photos/' . $filename;
        }


        $data['new_project_email'] = empty($request->input('new_project_email')) ? false : true;
        $data['notification_email'] = empty($request->input('notification_email')) ? false : true;
        $data['nda_approved_email'] = empty($request->input('nda_approved_email')) ? false : true;

        $data['basic_interests_investor'] = $request->get('basic_interests_investor');
        $data['categorty1_investor'] = $request->get('categorty1_investor');
        $data['categorty2_investor'] = $request->get('categorty2_investor');
        $data['categorty3_investor'] = $request->get('categorty3_investor');

        $data['city_other'] = empty($request->input('city_other')) ? false : true;
        if( !empty($request->input('city_other'))  ){
            $data['city'] = $request->get('city_other_name');
        }



        $user->email = $request->get('email');
        $user->name = $request->get('first_name') . ' ' . $request->get('last_name');
        $user->save();

        if ($user_detail) {
            $user_detail->update($data);
        } else {
            $data['user_id'] = $user_id;
            UserDetail::create($data);

            if(User::checkInvestor()){
                // redirect public project page
                $retrievedValue = Session::get('id_project_view');
                Session::forget('id_project_view');
                if (!empty($retrievedValue) && isset($retrievedValue)){
                    return redirect(route("homeInvestor") . "?id_project=$retrievedValue");
                }
            }

            if(User::checkOwner()){
                return redirect(route("createProject"));
            }
        }

        if ($request->has('current_password') && $request->has('new_password') && $request->has('new_password_confirmation')){
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            if (Hash::check($request->current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->get('new_password')),
                ]);
            }else{
                return redirect()->back()->with('error', 'Invalid current password.');
            }
        }


        return redirect()->back()->with('success', 'Changes saved successfully!');

    }

    public function accountDeletionConfirmation(){
        return view('account-deletion-confirmation');
    }

    public function sendDeleteAccount(Request $request){

        accountDeletionConfirmation::create([
            'user_id' => Auth::id(),
        ]);

        $emails = [];
        $admins = User::where('role', 1)->get();
        if(!empty($admins)){
            foreach ($admins as $user) {
                $emails[] = $user->email;
            }
            try {
                //Mail::to($emails)->send(new MailAccountDeletionConfirmation());
                $text = 'User id:' . Auth::id() . ' sent a request to delete an account';
                $data = [
                    'subject' => '',
                    'first_name' => '',
                    'text_body' => '<p>' . $text . '</p>',
                    'text_before' => '',
                ];

                Mail::to($emails)->send(new MailTestTemplateBlade($data));

            } catch (\Exception $e) {
                $e->getMessage();
            }

        }

        return redirect(route("profile"))->with('success', 'Account deletion request sent!');
    }


    public function markAsRead($id){
        if($id == 'all'){
            NotificationsUsers::where('user_id', Auth::id())->update(['seen' => true]);
        }else{
            NotificationsUsers::where('id', $id)->update(['seen' => true]);
        }
        return response()->json(['message' => 'Notification status has been updated.']);
    }

    public function reportProblem(Request $request){
        $report = new ReportProblems([
            'form_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'project_id' => $request->project_id,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        $report->save();

        //add notification
        $emails = [];
        $name_user = Auth::user()->name;
        $text_notification = "New Problem Report by " . $name_user;

        $admin_id = User::where('role', 1)->get()->toArray();
        if(count($admin_id) > 0){
            foreach ($admin_id as $value){
                NotificationsUsers::create([
                    'user_id' => $value['id'],
                    'text' => $text_notification,
                ]);
                $emails[] = $value['email'];
            }

            //Email
            try {
                //$data = ['text' => $text_notification];
                //Mail::to($emails)->send(new MailReportProblem($data));

                $data = [
                    'subject' => '',
                    'first_name' => '',
                    'text_body' => '<p>' . $text_notification . '</p>',
                    'text_before' => '',
                ];

                Mail::to($emails)->send(new MailTestTemplateBlade($data));

            } catch (\Exception $e) {
                $e->getMessage();
            }

        }


        return response()->json(['message' => 'success']);
    }

    public function ajaxShareProject(Request $request){
        $project_id = $request->get('project_id');
        $project = Projects::where('id', $project_id)->first();

        $emailString = $request->get('email_list');
        $emails = explode(',', $emailString);
        $emails = array_map('trim', $emails);

        //Email
        try {
            $link = route("viewProjectPublic", ['id' => $project_id]);

            /*
            $data = [
                'text' => $text_notification,
                'title' => 'Share Project',
            ];
            Mail::to($emails)->send(new MailGeneralTemplate($data));
            */

            $text_notification = "User " . Auth::user()->name . " shared the " . $project->name_project . " project with you (follow the link for review: " . $link . ").";
            $data = [
                'subject' => '',
                'first_name' => '',
                'text_body' => '<p>' . $text_notification . '</p>',
                'text_before' => '',
            ];
            Mail::to($emails)->send(new MailTestTemplateBlade($data));



            return response()->json([
                'message' => 'success',
                'status' => '1',
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }

        return response()->json([
            'message' => 'Problem sending mail',
            'status' => '0',
        ]);
    }

    public function ajaxShareProfile(Request $request){
        $profile_id = $request->get('profile_id');
        $profile = User::where('id', $profile_id)->first();

        $emailString = $request->get('email_list');
        $emails = explode(',', $emailString);
        $emails = array_map('trim', $emails);

        //Email
        try {
            $link = route("viewProfilePublic", ['id' => $profile_id]);

            $text_notification = "Hi,\n" .
                "User " . Auth::user()->name . " shared the " . $profile->name . " profile with you (follow the link for review: " . $link . ").\n" .
                "Thank you,\n" .
                "Membership team\n" .
                "BeMyCoFounders.com";


            //$text_notification =  html_entity_decode(strip_tags($text_notification));
            /*
            $data = [
                'text' => $text_notification,
                'title' => 'Share Profile',
            ];
            Mail::to($emails)->send(new MailGeneralTemplate($data));
            */
            // substr($profile->name, 0, strlen($profile->name) / 2).'...'

            $text_notification = "User " . Auth::user()->name . " shared " . substr($profile->name, 0, strlen($profile->name) / 2).'' . " profile with you (follow the link for review: " . $link . ").";
            $data = [
                'subject' => '',
                'first_name' => '',
                'text_body' => '<p>' . $text_notification . '</p>',
                'text_before' => '',
            ];
            Mail::to($emails)->send(new MailTestTemplateBlade($data));


            return response()->json([
                'message' => 'success',
                'status' => '1',
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }

        return response()->json([
            'message' => 'Problem sending mail',
            'status' => '0',
        ]);
    }

    public function notifications(){
        $data['title_page'] = 'Notifications';

        $userId = Auth::id();
        //$userId = 14;

//        $perPage = 10;
//
//        $notifications = NotificationsUsers::where('user_id', $userId)
//            ->orderBy('seen', 'asc')
//            ->orderBy('id', 'desc')
//            ->paginate($perPage);
//
//        $data['notifications'] = $notifications;

        $nda_notifications = null;
        if(User::checkOwner()){
            $nda_notifications = NdaProjects::where('owner_pr_id', auth()->id())->where('seen', false)->where('status', 'pending')->get();
        }
        $data['nda_notifications'] = $nda_notifications;

        $notificationsChat = CustomMessagesController::getNotSeeMessage();
        $data['notificationsChat'] = $notificationsChat;

        return view("notifications", ['data' => $data]);

    }

    public function  notificationsAjax(Request $request){
        $offset = $request->input('offset', 0);
        $limit = 5;

        $notifications = NotificationsUsers::where('user_id', Auth::id())
            ->orderBy('seen', 'asc')
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $posts = [
            'data' => $notifications,
        ];

        return response()->json($posts);
    }

    public function viewProfileProjects($id, Request $request){
        $data['title_page'] = '';

        $user_detail = UserDetail::where('user_id', $id)->first();
        if (!$user_detail || !User::checkInvestor()){
            return redirect()->back();
        }
        $data['user'] = $user_detail;

        $data['projects'] = [];

        $data['open_projects'] = $request->get("view-projects", 0);

        if($data['open_projects']){
            $perPage = 6;

            $projects = Projects::where('user_id', $id)
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            $data['projects'] = $projects;

//            $currentUser = Auth::user();
//            if ($currentUser) {
//                $projects = $data['projects'];
//                foreach ($projects as $key => $project) {
//                    $projectID = $project->id;
//
//                    $ndaProject = NdaProjects::where('id_project', $projectID)
//                        ->where('user_id', $currentUser->id)
//                        ->where('status', 'signed')
//                        ->first();
//
//                    if (!$ndaProject) {
//                        $data['projects']->forget($key);
//                    }
//                }
//            }

            $data['favorite_project'] = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        }

        //data investor
        $investor = UserDetail::where('user_id', Auth::id())->first();
        $address_investor = '';
        if(!empty($investor->street) && !empty($investor->house) && !empty($investor->city) && !empty($investor->country)){
            $address_investor .= '(';

            $address_investor .= (new CountryController)->getNameCountry($investor->country);
            $address_investor .= ', ' . $investor->city;
            $address_investor .= ', ' . $investor->street;
            $address_investor .= ', ' . $investor->house;

            if(!empty($investor->postal_code)){
                $address_investor .= ', ' . $investor->postal_code;
            }

            $address_investor .= ')';
        }else{
            $address_investor .= '(';
            $user = User::where('id', $investor->user_id)->first();
            $address_investor .= $user->email;
            $address_investor .= ')';
        }
        $nda_address_investor = $investor->first_name . ' ' . $investor->last_name . ' ' . $address_investor;


        return view("profile-projects", [
            'data' => $data,
            'nda_address_investor' => $nda_address_investor,
        ]);
    }


}
