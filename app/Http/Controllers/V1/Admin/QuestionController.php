<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Question\Models\Question;
use App\Tbuy\Question\Resources\QuestionResource;
use App\Tbuy\Question\Services\QuestionService;
use App\Tbuy\Question\Requests\StoreQuestionRequest;
use App\Http\Responses\SuccessEmptyResponse;

/**
 * @group Админ
 * @subgroup Вопросы и ответы(FaQ)
 * @authenticated
 */
class QuestionController extends Controller
{
    private QuestionService $questionService;

    /**
     * Конструктор QuestionController.
     *
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

      /**
     * Получить список всех вопросов и ответов.
     *
     * @return SuccessResponse
     *
     * @responseFile status=200 storage/responses/question/index.json
     */
    public function index(): SuccessResponse
    {
        $questions = $this->questionService->get();

        return new SuccessResponse(
            response: QuestionResource::collection($questions),
            message: 'Список всех вопросов и ответов'
        );
    }

    /**
     * Создать новый вопрос и ответ.
     *
     * @bodyParam question.ru string required Вопрос на русском языке. Example: Какой ваш любимый цвет?
     * @bodyParam question.en string required Вопрос на английском языке. Example: What is your favorite color?
     * @bodyParam answer.ru string required Ответ на русском языке. Example: Мой любимый цвет - синий.
     * @bodyParam answer.en string required Ответ на английском языке. Example: My favorite color is blue.
     * @param StoreQuestionRequest $request
     * @return SuccessResponse
     *
     * @responseFile status=200 storage/responses/question/store.json
     */
    public function store(StoreQuestionRequest $request): SuccessResponse
    {
        $question = $this->questionService->store($request->toDto());

        return new SuccessResponse(
            response: QuestionResource::make($question),
            message: 'Вопрос и ответ успешно созданы'
        );
    }

     /**
     * Получить вопрос и ответ.
     *
     * @param Question $question
     * @return SuccessResponse
     *
     * @responseFile status=200 storage/responses/question/show.json
     */
    public function show(Question $question): SuccessResponse
    {
        return new SuccessResponse(
            response: QuestionResource::make($question),
            message: "Вопрос и ответ"
        );
    }

     /**
     * Обновить вопрос и ответ.
     *
     * @param StoreQuestionRequest $request
     * @param Question $question
     * @return SuccessResponse
     *
     * @responseFile status=200 storage/responses/question/update.json
     */
    public function update(StoreQuestionRequest $request, Question $question): SuccessResponse
    {
        $question = $this->questionService->update($request->toDto(), $question);

        return new SuccessResponse(
            response: QuestionResource::make($question),
            message: 'Вопрос и ответ успешно обновлены'
        );
    }

     /**
     * Удалить вопрос и ответ.
     *
     * @param Question $question
     * @return SuccessEmptyResponse
     *
     * @responseFile status=200 storage/responses/question/destroy.json
     */
    public function destroy(Question $question): SuccessEmptyResponse
    {
        $this->questionService->delete($question);

        return new SuccessEmptyResponse(
            message: 'Вопрос и ответ удалены'
        );

    }
}

