<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\ProjectsViews;
use App\Models\FavoriteProject;
use App\Models\CategoryName;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
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
                    ->orWhere('co_founder_terms_condition', 'LIKE', "%{$search_keyword}%");
            });
        }

        $query->orderBy($sort_by, $sort_order);

        $data['projects'] = $query->paginate($items_per_page);


//        $data['projects'] = Projects::with('views')->get();

        $data['category'] = CategoryName::all();

        $data['favorite_project'] = FavoriteProject::where('user_id', Auth::id())->pluck('project_id')->toArray();

        return view('home-investor', ['data' => $data, 'search_keyword' => $search_keyword, 'categories' => $categories]);
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

        return response()->json([
            'message' => 'Successfully!',
            'data' => $project_view,
            'project_detail' => $project_detail,
            'user_deteils' => $user_deteils,
            'favorite_bool' => in_array($project_id, $favorite_project),
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

}
