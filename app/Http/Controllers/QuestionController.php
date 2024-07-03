<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenericRequest;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Services\QuestionService;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class QuestionController extends Controller
{

    /**
     * QuestionController constructor.
     *
     * @param QuestionService $questionService
     */
    public function __construct(
        private readonly QuestionService $questionService
    )
    {
    }

    /**
     * Create question.
     *
     * @param QuestionRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function create(QuestionRequest $request): JsonResponse|JsonResource
    {
        $serviceResponse = $this->questionService->create($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(QuestionResource::class, $serviceResponse->data);
    }

    /**
     * Get paginated questions.
     *
     * @param GenericRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function getPaginated(GenericRequest $request): JsonResponse|JsonResource
    {
        $questionData = QuestionRequest::createFrom($request)->toFilterData();
        $serviceResponse = $this->questionService->getPaginated($questionData);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(QuestionResource::class, $serviceResponse->data);
    }

    /**
     * Get question by id.
     *
     * @param GenericRequest $request
     * @param int $questionId
     *
     * @return JsonResponse|JsonResource
     */
    public function getById(GenericRequest $request, int $questionId): JsonResponse|JsonResource
    {
        $relations = $request->getRelations();
        $serviceResponse = $this->questionService->getById($questionId, $relations);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(QuestionResource::class, $serviceResponse->data);
    }

    /**
     * Update question.
     *
     * @param QuestionRequest $request
     * @param int $questionId
     *
     * @return JsonResponse|JsonResource
     */
    public function update(QuestionRequest $request, int $questionId): JsonResponse|JsonResource
    {
        $serviceResponse = $this->questionService->update($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(QuestionResource::class, $serviceResponse->data);
    }

    /**
     * Delete question.
     *
     * @param GenericRequest $request
     * @param int $questionId
     *
     * @return JsonResponse
     */
    public function delete(GenericRequest $request, int $questionId): JsonResponse
    {
        $serviceResponse = $this->questionService->delete($questionId);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::success($serviceResponse->message);
    }

}
