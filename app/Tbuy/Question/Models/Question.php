<?php

namespace App\Tbuy\Question\Models;

use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
  * @property string $question
 * @property string $answer
 */

class Question extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'answer',
    ];

    public array $translatable = [
        'question',
        'answer',
    ];
}
