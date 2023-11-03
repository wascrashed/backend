<?php

namespace App\Tbuy\Target\Enums;

enum Status: string
{
    case NEW = 'new';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case IN_PROGRESS = 'in-progress';
    case ARCHIVED = 'archived';
}
