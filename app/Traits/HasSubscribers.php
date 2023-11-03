<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSubscribers
{
    public function subscribe(Model $model): void
    {
        $user = auth()->user();
        $user->subscribe($model);
    }

    public function unsubscribe(Model $model): void
    {
        $user = auth()->user();
        $user->unsubscribe($model);
    }
}
