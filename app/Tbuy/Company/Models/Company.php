<?php

namespace App\Tbuy\Company\Models;

use App\Contracts\SearchableContract;
use App\Contracts\SearchRatingableContract;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Casts\CompanyDirector;
use App\Tbuy\Company\Casts\Phones;
use App\Tbuy\Company\Casts\Socials;
use App\Tbuy\Company\DTOs\DirectorDTO;
use App\Tbuy\Company\DTOs\PhonesDTO;
use App\Tbuy\Company\DTOs\SocialsDTO;
use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Filters\StatusFilter;
use App\Tbuy\Company\SearchRatingCalculations\CalculateCompanyDisabledProductsCount;
use App\Tbuy\Company\SearchRatingCalculations\CalculateCompanyHasTariff;
use App\Tbuy\Company\SearchRatingCalculations\CalculateComplaints;
use App\Tbuy\Company\SearchRatingCalculations\CalculatePromotionsCount;
use App\Tbuy\Company\SearchRatingCalculations\CalculatePurchasesRefunds;
use App\Tbuy\Company\SearchRatingCalculations\CalculateSocialEntriesCount;
use App\Tbuy\Company\SearchRatingCalculations\CompanySubscribersCountCalculation;
use App\Tbuy\Company\SearchRatingCalculations\CountGiftCardsAmount;
use App\Tbuy\Company\SearchRatingCalculations\ProductPurchasesCountCalculation;
use App\Tbuy\Company\SearchRatingCalculations\ProductsImagesDivisionOnProducts;
use App\Tbuy\Company\SearchRatingCalculations\ProductUpdateCountCalculation;
use App\Tbuy\Company\Filters\WithParentsFilter;
use App\Tbuy\Complaint\Models\Complaint;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\Product\Calculations\CountGiftCardsByCompanies;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Promotion\Models\Promotion;
use App\Tbuy\Rejection\Interfaces\Rejectionable;
use App\Tbuy\Rejection\Models\Rejection;
use App\Tbuy\Socials\Models\SocialEntry;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\User\Models\User;
use App\Traits\FilterTrait;
use App\Traits\HasAllTranslations;
use App\Traits\SearchableTrait;
use App\Traits\SearchRatingable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read int $id
 * @property string $name
 * @property string $legal_name_company
 * @property string $description
 * @property CompanyType $type
 * @property string $inn
 * @property string $company_address
 * @property boolean $legal_entity
 * @property DirectorDTO $director
 * @property PhonesDTO $phones
 * @property string $email
 * @property Carbon $registered_at
 * @property string $slug
 * @property int $parent_id
 * @property int $user_id
 * @property CompanyStatus $status
 * @property SocialsDTO $socials
 * @property-read Company $parent
 * @property-read Collection<CompanyEmployee> $employees
 * @property-read Collection<Company> $children
 * @property-read Collection<Brand> $brands
 * @property-read Media $logo
 * @property-read Media $brandDocument
 * @property-read Media $innDocument
 * @property-read Media $passportDocument
 * @property-read Media $stateRegisterDocument
 * @property-read Collection<Filial> $filials
 * @property-read Collection<Product> $products
 * @property-read Collection<SocialEntry> $socialEntries
 * @property-read Collection<Promotion> $promotions
 * @property-read Collection $ratings
 */
class Company extends Model implements HasMedia, Rejectionable, SearchRatingableContract, SearchableContract
{
    use HasFactory;
    use HasAllTranslations;
    use InteractsWithMedia;
    use Subscribable;
    use FilterTrait;
    use SearchRatingable;
    use SearchableTrait;
    use SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'legal_name_company',
        'description',
        'type',
        'inn',
        'company_address',
        'director',
        'phones',
        'email',
        'registered_at',
        'slug',
        'parent_id',
        'status',
        'legal_entity',
        'user_id',
        'socials',
        'bank_account',
        'tariff_conditions_accepted_at',
        'basic_agreement_accepted_at',
    ];

    public array $translatable = [
        'name',
        'description'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'tariff_conditions_accepted_at' => 'datetime',
        'basic_agreement_accepted_at' => 'datetime',
        'director' => CompanyDirector::class,
        'type' => CompanyType::class,
        'status' => CompanyStatus::class,
        'socials' => Socials::class,
        'phones' => Phones::class,
    ];

    protected array $filters = [
        StatusFilter::class => 'status',
        WithParentsFilter::class => null
    ];

    protected array $searchRatingCalculations = [
        CalculateCompanyDisabledProductsCount::class,
        CalculateCompanyHasTariff::class,
        CalculatePromotionsCount::class,
        CalculateSocialEntriesCount::class,
        CompanySubscribersCountCalculation::class,
        CountGiftCardsAmount::class,
        ProductPurchasesCountCalculation::class,
        ProductsImagesDivisionOnProducts::class,
        ProductUpdateCountCalculation::class,
        CalculateComplaints::class,
        CalculatePurchasesRefunds::class,
        CountGiftCardsByCompanies::class
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * @relationColumn parent_id
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * Relation with CompanyEmployee model
     *
     * @relationColumn employees
     * @return HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(CompanyEmployee::class, 'company_id', 'id')->with('user');
    }

    /**
     * @relationMorphColumn complaintable
     * @return MorphMany
     */
    public function complaints(): MorphMany
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

    /**
     * @return BelongsTo
     */
    /**
     * @relationColumn company_id
     * @return HasMany
     */
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', '=', MediaLibraryCollection::COMPANY_LOGO->value);
    }

    /**
     *
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function brandDocument(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', '=', MediaLibraryCollection::COMPANY_BRAND_DOCUMENT->value);
    }

    /**
     *
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function innDocument(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', '=', MediaLibraryCollection::COMPANY_INN_DOCUMENT->value);
    }

    /**
     *
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function passportDocument(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', '=', MediaLibraryCollection::COMPANY_PASSPORT_DOCUMENT->value);
    }

    /**
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function stateRegisterDocument(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', '=', MediaLibraryCollection::COMPANY_STATE_REGISTER_DOCUMENT->value);
    }

    /**
     * @relationMorphColumn rejectionable
     * @return MorphMany
     */
    public function rejections(): MorphMany
    {
        return $this->morphMany(Rejection::class, 'rejectionable');
    }

    /**
     * @relationColumn company_id
     * @return HasMany
     */
    public function filials(): HasMany
    {
        return $this->hasMany(Filial::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Brand::class);
    }

    public function socialEntries(): MorphMany
    {
        return $this->morphMany(SocialEntry::class, 'socialable');
    }

    /**
     * @relationColumn company_id
     * @return HasMany
     */
    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_rating')
            ->withPivot('rating');
    }

    public function tariffs(): BelongsToMany
    {
        return $this->belongsToMany(Tariff::class)
            ->withPivot(['expired_at'])
            ->withTimestamps();
    }

    public function tariff(): BelongsToMany
    {
        return $this->tariffs()->latest()->limit(1);
    }
}
