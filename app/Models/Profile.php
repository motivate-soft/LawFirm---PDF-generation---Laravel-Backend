<?php

namespace App\Models;

use App\Models\Lawfirm;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'profiles';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'telephone_number',
        'telephone_number_areacode',
        'mobile_number',
        'fax_number',
        'street',
        'apt_type',
        'apt_number',
        'city',
        'state',
        'zip_code',
        'province',
        'country',
        'uscis_account_number',
        'accereditation_expires_date',
        'is_attorney',
        'licensing_authority',
        'bar_number',
        'is_subject_to_any',
        'subject_explaination',
        'preparer_signature',
        'user_id',
        'lawfirm_id',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lawfirm()
    {
        return $this->belongsTo(Lawfirm::class);
    }
}
