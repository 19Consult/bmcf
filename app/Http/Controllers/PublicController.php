<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\CategoryName;
use App\Models\accountDeletionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAccountDeletionConfirmation;
use App\Mail\MailReportProblem;
use App\Models\Projects;
use App\Models\NotificationsUsers;
use App\Models\ReportProblems;
use App\Models\NdaProjects;

class PublicController extends Controller
{
    public function viewProjectPublic($id){

        if (Auth::check()){
            return redirect(route("viewProject", ['id' => $id]));
        }

        $data['project'] = Projects::where('id', $id)->first();
        return view("project-public", [
            'data' => $data,
            'id_project' => $id,
        ]);

    }

    public function viewProjectPublicNext($id){
        Session::put('id_project_view', $id);
        return redirect(route("sign-up-co-founder"));
    }

    public function viewProfilePublic($id){
        $user_detail = UserDetail::where('user_id', $id)->first();
        if (!$user_detail){
            if(Auth::check()){
                return redirect(route("dashboardOwner"));
            }
            return redirect(route("welcome"));
        }

        $data['user'] = $user_detail;

        $check_type = false;
        $check_nda = false;
        if(Auth::check() && Auth::id() != $id){
            $check_type = true;

            $keywords = [$id, Auth::id()];
            $userIds = NdaProjects::where(function($query) use ($keywords) {
                $query->whereIn('user_id', $keywords)
                    ->orWhereIn('owner_pr_id', $keywords);
            })->first();
            if($userIds && !empty($userIds->user_id)){
                $k1 = $userIds->user_id;
                $k2 = $userIds->owner_pr_id;
                if( ($k1 == $id && $k2 == Auth::id()) || ($k2 == $id && $k1 == Auth::id()) ){
                    if($userIds->status == 'signed'){
                        $check_nda = true;
                    }
                }
            }

        }

        return view("profile-public", [
            'data' => $data,
            'user_id' => $id,
            'check_type' => $check_type,
            'check_nda' => $check_nda,
        ]);
    }

    public function viewProfilePublicNext($id){
        Session::put('id_profile_view', $id);
        return redirect(route("welcome"));
    }

}
