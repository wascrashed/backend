<?php

namespace App\Tbuy\Product\Models;

use App\Contracts\SearchableContract;
use App\Contracts\SearchRatingableContract;
use App\Tbuy\Attributable\Interfaces\Attributable as AttributableInterface;
use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Basket\Models\Basket;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Category\Models\Category;
use App\Tbuy\Comment\Models\Comment;
use App\Tbuy\Company\SearchRatingCalculations\CalculateComplaints;
use App\Tbuy\Complaint\Models\Complaint;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\Product\DTOs\ProductDTO;
use App\Tbuy\Product\Enums\ProductStatus;
use App\Tbuy\Product\Enums\ProductType;
use App\Tbuy\Product\SearchRatingCalculations\CalculateFavouriteProductsOfPeople;
use App\Tbuy\Product\SearchRatingCalculations\CalculateHasActivePromotion;
use App\Tbuy\Product\SearchRatingCalculations\CalculateProductAtUser;
use App\Tbuy\Product\SearchRatingCalculations\CountInactivePromotionForProduct;
use App\Tbuy\Product\SearchRatingCalculations\ProductAttributesCount;
use App\Tbuy\Product\SearchRatingCalculations\ProductPurchasesCountCalculation;
use App\Tbuy\Product\SearchRatingCalculations\ProductUpdateCountCalculation;
use App\Tbuy\Promotion\Models\Promotion;
use App\Tbuy\Purchase\Models\Purchase;
use App\Tbuy\Rejection\Interfaces\Rejectionable;
use App\Tbuy\Rejection\Models\Rejection;
use App\Tbuy\Visible\Interfaces\HasVisible;
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
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Tbuy\Visible\Models\Visible;

/**
 * @property-read int $id
 * @property-read string $color
 * @property-read string|array $name
 * @property-read string $extended_name
 * @property-read boolean $active
 * @property ProductType $type
 * @property-read float $amount
 * @property-read ProductStatus $status
 * @property-read int $company_id
 * @property-read int $category_id
 * @property-read Carbon $accepted_at
 * @property-read float $price
 * @property-read float $size
 * @property-read Media $mainImage
 * @property-read Carbon $created_at
 * @property-read Collection $images
 * @property-read Collection $attributesList
 * @property-read Collection $favouriteUsers
 * @property-read Collection<Complaint> $complaints
 * @property-read string $description
 * @property-read Brand $brand
 * @property-read int $views
 * @property-read Visible|null $visibleFields
 * @method static Builder filter(ProductDTO $dto)
 * @method static Builder|Product query()
 */
class Product extends Model implements AttributableInterface, HasMedia, HasVisible, Rejectionable, SearchRatingableContract, SearchableContract
{
    use HasFactory;
    use HasAllTranslations;
    use InteractsWithMedia;
    use Favoriteable;
    use HasExtendedName;
    use SearchRatingable;
    use SearchableTrait;
    use SoftDeletes;

    public array $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'extended_description',
        'active',
        'amount',
        'status',
        'brand_id',
        'category_id',
        'type',
        'update_count',
        'price',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'price' => 'float',
        'amount' => 'float',
        'size' => 'float',
        'active' => 'boolean',
        'status' => ProductStatus::class,
        'type' => ProductType::class
    ];
    protected $with = ['visibleFields'];

    protected array $searchRatingCalculations = [
        CalculateFavouriteProductsOfPeople::class,
        CalculateProductAtUser::class,
        CountInactivePromotionForProduct::class,
        ProductPurchasesCountCalculation::class,
        ProductUpdateCountCalculation::class,
        ProductAttributesCount::class,
        CalculateHasActivePromotion::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @relationMorphColumn model
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', MediaLibraryCollection::PRODUCT_MEDIA->value);

    }

    public function mainImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', MediaLibraryCollection::PRODUCT_MEDIA_MAIN->value);
    }

    public function visibleFields(): MorphOne
    {
        return $this->morphOne(Visible::class, 'visible');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * @relationMorphColumn attributable
     * @return MorphMany
     */
    public function attributesList(): MorphMany
    {
        return $this->morphMany(Attributable::class, 'attributable')->with(['attribute', 'value']);
    }

    /**
     * @relationMorphColumn complaintable
     * @return MorphMany
     */
    public function complaints(): MorphMany
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

    public function scopeFilter(Builder $builder, ProductDTO $dto): void
    {
        $builder->when($dto->from && $dto->to, function (Builder $builder) use ($dto) {
            $builder->where('created_at', '>=', $dto->from)
                ->where('created_at', '<=', $dto->to);
        })->when($dto->name, function (Builder $builder) use ($dto) {
            $builder->where('name', 'LIKE', '%' . $dto->name . '%');
        })->when($dto->id, function (Builder $builder) use ($dto) {
            $builder->where('id', '=', $dto->id);
        })->when($dto->category_id, function (Builder $builder) use ($dto) {
            $builder->where('category_id', '=', $dto->category_id);
        })->when(!is_null($dto->before_declined), function (Builder $builder) use ($dto) {
            $builder->has('rejections');
        })->when(!is_null($dto->active), function (Builder $builder) use ($dto) {
            $builder->where('active', $dto->active);
        })->when(!is_null($dto->status?->value), function (Builder $builder) use ($dto) {
            $builder->where('status', '=', $dto->status->value);
        })->when($dto->limit, function (Builder $builder) use ($dto) {
            $builder->limit($dto->limit);
        })->when($dto->orderDirection, function (Builder $builder) use ($dto) {
            $builder->orderBy('id', $dto->orderDirection);
        })->when(!is_null($dto->reason_id), function (Builder $builder) use ($dto) {
            $builder->whereHas('rejections', function (Builder $builder) use ($dto) {
                $builder->where('reason_id', '=', $dto->reason_id);
            });
        })->when($dto->before_accepted, function (Builder $builder) {
            $builder->whereNull('accepted_at');
        })->when($dto->before_declined_reasons, function (Builder $builder) {
            $builder->with('rejections.reason');
        });
    }

    public function scopeZeroAmount(Builder $builder): Builder
    {
        return $builder->where('amount', '=', 0);
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
     * @relationMorphColumn commentable
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function baskets(): HasMany
    {
        return $this->hasMany(Basket::class);
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class)
            ->withPivot(['count', 'price'])
            ->withTimestamps();
    }
}
