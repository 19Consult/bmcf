<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    public $table = "projects";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_role',
        'name_project',
        'photo_project',
        'brief_description',
        'keyword1',
        'keyword2',
        'keyword3',
        'project_story',
        'video_skip',
        'youtube_link',
        'vimeo_link',
        'business_plan_skip',
        'business_plan',
        'co_founder_terms_condition',
    ];

    public function views()
    {
        return $this->hasMany(ProjectsViews::class, 'project_id');
    }

}
