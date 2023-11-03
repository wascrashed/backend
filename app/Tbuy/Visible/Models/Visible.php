<?php

namespace App\Tbuy\Visible\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property string $visible_type
 * @property int $visible_id
 * @property array $fields
 */
class Visible extends Model
{
    use HasFactory;

    protected $fillable = [
        'visible_type',
        'visible_id',
        'fields',
    ];

    protected $casts = [
        'fields' => 'array',
    ];

    public function visible(): MorphTo
    {
        return $this->morphTo();
    }
}
