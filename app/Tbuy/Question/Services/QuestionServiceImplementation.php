<?php

namespace App\Tbuy\Question\Services;

use App\Tbuy\Question\DTOs\QuestionDTO;
use App\Tbuy\Question\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionServiceImplementation implements QuestionService
{
    public function get(): Collection
    {
        return Question::get();
    }

    public function store(QuestionDTO $dto): Question
    {
        $question = new Question();
        $question = $this->addTranslations($dto, $question);
        $question->save();

        return $question;
    }

    public function update(QuestionDTO $dto , Question $question): Question
    {
        $question = $this->addTranslations($dto, $question);
        $question->save();

        return $question;
    }

    public function delete(Question $question): void
    {
        $question->delete();
    }

    protected function addTranslations(QuestionDTO $payload, Question $question): Question
    {
        if ($payload->question || $payload->answer) {
            $question
                ->setTranslations('question', $payload->question)
                ->setTranslations('answer', $payload->answer);
        }

        return $question;
    }

}
