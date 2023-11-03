<?php

namespace App\Tbuy\Target\DTOs;

class TargetDTO
{
    public function __construct(
        public readonly ?int $audience_id,
        public readonly ?string $targetable_type,
        public readonly ?int $targetable_id,
        public readonly ?array $name,
        public readonly ?string $link,
        public readonly ?int $duration,
        public readonly ?string $started_at,
        public readonly ?string $finished_at
    )
    {}
}
