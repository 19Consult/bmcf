<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\SettingsTable;

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

    public static $count_projects = 1;

    public function __construct()
    {
        $count_posts = SettingsTable::where('name', 'count_posts')->first();
        self::$count_projects = $count_posts->value;
    }

    public function views()
    {
        return $this->hasMany(ProjectsViews::class, 'project_id');
    }

    public static function countProjects($user_id = null)
    {
        if (!$user_id) {
            $user_id = Auth::id();
        }
        return Projects::where('user_id', $user_id)->count();
    }

    public static function getCountAssetProjects(){
        return self::$count_projects;
    }

}
