<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenericRequest;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Services\NoteService;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class NoteController extends Controller
{

    /**
     * NoteController constructor.
     *
     * @param NoteService $noteService
     */
    public function __construct(
        private readonly NoteService $noteService
    )
    {
    }

    /**
     * Create note.
     *
     * @param NoteRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function create(NoteRequest $request): JsonResponse|JsonResource
    {
        $serviceResponse = $this->noteService->create($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(NoteResource::class, $serviceResponse->data);
    }

    /**
     * Get paginated notes.
     *
     * @param GenericRequest $request
     *
     * @return JsonResponse|JsonResource
     */
    public function getPaginated(GenericRequest $request): JsonResponse|JsonResource
    {
        $noteData = NoteRequest::createFrom($request)->toFilterData();
        $serviceResponse = $this->noteService->getPaginated($noteData);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(NoteResource::class, $serviceResponse->data);
    }

    /**
     * Get note by id.
     *
     * @param GenericRequest $request
     * @param int $noteId
     *
     * @return JsonResponse|JsonResource
     */
    public function getById(GenericRequest $request, int $noteId): JsonResponse|JsonResource
    {
        $relations = $request->getRelations();
        $serviceResponse = $this->noteService->getById($noteId, $relations);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(NoteResource::class, $serviceResponse->data);
    }

    /**
     * Update note.
     *
     * @param NoteRequest $request
     * @param int $noteId
     *
     * @return JsonResponse|JsonResource
     */
    public function update(NoteRequest $request, int $noteId): JsonResponse|JsonResource
    {
        $serviceResponse = $this->noteService->update($request->toData());

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::resource(NoteResource::class, $serviceResponse->data);
    }

    /**
     * Delete note.
     *
     * @param GenericRequest $request
     * @param int $noteId
     *
     * @return JsonResponse
     */
    public function delete(GenericRequest $request, int $noteId): JsonResponse
    {
        $serviceResponse = $this->noteService->delete($noteId);

        if ($serviceResponse->error) {
            return ResponseUtil::error($serviceResponse->message);
        }

        return ResponseUtil::success($serviceResponse->message);
    }

}
