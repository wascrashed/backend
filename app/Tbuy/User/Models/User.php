<?php

namespace App\Tbuy\User\Models;

// use Illuminate\Contracts\User\MustVerifyEmail;
use App\Tbuy\Basket\Models\Basket;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use App\Tbuy\Menu\Models\Menu;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Models\TariffUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property float $balance
 * @property Carbon $created_at
 * @property-read Company $company
 * @property-read Collection<Basket> $basket
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Subscriber, Favoriter, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            Menu::class,
            'menu_user_permission',
            'user_id',
            'menu_id'
        );
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class);
    }

    public function favouriteProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favourite_product')
            ->withPivot('created_at');
    }

    public function baskets(): HasMany
    {
        return $this->hasMany(Basket::class, 'user_id', 'id');
    }

    public function tariff(): BelongsToMany
    {
        return $this->belongsToMany(Tariff::class)
            ->withPivot(['expired_at']);
    }
}
