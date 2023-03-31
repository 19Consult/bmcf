<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProject;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Projects;
use App\Models\CategoryName;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NdaProjects;

class OwnerController extends Controller
{

    function __construct(){
//        if(!User::checkOwner()){
//            return redirect(route('home'));
//        }
    }

    public function profile(){

    }

    public function createProject(){

        if (User::checkInvestor()){
            return redirect(route("homeInvestor"));
        }

        $data['title_page'] = 'Create a project';

        $user = Auth::user();
        $user_id = $user->id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();

        $data['user_photo'] = $user_detail->photo;
        $data['first_name'] = $user_detail->first_name;
        $data['last_name'] = $user_detail->last_name;

        $data['category'] = CategoryName::all();

        return view("owner.dashboard-create-project", [
            'data' => $data,
        ]);
    }

    public function saveProject(Request $request){
        $data = [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role,
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
            $project = Projects::create($data);
        }else{
            $project = Projects::where('id', $request->input("id_project"))->first();
            $project->update($data);
        }

        return redirect(route("viewProject", ['id' => $project->id]));
    }

    public function viewProject($id){

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

        $data['category'] = CategoryName::all();

        return view("owner.dashboard-create-project", [
            'data' => $data,
            'id_project' => $id,
        ]);
    }

    public function ndaList(){
        $data['title_page'] = 'NDA List';

        $data['user_detail'] = UserDetail::where('user_id', Auth::id())->first();

        $data['nda_list'] = [];

        $projectIds = Projects::where('user_id', Auth::id())->pluck('id');
        if (!empty($projectIds)){
            $projectIds = $projectIds->toArray();

            $projects = NdaProjects::whereIn('id_project', $projectIds)->get();

            foreach ($projects as $val){
                $data['nda_list'][] = [
                    'nda' => $val,
                    'project' => Projects::where('id', $val->id_project)->first(),
                    'investor' => UserDetail::where('user_id', $val->user_id)->first(),
                ];
            }

//            dd($data['nda_list']);
        }


//        $data['nda_list'] = [];
//        $data['user_detail'] = UserDetail::where('user_id', Auth::id())->first();
//
//        $r = NdaProjects::where("user_id", Auth::id())->get();
//        foreach ($r as $val){
//            $data['nda_list'][] = [
//                'nda' => $val,
//                'project' => Projects::where('id', $val->id_project)->first(),
//                'owner' => UserDetail::where('user_id', $val->user_id)->first(),
//            ];
//        }

        return view('owner.nda-list', ['data' => $data]);
    }


    public function ajaxProjectDetails (Request $request){

        // Получаем id попапа из клика пользователя
        $project_id = $request->get('project_id');
        $project_detail = Projects::where('id', $project_id)->first();
        $user_deteils = UserDetail::where('user_id', $project_detail->user_id)->first();

        return response()->json([
            'message' => 'Successfully!',
            'project_detail' => $project_detail,
            'user_deteils' => $user_deteils,
        ]);
    }

    public function confirmNdaProject(Request $request){
        $project_id = $request->get('project_id');

        $ndaProjects = NdaProjects::where('id_project', $project_id)->first();

        $ndaProjects->update([
            'status' => 'signed',
            'signature_owner' => $request->get('signature_owner'),
            'data_signature_owner' => date("Y-m-d H:i:s"),
        ]);

        return redirect()->back();

    }

    public function rejectedNdaProject(Request $request){
        $project_id = $request->get('project_id');

        $ndaProjects = NdaProjects::where('id_project', $project_id)->first();

        $ndaProjects->update([
            'status' => 'rejected',
            'signature_owner' => '',
            'data_signature_owner' => null,
        ]);

        return redirect()->back();

    }

}
