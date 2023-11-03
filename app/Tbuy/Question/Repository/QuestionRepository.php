<?php

namespace App\Tbuy\Question\Repositories;

use App\Tbuy\Question\DTOs\QuestionDTO;
use App\Tbuy\Question\Models\Question;
use Illuminate\Database\Eloquent\Collection;

 interface QuestionRepository
{
    public function get(): Collection;

    public function store(QuestionDTO $dto): Question;

    public function update(Question $question, QuestionDTO $dto): Question;

    public function delete(Question $question): void;
    
    public function findById(int $id): ?Question;

 }

