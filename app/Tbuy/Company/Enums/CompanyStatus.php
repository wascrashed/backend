<?php

namespace App\Tbuy\Company\Enums;

enum CompanyStatus: string
{
    case ACTIVE = 'active';
    case APPROVED = 'approved';
    case ARCHIVED = 'archived';
    case MODERATION = 'moderation';
    case NEW = 'new';
    case REJECTED = 'rejected';

    public function isRejected(): bool
    {
        return $this->value === self::REJECTED->value;
    }

    public function isArchived(): bool
    {
        return $this->value === self::ARCHIVED->value;
    }
}
