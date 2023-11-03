<?php

namespace App\Tbuy\Brand\DTOs\Rejection;

use App\DTOs\BaseDTO;
use Illuminate\Support\Carbon;

class RejectionFilterDTO extends BaseDTO
{
    public readonly ?Carbon $date;

    public function __construct(
        public readonly string  $type,
        public readonly ?array  $reason = null,
        public readonly ?int    $id = null,
        public readonly ?int    $user = null,
        string                  $date = null,
        public readonly ?string $name = null,
        public readonly ?int    $company = null,
        public readonly ?int    $category_id = null,
    )
    {
        $this->date = $date ? Carbon::createFromFormat('Y-m-d', $date) : null;
    }

}
