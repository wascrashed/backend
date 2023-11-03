<?php

namespace App\Jobs;

use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class UsersImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected readonly Collection $users
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $date = now()->toDateTimeString();

        $users = [];
        $companies = [];

        $this->users->each(function ($user) use ($date, &$users, &$companies) {
            if (filter_var($user->email, FILTER_VALIDATE_EMAIL) === false) {
                return true;
            }

            $name = $user->fname . ' ' . $user->lname;

            $users[] = [
                'id' => $user->id,
                'name' => $name,
                'email' => $user->email,
                'email_verified_at' => $date,
                'password' => bcrypt('password'),
                'balance' => 0,
                'created_at' => $date,
                'updated_at' => $date,
            ];

            $companies[] = [
                'name' => json_encode([
                    'ru' => $name,
                    'en' => $name,
                    'hy' => $name,
                ]),
                'legal_name_company' => $user->orgname,
                'type' => CompanyType::SALES->value,
                'inn' => $user->inn,
                'company_address' => implode(', ', [$user->zip, $user->adres, $user->city, $user->region]),
                'director' => json_encode([
                    'first_name' => $user->fname,
                    'last_name' => $user->lname
                ]),
                'phones' => json_encode([
                    'phone_director' => $user->phone
                ]),
                'email' => $user->email,
                'registered_at' => $date,
                'slug' => Str::slug($name . ' ' . $date),
                'status' => CompanyStatus::ACTIVE->value,
                'legal_entity' => true,
                'user_id' => $user->id,
                'created_at' => $date,
                'updated_at' => $date
            ];

            return true;
        })->toArray();

        User::query()->insert($users);
        Company::query()->insert($companies);
    }
}
