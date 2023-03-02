<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class accountDeletionConfirmation extends Model
{
    use HasFactory;

    public $table = "account_deletion_confirmation";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    public function checkDeletionConfirmation(){
        if(!empty(accountDeletionConfirmation::where('user_id', Auth::id())->first())){
            return true;
        }
        return false;
    }
}
