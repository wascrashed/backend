<?php

namespace App\Tbuy\Menu\Models;

use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property int $menu_id
 * @property Media $image
 * @property-read Menu $parent
 * @property-read Collection<int, Menu> $children
 * @property-read Collection<int, Menu> $grandChildren
 * @property-read Collection<int, User> $userPermissions
 */
class Menu extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'menu_id'
    ];

    /**
     * @relationMorphColumn model
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', MediaLibraryCollection::MENU_IMAGE);
    }

    /**
     * @relationColumn menu_id
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'menu_id');
    }

    /**
     * @relationColumn menu_id
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'menu_id');
    }

    /**
     * @relationColumn menu_id
     * @return HasMany
     */
    public function grandChildren(): HasMany
    {
        return $this->children()->with('grandChildren');
    }

    /**
     * @relationColumn user_id
     * @return BelongsToMany
     */
    public function userPermissions(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'menu_user_permission',
            'menu_id',
            'user_id'
        );
    }
}
