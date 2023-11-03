<?php

namespace App\Tbuy\Filial\DTOs;

use App\DTOs\BaseDTO;

class FilialDTO extends BaseDTO
{
    public function __construct(
        public readonly array         $name,
        public readonly string        $phone,
        public readonly string        $address,
        public readonly CoordinateDTO $coordinates,
        public readonly array         $schedule,
        public readonly bool          $is_main,
        public readonly int           $company_id,
        public readonly int           $community_id,
        public readonly int           $region_id
    )
    {
    }
}
