<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;

class NdaProjects extends Model
{
    use HasFactory;

    public $table = "nda_project";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'id_project',
        'signature',
        'date',
        'disclosing',
        'disclosing_mail',
        'receiving',
        'receiving_mail',
        'status',
        'signature_owner',
        'data_signature_owner',
        'owner_pr_id',
        'seen',
    ];

    public $status_type = [
      'signed',
      'pending',
      'rejected',
    ];

    public static function checkSignedNda($user_id, $project_id){
        $check_asses = NdaProjects::where('user_id', $user_id)->where("id_project", $project_id)->first();

        if (!empty($check_asses) && $check_asses->status == 'signed'){
            return true;
        }
        return false;
    }

}
