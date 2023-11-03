<?php

namespace App\Tbuy\Category\Models;

use App\Contracts\SearchableContract;
use App\Contracts\SearchRatingableContract;
use App\Tbuy\Category\SearchRatingCalculations\CalculateActiveProductsCount;
use App\Tbuy\Category\SearchRatingCalculations\CalculateChildLevel;
use App\Tbuy\Company\SearchRatingCalculations\CalculatePurchaseByCategory;
use App\Tbuy\Product\Models\Product;
use App\Traits\SearchableTrait;
use App\Traits\SearchRatingable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property int $parent_id
 * @property-read Category|null $parent
 * @property-read Category|null $grandParent
 * @property-read Collection<Category> $children
 * @property-read Collection<Product> $products
 */
class Category extends Model implements SearchRatingableContract, SearchableContract
{
    use HasFactory;
    use HasAllTranslations;
    use SearchRatingable;
    use SearchableTrait;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public array $translatable = [
        'name'
    ];

    protected array $searchRatingCalculations = [
        CalculateActiveProductsCount::class,
        CalculateChildLevel::class,
        CalculatePurchaseByCategory::class
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function grandParent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id')->with('grandParent');
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
     * @relationColumn category_id
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
