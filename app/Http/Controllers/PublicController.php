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
}
