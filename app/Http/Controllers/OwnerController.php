<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProject;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Projects;
use App\Models\CategoryName;
use App\Models\NotificationsUsers;
use App\Models\FavoriteProfileOwner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NdaProjects;
use App\Models\ProjectsViews;
use Illuminate\Support\Facades\Mail;

use App\Mail\MailSendInvestorDeleteProject;
use App\Mail\NdaSendMailInvestor;
use App\Mail\MailRejectedNdaProject;
use App\Mail\MailTestTemplateBlade;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\URL;

class OwnerController extends Controller
{

    function __construct(){

    }

    public function profile(){

    }

    public function createProject(){

        if (User::checkInvestor()){
            return redirect(route("homeInvestor"));
        }

        if ( Projects::countProjects() > Projects::getCountAssetProjects() ){
            return redirect()->back();
        }


        $data['title_page'] = 'Create a project';

        $user = Auth::user();
        $user_id = $user->id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();

        $data['user_photo'] = $user_detail->photo;
        $data['first_name'] = $user_detail->first_name;
        $data['last_name'] = $user_detail->last_name;

        //$data['category'] = CategoryName::all();
        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();

        return view("owner.dashboard-create-project", [
            'data' => $data,
        ]);
    }

    public function saveProject(Request $request){
        $data = [
            'name_project' => $request->get("name_project"),
            'brief_description' => $request->get("brief_description_project"),
            'keyword1' => $request->get("keyword1"),
            'keyword2' => $request->get("keyword2"),
            'keyword3' => $request->get("keyword3"),
            'project_story' => $request->get("content_project_story"),
            'video_skip' => empty($request->input('video_skip')) ? false : true,
            'youtube_link' => $request->get("youtube_link"),
            'vimeo_link' => $request->get("vimeo_link"),
            'business_plan_skip' => empty($request->input('business_plan_skip')) ? false : true,
            'business_plan' => $request->get("content_business_plan"),
            'co_founder_terms_condition' => $request->get("co_founder_terms_condition"),
        ];

        if ($request->hasFile('photo_project')) {
            $photo = $request->file('photo_project');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = public_path('project-photos/');
            $photo->move($path, $filename);
            $data['photo_project'] = 'project-photos/' . $filename;
        }

        if($request->input("id_project") == 0){

            $project = new Projects();
            $project->user_id = Auth::id();
            $project->user_role = Auth::user()->role;
            $project->save();

            $project->update($data);

            // Add notifications
            $keywords = [$project->keyword1, $project->keyword2, $project->keyword3];
            $userIds = UserDetail::where(function($query) use ($keywords) {
                    $query->whereIn('categorty1_investor', $keywords)
                        ->orWhereIn('categorty2_investor', $keywords)
                        ->orWhereIn('categorty3_investor', $keywords);
                })
                ->pluck('user_id');

            $notificationsUsers = collect();
            $text_notification = "A new project added \"" . $project->name_project . "\" matches your interest";
            foreach ($userIds as $userId) {
                $notificationsUsers->push([
                    'user_id' => $userId,
                    'text' => $text_notification,
                ]);
            }
            NotificationsUsers::insert($notificationsUsers->toArray());
            //

        }else{
            $project = Projects::where('id', $request->input("id_project"))->first();
            $project->update($data);
        }

        //return redirect(route("viewProject", ['id' => $project->id]));
        return redirect(route("dashboardOwner"));
    }

    public function viewProject($id){

        $retrievedValue = Session::get('id_project_view');
        if (!empty($retrievedValue) && isset($retrievedValue)){
            Session::forget('id_project_view');
        }

        $check_asses = NdaProjects::where('user_id', Auth::id())->where("id_project", $id)->first();

        if (User::checkInvestor()){
            if (empty($check_asses) || $check_asses->status != 'signed'){
                return redirect()->back();
            }
        }


        $data['title_page'] = 'Project';
        $user = Auth::user();
        $user_id = $user->id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();
        $data['user_photo'] = $user_detail->photo;
        $data['first_name'] = $user_detail->first_name;
        $data['last_name'] = $user_detail->last_name;
        $data['about_you'] = $user_detail->about_you;
        $data['project'] = Projects::where('id', $id)->first();

        if (User::checkOwner() && $data['project']->user_id != Auth::id()){
            return redirect()->back();
        }

        if (User::checkInvestor()){
            $user_detail = UserDetail::where('user_id', $data['project']->user_id)->first();
            $data['user_photo'] = $user_detail->photo;
            $data['first_name'] = $user_detail->first_name;
            $data['last_name'] = $user_detail->last_name;
            $data['about_you'] = $user_detail->about_you;
            $data['favorite_project'] = FavoriteProject::where('user_id', Auth::id())->where('project_id', $data['project']->id)->first();
            return view("investor.dashboard-project", [
                'data' => $data,
                'id_project' => $id,
            ]);
        }

        //$data['category'] = CategoryName::all();
        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();

        return view("owner.dashboard-create-project", [
            'data' => $data,
            'id_project' => $id,
        ]);
    }

    public function ndaList(){

        if (User::checkInvestor()){
            return redirect(route("ndaListInvestor"));
        }

        $data['title_page'] = 'NDA List';

        $data['user_detail'] = UserDetail::where('user_id', Auth::id())->first();
        if(empty($data['user_detail'])){
            return redirect(route("profile"));
        }

        $data['nda_list'] = [];

        $projectIds = Projects::where('user_id', Auth::id())->pluck('id');
        if (!empty($projectIds)){
            $projectIds = $projectIds->toArray();

            $projects = NdaProjects::whereIn('id_project', $projectIds)->get();

            foreach ($projects as $val){
                $user_detail = UserDetail::where('user_id', $val->user_id)->first();
                if(!isset($user_detail) && empty($user_detail)){
                    continue;
                }
                $data['nda_list'][] = [
                    'nda' => $val,
                    'project' => Projects::where('id', $val->id_project)->first(),
                    'investor' => $user_detail,
                ];
            }

        }

        $name_company_owner = '';
        if(!empty($data['user_detail']) && isset($data['user_detail']->company_name)){
            $name_company_owner = '(' . $data['user_detail']->company_name . ')';
        }
        $nda_owner_name = $data['user_detail']->first_name . ' ' . $data['user_detail']->last_name . ' ' . $name_company_owner;

        return view('owner.nda-list', ['data' => $data, 'nda_owner_name' => $nda_owner_name]);
    }


    public function ajaxProjectDetails (Request $request){

        // Получаем id попапа из клика пользователя
        $project_id = $request->get('project_id');

        $data_nda_id = $request->get('data_nda_id');
        $ndaProjects = NdaProjects::where('id', $data_nda_id)->first();
        $user_investor = UserDetail::where('user_id', $ndaProjects->user_id)->first();

        $project_detail = Projects::where('id', $project_id)->first();
        $user_deteils = UserDetail::where('user_id', $project_detail->user_id)->first();


        $address_investor = '';
        $investor = $user_investor;
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
        $nda_investor_name = $investor->first_name . ' ' . $investor->last_name . ' ' . $address_investor;


        return response()->json([
            'message' => 'Successfully!',
            'project_detail' => $project_detail,
            'user_deteils' => $user_deteils,
            'nda_projects' => $ndaProjects,
            'user_investor' => $user_investor,
            'nda_investor_name' => $nda_investor_name,
        ]);
    }

    public function confirmNdaProject(Request $request){

        $request->validate([
            'signature_owner' => [
                'required',
                'string',
            ],
        ]);


        $project_id = $request->get('project_id');
        $data_nda_id = $request->get('nda_id');

        $ndaProjects = NdaProjects::where('id', $data_nda_id)->first();

        $ndaProjects->update([
            'status' => 'signed',
            'signature_owner' => $request->get('signature_owner'),
            'data_signature_owner' => date("Y-m-d H:i:s"),
        ]);

        //add notification
        $project_detail = Projects::where('id', $project_id)->first();
        $text_notification = "Status changed to " . $ndaProjects->status . " for project " . $project_detail->name_project;

        $url = route('ndaList');
        $path = URL::to($url);
        $baseUrl = URL::to('/');
        $url_link = str_replace($baseUrl, '', $path);

        NotificationsUsers::create([
            'user_id' => $ndaProjects->user_id,
            'text' => $text_notification,
            'url' => $url_link,
        ]);

        try {

            $user_investor_id = $ndaProjects->user_id;
            $user_investor_info = User::where('id', $user_investor_id)->first();
            $user_investor_email = $user_investor_info->email;

//            $data = ['project_id' => $project_id, 'user_name' => $user_investor_info->name];
//            Mail::to($user_investor_email)->send(new NdaSendMailInvestor($data));

            $data = [
                'subject' => '',
                'first_name' => $user_investor_info->name,
                'text_body' => '<p>Your request to the project access was approved. Please, <a href="' . route("viewProject", ['id' => $project_id]) . '">click here</a></p>',
                'text_before' => '',
            ];

            Mail::to($user_investor_email)->send(new MailTestTemplateBlade($data));

        } catch (\Exception $e) {
            $e->getMessage();
        }

        return redirect()->back();

    }

    public function rejectedNdaProject(Request $request){
        $project_id = $request->get('project_id');
        $data_nda_id = $request->get('nda_id');

        $ndaProjects = NdaProjects::where('id', $data_nda_id)->first();

        $ndaProjects->update([
            'status' => 'rejected',
            'signature_owner' => '',
            'data_signature_owner' => null,
        ]);

        //add notification
        $project_detail = Projects::where('id', $project_id)->first();
        $text_notification = "Status changed to " . $ndaProjects->status . " for project " . $project_detail->name_project;

        $url = route('ndaList');
        $path = URL::to($url);
        $baseUrl = URL::to('/');
        $url_link = str_replace($baseUrl, '', $path);

        NotificationsUsers::create([
            'user_id' => $ndaProjects->user_id,
            'text' => $text_notification,
            'url' => $url_link,
        ]);

        //Email
        try {
            $user = User::where('id', $ndaProjects->user_id)->first();
            $user_email = $user->email;
            //$data = ['text' => $text_notification];
            //Mail::to($user_email)->send(new MailRejectedNdaProject($data));

            $data = [
                'subject' => '',
                'first_name' => $user->name,
                'text_body' => '<p>' . $text_notification . '</p>',
                'text_before' => '',
            ];

            Mail::to($user_email)->send(new MailTestTemplateBlade($data));

        } catch (\Exception $e) {
            $e->getMessage();
        }

        return redirect()->back();

    }

    public function deleteProjectPreview($id_project){
        $t = Projects::where('id', $id_project)->where('user_id', Auth::id())->first();
        if(!empty($t)){
            return view('owner.delete-project-preview', ['id_project' => $id_project]);
        }
        return redirect()->back();
    }

    public function deleteProject(Request $request){
        $project_id = $request->get('id_project');
        $project = Projects::where('id', $project_id)->where('user_id', Auth::id())->first();
        if(!empty($project)){

            $nda = NdaProjects::where('id_project', $project_id)->get();
            foreach ($nda as $val){
                $user_id = $val->user_id;
                $user = User::where('id', $user_id)->first();
                $user_email = $user->email;

                $text_notification = "The " . $project->name_project . " is now removed";
                NotificationsUsers::create([
                    'user_id' => $user_id,
                    'text' => $text_notification,
                ]);

               // $data_mail = ['project_name' => $project->name_project];

                try {
                    //Mail::to($user_email)->send(new MailSendInvestorDeleteProject($data_mail));

                    $data = [
                        'subject' => '',
                        'first_name' => $user->name,
                        'text_body' => '<p>The ' . $project->name_project . ' is now removed by owner and all terms of your NDA remain in effect.</p>',
                        'text_before' => '',
                    ];

                    Mail::to($user_email)->send(new MailTestTemplateBlade($data));

                } catch (\Exception $e) {
                    $e->getMessage();
                }

            }

            /**
             * project_views+
             * nda_project+
             * projects+
             */
            ProjectsViews::where('project_id', $project_id)->delete();
            NdaProjects::where('id_project', $project_id)->delete();
            $project->delete();
        }
        return redirect(route('home'));
    }

    public function seenNdaProject(Request $request){
        $data_nda_id = $request->get('data_nda_id');
        $ndaProjects = NdaProjects::where('id', $data_nda_id)->first();

        $ndaProjects->update([
            'seen' => true,
        ]);

        return response()->json([
            'message' => 'Successfully! Notification',
        ]);
    }

    public function dashboardOwner(Request $request){

        if (User::checkAdmin()){
            return redirect(route("admin.dashboard"));
        }

        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        if (!$user_detail && !User::checkAdmin()){
            return redirect(route("profile"));
        }

        $data['title_page'] = 'Owner Dashboard';

        if (User::checkInvestor()){
            return redirect(route("dashboardInvestor"));
        }

        $categories = $request->input('categories');
        $search_keyword = $request->input('search_keyword');
        $sort_by = $request->input('sort_by', 'created_at');
        $sort_order = $request->input('sort_order', 'desc');
        $items_per_page = $request->input('items_per_page', 3);

        $query = Projects::query();
        $query->where('user_id', Auth::id());
        if ($categories) {
            $query->where('keyword1', 'LIKE', '%' . $categories . '%')
                ->orWhere('keyword2', 'LIKE', '%' . $categories . '%')
                ->orWhere('keyword3', 'LIKE', '%' . $categories . '%');
        }

        if ($search_keyword) {
            $query->where(function ($query) use ($search_keyword) {
                $query->where('name_project', 'LIKE', "%{$search_keyword}%")
                    ->orWhere('brief_description', 'LIKE', "%{$search_keyword}%")
                    ->orWhere('project_story', 'LIKE', "%{$search_keyword}%")
                    ->orWhere('business_plan', 'LIKE', "%{$search_keyword}%")
                    ->orWhere('co_founder_terms_condition', 'LIKE', "%{$search_keyword}%");
            });
        }

        $query->orderBy($sort_by, $sort_order);

        $data['projects'] = $query->paginate($items_per_page);

        //$data['category'] = CategoryName::all();
        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();

        $data['favorite_project'] = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        $data['nda_list'] = NdaProjects::where('owner_pr_id', Auth::id())
            ->where('status', 'signed')
            ->latest()
            ->take(3)
            ->get();

        $using_ajax_angel_nda = $data['nda_list']->pluck('user_id')->toArray();
        $using_ajax_angel_nda = array_unique($using_ajax_angel_nda);
        session(['using_ajax_angel_nda' => $using_ajax_angel_nda]);

        return view("owner.dashboard-owner", [
            'data' => $data,
            'search_keyword' => $search_keyword,
            'categories' => $categories,
        ]);

    }

    public function dashboardAgentsLoad(Request $request){
        $offset = $request->input('offset', 0);
        $limit = 5;

        //$data['angel_suggest'] = [];
        $user_id = Auth::id();

        $keywords_angel_sug = Projects::where('user_id', $user_id)
            ->select('keyword1', 'keyword2', 'keyword3')
            ->distinct()
            ->pluck('keyword1')
            ->concat(Projects::where('user_id', $user_id)
                ->select('keyword2')
                ->distinct()
                ->pluck('keyword2'))
            ->concat(Projects::where('user_id', $user_id)
                ->select('keyword3')
                ->distinct()
                ->pluck('keyword3'))
            ->unique()
            ->values()
            ->all();

        if($keywords_angel_sug && !empty($keywords_angel_sug)){
            $keywords_angel_sug = array_diff($keywords_angel_sug, array(null));

            $userIds = UserDetail::where(function($query) use ($keywords_angel_sug) {
                $query->whereIn('categorty1_investor', $keywords_angel_sug)
                    ->orWhereIn('categorty2_investor', $keywords_angel_sug)
                    ->orWhereIn('categorty3_investor', $keywords_angel_sug);
            })->pluck('user_id');

        }


        //$userIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];


        $using_ajax_angel_nda = session('using_ajax_angel_nda');
        $userIds = array_diff($userIds->toArray(), $using_ajax_angel_nda);


        $users = User::whereIn('id', $userIds)
            ->with('detail')
            ->whereHas('detail')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $data = [];
        foreach ($users as $user){

            $country = isset($user->detail->country) ? (new CountryController)->getNameCountry($user->detail->country) : '';

            $data[] = [
                'users_angel' => $user,
                'link_angel' => route("viewProfilePublic", ["id" => $user->id]),
                'country_angel' => $country,
                'user_photo' => isset($user->detail->photo) ? asset($user->detail->photo) : asset('img/project-img.webp'),
            ];
        }

        $posts = [
          'data' => $data,
        ];

        return response()->json($posts);
    }

    public function profilePublicFavorite(Request $request){

        if(!User::checkOwner()){
            return false;
        }

        $owner_id = $request->get('owner_id');
        $investor_id = $request->get('investor_id');

        $favorite_profile = FavoriteProfileOwner::where('owner_id', $owner_id)->where('investor_id', $investor_id)->first();

        if(!$favorite_profile){
            $favorite_profile = FavoriteProfileOwner::create([
                'owner_id' => $owner_id,
                'investor_id' => $investor_id,
            ]);


            $text_notification = "You received the Like from " . Auth::user()->name;
            $url = route('viewProfileProjects', ['id' => $owner_id]);
            $path = URL::to($url);
            $baseUrl = URL::to('/');
            $url_link = str_replace($baseUrl, '', $path);

            NotificationsUsers::create([
                'user_id' => $investor_id,
                'text' => $text_notification,
                'url' => $url_link,
                'type' => 'like',
            ]);

            return response()->json(['success' => true, 'data' => $favorite_profile]);
        }else{
            $favorite_profile->delete();
            return response()->json(['success' => false, 'data' => $favorite_profile]);
        }
    }


}
