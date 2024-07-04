<?php

namespace App\Services;

use App\Data\NoteData;
use App\Data\NoteFilterData;
use App\Data\ServiceResponseData;
use App\Repositories\NoteRepository;
use App\Utils\ServiceResponseUtil;

class NoteService
{

    private NoteRepository $noteRepository;

    /**
     * NoteService constructor.
     *
     * @param NoteRepository $noteRepository
     */
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * Create note.
     *
     * @param NoteData $noteData
     *
     * @return ServiceResponseData
     */
    public function create(NoteData $noteData): ServiceResponseData
    {
        $note = $this->noteRepository->save($noteData);

        if (empty($note)) {
            return ServiceResponseUtil::error('Failed to create note.');
        }

        return ServiceResponseUtil::success('Note successfully added.', $note);
    }

    /**
     * Get paginated notes.
     *
     * @param NoteFilterData $noteFilterData
     *
     * @return ServiceResponseData
     */
    public function getPaginated(NoteFilterData $noteFilterData): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->noteRepository->getPaginated($noteFilterData)
        );
    }

    /**
     * Get note by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return ServiceResponseData
     */
    public function getById(int $id, array $relations = []): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->noteRepository->findById($id, $relations)
        );
    }

    /**
     * Update note.
     *
     * @param NoteData $noteData
     *
     * @return ServiceResponseData
     */
    public function update(NoteData $noteData): ServiceResponseData
    {
        $note = $this->noteRepository->findById($noteData->id);

        if (empty($note)) {
            return ServiceResponseUtil::error('Failed to update note.');
        }

        $note = $this->noteRepository->save($noteData, $note);

        if (empty($note)) {
            return ServiceResponseUtil::error('Failed to update note.');
        }

        return ServiceResponseUtil::success('Note successfully updated.', $note);
    }

    /**
     * Delete note.
     *
     * @param int $id
     *
     * @return ServiceResponseData
     */
    public function delete(int $id): ServiceResponseData
    {
        $note = $this->noteRepository->findById($id);

        if (empty($note)) {
            return ServiceResponseUtil::error('Failed to delete note.');
        }

        $isDeleted = $this->noteRepository->delete($id);

        if (!$isDeleted) {
            return ServiceResponseUtil::error('Failed to delete note.');
        }

        return ServiceResponseUtil::success('Note successfully deleted.');
    }

}
