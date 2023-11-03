<?php

namespace App\Tbuy\Employee\Models;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Employee\Filters\CompanyFilter;
use App\Tbuy\Employee\Filters\EmailFilter;
use App\Tbuy\Employee\Filters\UsernameFilter;
use App\Tbuy\User\Models\User;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

/**
 * CompanyEmployee model
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read User $user
 * @property-read int $company_id
 * @property-read Company $company
 * @property-read string $password
 * @property-read string $username
 * @property-read Carbon $created_at
 * @method static Builder|CompanyEmployee filter(array $dto)
 * @method static Builder|CompanyEmployee query()
 */
class CompanyEmployee extends Model
{
    use HasFactory, HasRoles, FilterTrait, SoftDeletes;

    protected array $filters = [
        UsernameFilter::class => 'username',
        EmailFilter::class => 'email',
        CompanyFilter::class => 'company_id'
    ];

    /**
     * Fillable columns
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'password',
        'username'
    ];

    /**
     * Hidden columns
     *
     * @var string[]
     */
    protected $hidden = [
      'password'
    ];

    /**
     * Relation with User model
     *
     * @relationColumn user_id
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relation with Company model
     *
     * @relationColumn company_id
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
