<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\ProjectsViews;
use App\Models\FavoriteProject;
use App\Models\CategoryName;
use App\Models\NdaProjects;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use PDF;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\NdaSendMailRequest;
use App\Mail\MailTestTemplateBlade;

//use Barryvdh\DomPDF\PDF;

class InvestorController extends Controller
{

    //private $myData;

    public function indexInvestor( Request $request)
    {
        if (User::checkAdmin()){
            return redirect(route("admin.dashboard"));
        }

        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        if (!$user_detail && !User::checkAdmin()){
            return redirect(route("profile"));
        }
        $data['title_page'] = 'Search Projects';
        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        $data['user_photo'] = $user_detail->photo;

//        $data['projects'] = Projects::all();


        $categories = $request->input('categories');
        $search_keyword = $request->input('search_keyword');
        $sort_by = $request->input('sort_by', 'created_at');
        $sort_order = $request->input('sort_order', 'desc');
        $items_per_page = $request->input('items_per_page', 10);

        $query = Projects::query();

        $session_query_id_project = $request->input('id_project', 0);
        if($session_query_id_project != 0){
            $query->where('id', $session_query_id_project);
        }


        if ($categories) {
//            $query->whereIn('category', $categories);

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
                    ->orWhere('co_founder_terms_condition', 'LIKE', "%{$search_keyword}%")

                    ->orWhere('keyword1', 'LIKE', '%' . $search_keyword . '%')
                    ->orWhere('keyword2', 'LIKE', '%' . $search_keyword . '%')
                    ->orWhere('keyword3', 'LIKE', '%' . $search_keyword . '%');
            });
        }

        $query->orderBy($sort_by, $sort_order);

        $data['projects'] = $query->paginate($items_per_page);

        $currentUser = Auth::user();
        if ($currentUser) {
            $projects = $data['projects'];
            foreach ($projects as $key => $project) {
                $projectID = $project->id;

                $ndaProject = NdaProjects::where('id_project', $projectID)
                    ->where('user_id', $currentUser->id)
                    ->where('status', 'signed')
                    ->first();

                if (!$ndaProject) {
                    //$data['projects']->forget($project->id);
                    $data['projects']->forget($key);
                }
            }
        }


        //$data['category'] = CategoryName::all();
        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();


        $data['favorite_project'] = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

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

        return view('home-investor', ['data' => $data, 'search_keyword' => $search_keyword, 'categories' => $categories, 'nda_address_investor' => $nda_address_investor]);
    }

    public function counterProjectsViews (Request $request){

        if (User::checkAdmin()){
            return response()->json([
                'message' => 'Admin',
            ]);
        }

        // Получаем id попапа из клика пользователя
        $project_id = $request->get('project_id');

        // Ищем запись в базе данных для этого попапа
        $project_view = ProjectsViews::where('project_id', $project_id)->first();

        if (!$project_view) {
            // Если записи нет, то создаем новую запись
            $project_view = new ProjectsViews();
            $project_view->project_id = $project_id;
        }

        // Обновляем счетчики просмотров
        $project_view->total_views++;
        $project_view->today_views++;

        // Сбрасываем счетчик просмотров за сегодня, если это первый просмотр сегодня
        if (!empty($project_view->updated_at) && $project_view->updated_at->lt(Carbon::today())) {
            $project_view->today_views = 0;
        }

        // Сохраняем запись в базу данных
        $project_view->save();

        $project_detail = Projects::where('id', $project_id)->first();
        $user_deteils = UserDetail::where('user_id', $project_detail->user_id)->first();

        $favorite_project = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        $check_asses_status = null;
        $check_asses = NdaProjects::where('user_id', Auth::id())->where("id_project", $project_id)->first();
        if (!empty($check_asses) && isset($check_asses)){
            $check_asses_status = $check_asses->status;
        }


        return response()->json([
            'message' => 'Successfully!',
            'data' => $project_view,
            'project_detail' => $project_detail,
            'user_deteils' => $user_deteils,
            'favorite_bool' => in_array($project_id, $favorite_project),
            'check_asses_status' => $check_asses_status,
            ]);
    }

    public function favoriteProject(Request $request){

        $project_id = $request->get('project_id');

        $favorite_project = FavoriteProject::where('project_id', $project_id)->where('user_id', Auth::id())->first();

        if(!$favorite_project){
            FavoriteProject::create([
                'user_id' => Auth::id(),
                'project_id' => $project_id,
            ]);
            return response()->json(['success' => true, 'data' => $favorite_project, 'project_id' => $project_id]);
        }else{
            $favorite_project->delete();
            return response()->json(['success' => false, 'data' => $favorite_project, 'project_id' => $project_id]);
        }
    }

    public function viewProjectFavorites(){
        if (User::checkAdmin()){
            return redirect(route("admin.dashboard"));
        }
        $data['title_page'] = 'Favorite Projects';

        $favorite_project = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        $data['projects'] = Projects::whereIn('id', $favorite_project)->get();

//        var_export($data);

        return view('investor.dashboard-project-favorites', ['data' => $data]);
    }

    public function saveNdaProject(Request $request){

        $request->validate([
            'signature' => [
                'required',
                'string',
            ],
        ]);

        $project_detail = Projects::where('id', $request->input('id_project'))->first();

        $data = [
            'user_id' => Auth::id(),
            'id_project' => $request->input('id_project'),
            'signature' => $request->input('signature'),
            'date' => $request->input('date'),
            'disclosing' => $request->input('disclosing'),
            'disclosing_mail' => $request->input('disclosing_mail'),
            'receiving' => $request->input('receiving'),
            'receiving_mail' => $request->input('receiving_mail'),
            'status' => 'pending',
            'owner_pr_id' => $project_detail->user_id,
        ];

        $nda = NdaProjects::where('user_id', Auth::id())->where('id_project', $request->input('id_project'))->first();

        if(!$nda){
            $ndaProjects = NdaProjects::create($data);
        }else{
            $nda->update($data);
            $ndaProjects = $nda;
        }



        try {

            //$project_detail = Projects::where('id', $ndaProjects->id_project)->first();
            $user_info = User::where('id', $project_detail->user_id)->first();
            $user_detail = UserDetail::where('user_id', $project_detail->user_id)->first();
            $email = $user_info->email;
            //$data = ['name' => $user_detail->first_name];
            //Mail::to($email)->send(new NdaSendMailRequest($data));

            //You have documents to review. Please <a href="{{route("ndaList")}}">click</a> here

            $data = [
                'subject' => '',
                'first_name' => $user_detail->first_name,
                'text_body' => '<p>You have documents to review. Please <a href="' . route("ndaList") . '">click here</a></p>',
                'text_before' => '',
            ];

            Mail::to($email)->send(new MailTestTemplateBlade($data));

        } catch (\Exception $e) {
            $e->getMessage();
        }

        if ($ndaProjects){
            return redirect(route("viewProject", ['id' => $ndaProjects->id_project]));
        }else{
            return redirect()->back();
        }
    }

    public function ndaListInvestor(){

        if (User::checkOwner()){
            return redirect(route("ndaList"));
        }

        $data['title_page'] = 'NDA List';

        $data['nda_list'] = [];
        $data['user_detail'] = UserDetail::where('user_id', Auth::id())->first();

        $r = NdaProjects::where("user_id", Auth::id())->get();


        foreach ($r as $val){
            $project = Projects::where('id', $val->id_project)->first();
            $data['nda_list'][] = [
              'nda' => $val,
              'project' => $project,
              'owner' => UserDetail::where('user_id', $project->user_id)->first(),
            ];
        }

        return view('investor.nda-list-investor', ['data' => $data]);
    }

    public function downloadNda($nda_id){

        $nda = NdaProjects::where('id', $nda_id)->first();

        $project = Projects::where('id', $nda->id_project)->first();

        $investor = UserDetail::where('user_id', $nda->user_id)->first();

        $owner = UserDetail::where('user_id', $project->user_id)->first();

        $name_company_owner = '';
        if(!empty($owner) && isset($owner->company_name)){
            $name_company_owner = '(' . $owner->company_name . ')';
        }

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


        $date_ins = date_create_from_format('Y-m-d H:i:s', $nda->data_signature_owner);
        $insert_data = $date_ins->format('F j, Y');

        $pdf = Pdf::loadView('pdf.nda_pdf_template', [
            'date' => $nda->date,
            'disclosing' => $nda->disclosing,
            'disclosing_mail' => $nda->disclosing_mail,
            'receiving' => $nda->receiving,
            'receiving_mail' => $nda->receiving_mail,
            'signature' => $nda->signature,
            'signature_owner' => $nda->signature_owner,
            'insert_number' => '3',
            'country' => 'England',
            'name_of_the_project' => $project->name_project,
            'name_of_the_investor' => $investor->first_name . ' ' . $investor->last_name . ' ' . $address_investor,
            'name_of_project_owner_and_company_if_included' => $owner->first_name . ' ' . $owner->last_name . ' ' . $name_company_owner,
            'insert_data' => $insert_data,
        ]);
        return $pdf->download('nda_' . $nda->id . '.pdf');

    }

    public function dashboardInvestor(Request $request){

        if (User::checkAdmin()){
            return redirect(route("admin.dashboard"));
        }

        $data['title_page'] = 'Angel Dashboard';

        if (User::checkOwner()){
            return redirect(route("dashboardOwner"));
        }

        $nda_list = NdaProjects::where('user_id', Auth::id())
            ->where('status', 'signed')
            ->latest()
            ->take(3)
            ->pluck('id_project')
            ->toArray();

        $data['single_nda_project'] = Projects::where('id', $nda_list)->get();
        $data['favorite_project'] = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        $user = Auth::user()->detail;

//        $keywords = [$user->categorty1_investor, $user->categorty2_investor, $user->categorty3_investor];
//        //dd($keywords);
//        $projects_int = Projects::where(function($query) use ($keywords) {
//            $query->whereIn('keyword1', $keywords)
//                ->orWhereIn('keyword2', $keywords)
//                ->orWhereIn('keyword3', $keywords);
//        })->get();
//        $data['projects_int'] = $projects_int;

        //$data['category'] = CategoryName::all();
        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();

        $categories = $request->input('categories');
        $search_keyword = $request->input('search_keyword');
        $sort_by = $request->input('sort_by', 'created_at');
        $sort_order = $request->input('sort_order', 'desc');
        $items_per_page = $request->input('items_per_page', 3);

        //Current id project
        $current_id_project = $request->input('id_project', 0);


        //Search
        if(isset($categories) || isset($search_keyword) || $current_id_project != 0){
            $query = Projects::query();

            if($current_id_project != 0){
                $query->where('id', $current_id_project);
            }

            //$query->where('user_id', Auth::id());
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
                        ->orWhere('co_founder_terms_condition', 'LIKE', "%{$search_keyword}%")

                        ->orWhere('keyword1', 'LIKE', '%' . $search_keyword . '%')
                        ->orWhere('keyword2', 'LIKE', '%' . $search_keyword . '%')
                        ->orWhere('keyword3', 'LIKE', '%' . $search_keyword . '%');
                });
            }
            $query->orderBy($sort_by, $sort_order);
            $data['projects_int'] = $query->paginate($items_per_page);
            //dd($data['projects_int']);
        }else{
            $keywords = [$user->categorty1_investor, $user->categorty2_investor, $user->categorty3_investor];
            //dd($keywords);
            $projects_int = Projects::where(function($query) use ($keywords) {
                $query->whereIn('keyword1', $keywords)
                    ->orWhereIn('keyword2', $keywords)
                    ->orWhereIn('keyword3', $keywords);
            })->get();
            $data['projects_int'] = $projects_int;

            //Delete signet project with list interests
            $currentUser = Auth::user();
            //if ($currentUser) {
                $projects = $data['projects_int'];
                foreach ($projects as $key => $project) {

                    $projectID = $project->id;
                    $ndaProject = NdaProjects::where('id_project', $projectID)
                        ->where('user_id', $currentUser->id)
                        ->where('status', 'signed')
                        ->first();

                    if ($ndaProject) {
                        $data['projects_int']->forget($key);
                    }
                }
            //}
            if (count($data['projects_int']) > 3) {
                $keys = $data['projects_int']->keys()->toArray();
                $keysToRemove = array_slice($keys, 3);

                foreach ($keysToRemove as $key) {
                    unset($data['projects_int'][$key]);
                }
            }


            $using_ajax_projects = $data['projects_int']->pluck('id')->toArray();
            session(['using_ajax_projects' => $using_ajax_projects]);

            //--

        }

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

        return view("investor.dashboard-investor", [
            'data' => $data,
            'search_keyword' => $search_keyword,
            'categories' => $categories,
            'nda_address_investor' => $nda_address_investor
        ]);

    }

    public function dashboardProjectsLoad(Request $request){

        $offset = $request->input('offset', 0);
        $limit = 5;
        //$limit = 1;

        try{
        $favorite_project = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        $user = Auth::user()->detail;

        $keywords = [$user->categorty1_investor, $user->categorty2_investor, $user->categorty3_investor];
        //dd($keywords);
        $projects_int = Projects::where(function($query) use ($keywords) {
            $query->whereIn('keyword1', $keywords)
                ->orWhereIn('keyword2', $keywords)
                ->orWhereIn('keyword3', $keywords);
        })->get();

        $data['projects_int'] = $projects_int;

        //Delete signet project with list interests
        $currentUser = Auth::user();
        if ($currentUser) {
            $projects = $data['projects_int'];
            foreach ($projects as $key => $project) {
                $projectID = $project->id;
                $ndaProject = NdaProjects::where('id_project', $projectID)
                    ->where('user_id', $currentUser->id)
                    ->where('status', 'signed')
                    ->first();

                if ($ndaProject) {
                    $data['projects_int']->forget($key);
                }
            }
        }

        $id_projects_more = $data['projects_int']->pluck('id')->toArray();

        //$data_ajax['using_ajax_projects'] = $using_ajax_projects;
        // using load page
        $using_ajax_projects = session('using_ajax_projects');
        //delete id using projects
        $id_projects_more = array_diff($id_projects_more, $using_ajax_projects);


        $list_projects_more = Projects::whereIn('id', $id_projects_more)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $data_ajax = [];


        foreach ($list_projects_more as $key => $val){
            $views = $val->views->first();
            $ndaList = NdaProjects::where('id_project', $val->id)->where('status', 'signed')->pluck('user_id')->toArray();
            $photo = isset($val->photo_project) ? asset($val->photo_project) : 'img/project-img.webp';
            $proj = $val;

            $sector = '';
            if(!empty($val->keyword1)){
                $sector .= $val->keyword1 . ', ';
            }
            if(!empty($val->keyword2)){
                $sector .= $val->keyword2 . ', ';
            }
            if(!empty($val->keyword3)){
                $sector .= $val->keyword3;
            }
            $sector = trim($sector);
            $sector = rtrim($sector, ',');

            $total_views = !empty($views->total_views) ? $views->total_views : 0;

            $countNdaList = count($ndaList);

            $favorite_proj = in_array($val->id, $favorite_project) ? 'active' : '';

            $data_ajax['data'][] = [
                'views' => $views,
                'ndaList' => $ndaList,
                'photo' => $photo,
                'proj' => $proj,
                'sector' => $sector,
                'total_views' => $total_views,
                'countNdaList' => $countNdaList,
                'favorite_proj' => $favorite_proj
            ];

        }

        return response()->json($data_ajax);
        } catch (\Exception $e) {
            //$e->getMessage();
            $data_ajax['data'] = [];
            return response()->json($data_ajax);
        }

    }

}
