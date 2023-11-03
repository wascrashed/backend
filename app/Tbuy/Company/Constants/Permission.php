<?php

namespace App\Tbuy\Company\Constants;

enum Permission: string
{
    case FORGOT_PASSWORD = 'forgot password';
    case CHANGE_PASSWORD = 'change password';



    public function toString(): string
    {
        return "permission:$this->value";
    }
}
