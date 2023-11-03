<?php

namespace App\Tbuy\Refund\Enums;

enum RefundStatus: string
{
    case NEW = 'new';
    case PROCESS = 'process';
    case REFUNDED = 'refunded';
}
