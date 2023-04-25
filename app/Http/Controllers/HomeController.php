<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\CategoryName;
use App\Models\accountDeletionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAccountDeletionConfirmation;
use App\Models\Projects;
use App\Models\NotificationsUsers;
use App\Models\ReportProblems;

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
        $data['title_page'] = 'My Profile';
        $data['user'] = Auth::user();
        $data['userDetail'] = null;

        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        if ($user_detail){
            $data['userDetail'] = $user_detail;
        }

        $data['category'] = CategoryName::all();

        $data['allCountry'] = (new CountryController)->allCountries();
        unset($data['allCountry']['EU']);

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


//            $user_module = User::where('id', $user_id)->first();
//            // сохраняем в storage-директории
//            $path_storage = storage_path('app/public/users-avatar/');
//            $photo->move($path_storage, $filename);
//            $user_module->avatar = $filename;
//            $user_module->save();


        }


        $data['new_project_email'] = empty($request->input('new_project_email')) ? false : true;
        $data['notification_email'] = empty($request->input('notification_email')) ? false : true;
        $data['nda_approved_email'] = empty($request->input('nda_approved_email')) ? false : true;

        $data['basic_interests_investor'] = $request->get('basic_interests_investor');
        $data['categorty1_investor'] = $request->get('categorty1_investor');
        $data['categorty2_investor'] = $request->get('categorty2_investor');
        $data['categorty3_investor'] = $request->get('categorty3_investor');


        $user->email = $request->get('email');
        $user->name = $request->get('first_name') . ' ' . $request->get('last_name');
        $user->save();

        if ($user_detail) {
            $user_detail->update($data);
        } else {
            $data['user_id'] = $user_id;
            UserDetail::create($data);
            if(User::checkOwner()){
                return redirect(route("createProject"));
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
                Mail::to($emails)->send(new MailAccountDeletionConfirmation());
            } catch (\Exception $e) {
                $e->getMessage();
            }

        }

        return redirect(route("profile"))->with('success', 'Account deletion request sent!');
    }

//    public function chatView(){
//        return view('chat-view');
//    }

    public function markAsRead($id){
        NotificationsUsers::where('id', $id)->update(['seen' => true]);
        return response()->json(['message' => 'Notification status has been updated.']);
    }

    public function reportProblem(Request $request){
        $report = new ReportProblems([
//            'user_id' => auth()->user()->id,
//            'project_id' => $request->project_id,
//            'type' => $request->type,
//            'description' => $request->description,

            'form_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'project_id' => $request->project_id,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        $report->save();

        return response()->json(['message' => 'success']);
    }

}
