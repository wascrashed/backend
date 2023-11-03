<?php

namespace App\Tbuy\Visible\Repositories;

use App\Tbuy\Product\DTOs\VisibleFieldsDTO;
use App\Tbuy\Visible\Interfaces\HasVisible;

class VisibleRepositoryImplementation implements VisibleRepository
{
    public function create(HasVisible $model, VisibleFieldsDTO $fields): HasVisible
    {
        if ($visibles = $model->visibleFields()->first()) {
            $visibles->update([
                'fields' => $fields->fields
            ]);
        } else {
            $model->visibleFields()->create([
                'fields' => $fields->fields
            ]);
        }


        return $model->load('visibleFields');
    }
}
