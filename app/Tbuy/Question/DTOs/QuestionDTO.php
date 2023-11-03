<?php

namespace App\Tbuy\Question\DTOs;


class QuestionDTO
{

    public function __construct(
        public readonly array  $question,
        public readonly array  $answer,
    )
    {
    }
}


