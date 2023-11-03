<?php

namespace App\Tbuy\Visible\Repositories;

use App\Tbuy\Product\DTOs\VisibleFieldsDTO;
use App\Tbuy\Visible\Interfaces\HasVisible;

interface VisibleRepository
{
    public function create(HasVisible $model, VisibleFieldsDTO $fields): HasVisible;
}
