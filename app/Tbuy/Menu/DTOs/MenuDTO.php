<?php

namespace App\Tbuy\Menu\DTOs;

use Illuminate\Http\UploadedFile;

class MenuDTO
{
    public function __construct(
        public readonly string        $name,
        public readonly string        $slug,
        public readonly ?int          $menu_id = null,
        public readonly ?UploadedFile $image = null
    )
    {
    }
}
