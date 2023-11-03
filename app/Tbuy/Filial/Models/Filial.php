<?php

namespace App\Tbuy\Filial\Models;

use App\Tbuy\Community\Models\Community;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\Casts\CoordinatesCast;
use App\Tbuy\Filial\Casts\FilialScheduleCast;
use App\Tbuy\Filial\DTOs\CoordinateDTO;
use App\Tbuy\Filial\DTOs\ScheduleDTO;
use App\Tbuy\Region\Models\Region;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read  int $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property CoordinateDTO $coordinates
 * @property array<int, ScheduleDTO> $schedule
 * @property bool $is_main
 * @property int $company_id
 * @property int $region_id
 * @property int $community_id
 * @property-read Company $company
 * @property-read Community $community
 * @property-read Region $region
 */
class Filial extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'coordinates',
        'schedule',
        'is_main',
        'company_id',
        'region_id',
        'community_id',
    ];

    protected $casts = [
        'coordinates' => CoordinatesCast::class,
        'schedule' => FilialScheduleCast::class,
        'is_main' => 'bool'
    ];

    public array $translatable = ['name'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
