<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenericRequest;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Services\AnswerService;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class AnswerController extends Controller
{

    /**
     * AnswerController constructor.
     *
     * @param AnswerService $answerService
     */
    public function __construct(
        private readonly AnswerService $answerService
    )
    {
    }

    /**
     * Create answer.
     *
     * @param AnswerRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function create(AnswerRequest $request): JsonResponse|JsonResource
    {
        $serviceResponse = $this->answerService->create($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(AnswerResource::class, $serviceResponse->data);
    }

    /**
     * Get paginated answers.
     *
     * @param GenericRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function getPaginated(GenericRequest $request): JsonResponse|JsonResource
    {
        $answerData = AnswerRequest::createFrom($request)->toFilterData();
        $serviceResponse = $this->answerService->getPaginated($answerData);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(AnswerResource::class, $serviceResponse->data);
    }

    /**
     * Get answer by id.
     *
     * @param GenericRequest $request
     * @param int $answerId
     *
     * @return JsonResponse|JsonResource
     */
    public function getById(GenericRequest $request, int $answerId): JsonResponse|JsonResource
    {
        $relations = $request->getRelations();
        $serviceResponse = $this->answerService->getById($answerId, $relations);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(AnswerResource::class, $serviceResponse->data);
    }

    /**
     * Update answer.
     *
     * @param AnswerRequest $request
     * @param int $answerId
     *
     * @return JsonResponse|JsonResource
     */
    public function update(AnswerRequest $request, int $answerId): JsonResponse|JsonResource
    {
        $serviceResponse = $this->answerService->update($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(AnswerResource::class, $serviceResponse->data);
    }

    /**
     * Delete answer.
     *
     * @param GenericRequest $request
     * @param int $answerId
     *
     * @return JsonResponse
     */
    public function delete(GenericRequest $request, int $answerId): JsonResponse
    {
        $serviceResponse = $this->answerService->delete($answerId);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::success($serviceResponse->message);
    }

}
