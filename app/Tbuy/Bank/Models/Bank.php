<?php

namespace App\Tbuy\Bank\Models;

use App\Contracts\SearchableContract;
use App\Contracts\SearchRatingableContract;
use App\Tbuy\Bank\SearchRatingsCalculation\BankCreatedAndRejectedApplicationsRatioSearchRatingCalculation;
use App\Tbuy\Bank\SearchRatingsCalculation\ProfitableBankSearchRatingCalculation;
use App\Tbuy\Bank\SearchRatingsCalculation\SelectedBankForApplicationSearchRatingCalculation;
use App\Tbuy\Bank\SearchRatingsCalculation\SelectedBankSearchRatingCalculation;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use App\Traits\HasAllTranslations;
use App\Traits\SearchableTrait;
use App\Traits\SearchRatingable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model implements SearchRatingableContract, SearchableContract
{
    use HasFactory;
    use HasAllTranslations;
    use SearchRatingable;
    use SearchableTrait;
    use SearchRatingable;
    use SoftDeletes;

    protected $table = 'banks';
    protected $morphClass = 'bank';

    protected $fillable = [
        'name',
    ];

    public array $translatable = [
        'name',
    ];

    protected array $searchRatingCalculations = [
        BankCreatedAndRejectedApplicationsRatioSearchRatingCalculation::class,
        ProfitableBankSearchRatingCalculation::class,
        SelectedBankForApplicationSearchRatingCalculation::class,
        SelectedBankSearchRatingCalculation::class,
    ];

    public function creditApplications(): BelongsToMany
    {
        return $this->belongsToMany(CreditApplication::class)
            ->withPivot(['sum', 'status'])
            ->withTimestamps();
    }

    public function rejectedCreditApplications(): BelongsToMany
    {
        return $this->creditApplications()->wherePivot('status', Status::REJECTED->value);
    }

    public function acceptedCreditApplications(): BelongsToMany
    {
        return $this->creditApplications()->wherePivot('status', Status::ACCEPTED->value);
    }

    public function selectedForContract(): BelongsToMany
    {
        return $this->creditApplications()->wherePivot('status', Status::SELECTED->value);
    }

    public function bankRatingHistories(): HasMany
    {
        return $this->hasMany(BankRatingHistory::class);
    }
}
