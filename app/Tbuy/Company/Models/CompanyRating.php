<?php

namespace App\Tbuy\Company\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property int $company_id
 * @property int $user_id
 * @property int $rating
 */
class CompanyRating extends Model
{
    protected $table = 'company_rating';

    protected $fillable = [
        'company_id',
        'user_id',
        'rating'
    ];
}
