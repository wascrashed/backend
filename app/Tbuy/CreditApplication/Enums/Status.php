<?php

namespace App\Tbuy\CreditApplication\Enums;

enum Status: string
{
    case NEW = 'new';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case SELECTED = 'selected';
}
