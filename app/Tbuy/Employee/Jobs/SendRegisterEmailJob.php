<?php

namespace App\Tbuy\Employee\Jobs;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Employee\Mail\RegisterMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string  $to,
        private readonly string  $login,
        private readonly string  $password,
        private readonly Company $company
    )
    {
    }

    public function handle(): void
    {
        Mail::to($this->to)
            ->queue(new RegisterMail($this->login, $this->password, $this->company));
    }
}
