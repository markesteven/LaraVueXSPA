<?php

namespace App\Models\Submissions;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Traits\Encryptable;
use Sagalbot\Encryptable\Encryptable;

class Submission extends Model
{

    use Encryptable;


    protected $table = 'submissions';
    public $timestamps = true;
    protected $fillable = ['code','first_name','last_name',
                            'middle_name','street_name','barangay','city',
                            'mobile_number', 'email_address','is_valid','is_confirmed'];

    protected $encryptable = [
        'first_name',
        'middle_name',
        'last_name',
        'street_name',
        'barangay',
        'city',
        'mobile_number'
    ];

}
