<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenericRequest;
use App\Http\Requests\ChoiceRequest;
use App\Http\Resources\ChoiceResource;
use App\Services\ChoiceService;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class ChoiceController extends Controller
{

    /**
     * ChoiceController constructor.
     *
     * @param ChoiceService $choiceService
     */
    public function __construct(
        private readonly ChoiceService $choiceService
    )
    {
    }

    /**
     * Create choice.
     *
     * @param ChoiceRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function create(ChoiceRequest $request): JsonResponse|JsonResource
    {
        $serviceResponse = $this->choiceService->create($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ChoiceResource::class, $serviceResponse->data);
    }

    /**
     * Get paginated choices.
     *
     * @param GenericRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function getPaginated(GenericRequest $request): JsonResponse|JsonResource
    {
        $choiceData = ChoiceRequest::createFrom($request)->toFilterData();
        $serviceResponse = $this->choiceService->getPaginated($choiceData);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ChoiceResource::class, $serviceResponse->data);
    }

    /**
     * Get choice by id.
     *
     * @param GenericRequest $request
     * @param int $choiceId
     *
     * @return JsonResponse|JsonResource
     */
    public function getById(GenericRequest $request, int $choiceId): JsonResponse|JsonResource
    {
        $relations = $request->getRelations();
        $serviceResponse = $this->choiceService->getById($choiceId, $relations);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ChoiceResource::class, $serviceResponse->data);
    }

    /**
     * Update choice.
     *
     * @param ChoiceRequest $request
     * @param int $choiceId
     *
     * @return JsonResponse|JsonResource
     */
    public function update(ChoiceRequest $request, int $choiceId): JsonResponse|JsonResource
    {
        $serviceResponse = $this->choiceService->update($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ChoiceResource::class, $serviceResponse->data);
    }

    /**
     * Delete choice.
     *
     * @param GenericRequest $request
     * @param int $choiceId
     *
     * @return JsonResponse
     */
    public function delete(GenericRequest $request, int $choiceId): JsonResponse
    {
        $serviceResponse = $this->choiceService->delete($choiceId);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::success($serviceResponse->message);
    }

}
