<?php

namespace App\Tbuy\Brand\Models;

use App\Contracts\SearchableContract;
use App\Contracts\SearchRatingableContract;
use App\Tbuy\Attributable\Interfaces\Attributable as AttributableInterface;
use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Brand\Enums\BrandStatus;
use App\Tbuy\Brand\SearchRatingCalculations\ProductPurchasesCountCalculation;
use App\Tbuy\Category\Models\Category;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Country\Models\Country;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Purchase\Models\Purchase;
use App\Tbuy\Rejection\Interfaces\Rejectionable;
use App\Tbuy\Rejection\Models\Rejection;
use App\Traits\HasAllTranslations;
use App\Traits\HasExtendedName;
use App\Traits\SearchableTrait;
use App\Traits\SearchRatingable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read string $extended_name
 * @property int $company_id
 * @property int $country_id
 * @property Carbon $date
 * @property array $description
 * @property BrandStatus $status
 * @property-read Collection<Purchase> $purchases
 * @property-read Collection<int, Product> $products
 * @property-read Company $company
 * @property-read Country $country
 * @property-read Media $logo
 * @property-read Collection<int, Attributable> $attributesList
 * @property-read Collection<int, Rejection> $rejections
 */
class Brand extends Model implements AttributableInterface, HasMedia, Rejectionable, SearchRatingableContract, SearchableContract
{
    use HasFactory;
    use HasAllTranslations;
    use InteractsWithMedia;
    use Subscribable;
    use HasExtendedName;
    use SoftDeletes;
    use SearchRatingable;
    use SearchableTrait;

    public array $translatable = [
        'name', 'description'
    ];

    protected $fillable = [
        'name',
        'company_id',
        'country_id',
        'date',
        'description',
        'status',
        'accepted_at'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'status' => BrandStatus::class,
        'deleted_at' => 'datetime',
        'accepted_at' => 'datetime'
    ];

    protected array $searchRatingCalculations = [
        ProductPurchasesCountCalculation::class,
    ];

    public function scopeFilterByDate(Builder $builder, ?string $date): void
    {
        $builder->when($date, function (Builder $builder, $date) {
            $date = Carbon::createFromFormat("Y-m-d", $date);
            $builder->where("date", $date);
        });
    }

    public function scopeFilterByCompany(Builder $builder, ?int $company_id): void
    {
        $builder->when($company_id, function (Builder $builder, $company_id) {
            $builder->where("company_id", $company_id);
        });
    }

    public function scopeFilterByReason(Builder $builder, ?int $reason_id)
    {
        return $builder->when(!is_null($reason_id), function (Builder $builder) use ($reason_id) {
            return $builder->whereHas('rejections', function (Builder $builder) use ($reason_id) {
                $builder->where('reason_id', '=', $reason_id);
            });
        });
    }

    public function scopeFilterByCategory(Builder $builder, ?int $category_id): void
    {
        $builder->when($category_id, function (Builder $builder, $category_id) {
            $builder->whereHas("categories", fn(Builder $builder) => $builder->whereKey($category_id));
        });
    }

    public function scopeFilterByStatus(Builder $builder, ?BrandStatus $status): void
    {
        $builder->when($status, function (Builder $builder) use ($status) {
            $builder->where('status', '=', $status->value);
        });
    }

    public function scopeFilterByBrand(Builder $builder, ?int $brand_id): void
    {
        $builder->when($brand_id, fn(Builder $builder) => $builder->whereKey($brand_id));
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', MediaLibraryCollection::BRAND_LOGO->value);
    }

    /**
     * @relationColumn product_id
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @relationMorphColumn attributable
     * @return MorphMany
     */
    public function attributesList(): MorphMany
    {
        return $this->morphMany(Attributable::class, 'attributable')
            ->orderBy('order')
            ->with(['attribute', 'value']);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'brand_category', 'brand_id', 'category_id');
    }

    public function rejections(): MorphMany
    {
        return $this->morphMany(Rejection::class, 'rejectionable');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'brand_id', 'id');
    }
}
