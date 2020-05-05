<?php

namespace App\Models\Submissions;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Traits\Encryptable;
use Sagalbot\Encryptable\Encryptable;

class ValidEmail extends Model
{

    // use Encryptable;


    protected $table = 'valid_emails';
    public $timestamps = true;
    protected $fillable = ['email'];

}
