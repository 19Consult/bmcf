<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    public $table = "users_details";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'phone',
        'photo',
        'about_you',
        'company_name',
        'occupation',
        'street',
        'house',
        'postal_code',
        'salutation',
        'country',
        'city',
        'new_project_email',
        'notification_email',
        'nda_approved_email',
        'basic_interests_investor',
        'categorty1_investor',
        'categorty2_investor',
        'categorty3_investor',
        'city_other',
    ];

}
