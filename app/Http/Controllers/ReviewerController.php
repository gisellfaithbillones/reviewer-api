<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenericRequest;
use App\Http\Requests\ReviewerContentRequest;
use App\Http\Requests\ReviewerRequest;
use App\Http\Resources\ReviewerResource;
use App\Services\ReviewerService;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class ReviewerController extends Controller
{

    public function __construct(
        private readonly ReviewerService $reviewerService
    )
    {
    }

    /**
     * Create reviewer.
     *
     * @param ReviewerRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function create(ReviewerRequest $request): JsonResponse|JsonResource
    {
        $serviceResponse = $this->reviewerService->create($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ReviewerResource::class, $serviceResponse->data);
    }

    /**
     * Create reviewer content.
     *
     * @param ReviewerContentRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function createContent(ReviewerContentRequest $request): JsonResponse|JsonResource
    {
        $serviceResponse = $this->reviewerService->createContent($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ReviewerResource::class, $serviceResponse->data);
    }

    /**
     * Get paginated reviewers.
     *
     * @param GenericRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function getPaginated(GenericRequest $request): JsonResponse|JsonResource
    {
        $reviewerData = ReviewerRequest::createFrom($request)->toFilterData();
        $serviceResponse = $this->reviewerService->getPaginated($reviewerData);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ReviewerResource::class, $serviceResponse->data);
    }

    /**
     * Get reviewer by id.
     *
     * @param GenericRequest $request
     * @param int $reviewerId
     *
     * @return JsonResponse|JsonResource
     */
    public function getById(GenericRequest $request, int $reviewerId): JsonResponse|JsonResource
    {
        $relations = $request->getRelations();
        $serviceResponse = $this->reviewerService->getById($reviewerId, $relations);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ReviewerResource::class, $serviceResponse->data);
    }

    /**
     * Update reviewer.
     *
     * @param ReviewerRequest $request
     * @param int $reviewerId
     *
     * @return JsonResponse|JsonResource
     */
    public function update(ReviewerRequest $request, int $reviewerId): JsonResponse|JsonResource
    {
        $serviceResponse = $this->reviewerService->update($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(ReviewerResource::class, $serviceResponse->data);
    }

    /**
     * Delete reviewer.
     *
     * @param GenericRequest $request
     * @param int $reviewerId
     *
     * @return JsonResponse
     */
    public function delete(GenericRequest $request, int $reviewerId): JsonResponse
    {
        $serviceResponse = $this->reviewerService->delete($reviewerId);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::success($serviceResponse->message);
    }

}
