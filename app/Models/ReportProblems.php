<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProblems extends Model
{
    use HasFactory;

    public $table = "report_problems";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'form_user_id',
        'to_user_id',
        'project_id',
        'type',
        'description',
    ];

}
