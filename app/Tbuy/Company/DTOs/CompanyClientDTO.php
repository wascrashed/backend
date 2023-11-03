<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class CompanyClientDTO extends BaseDTO
{
    public function __construct(
        public readonly array       $name,
        public readonly array       $description,
        public readonly string      $email,
        public readonly DirectorDTO $director,
        public readonly PhonesDTO   $phones,
        public readonly SocialsDTO  $socials,
        public ?UploadedFile        $logo = null,
    )
    {
    }
}
