<?php

use App\Tbuy\User\Constants\Permission as PermissionEnum;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;

return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
