<?php

namespace App\Tbuy\Question\Services;

use App\Tbuy\Question\DTOs\QuestionDTO;
use App\Tbuy\Question\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionAllias;

interface QuestionService
{
    public function get(): Collection;

    public function store(QuestionDTO $questionDTO): Question;

    public function update( QuestionDTO $questionDTO , Question $question ): Question ;

    public function delete(Question $question): void;

}

