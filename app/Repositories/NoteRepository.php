<?php

namespace App\Repositories;

use App\Data\NoteData;
use App\Data\NoteFilterData;
use App\Models\Note;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class NoteRepository
{

    /**
     * Save note.
     *
     * @param NoteData $noteData
     * @param Note|null $note
     *
     * @return Note|null
     */
    public function save(NoteData $noteData, ?Note $note = null): ?Note
    {
        $note ??= new Note();
        $note->reviewer_id = $noteData->reviewerId;
        $note->title = $noteData->title;
        $note->content = $noteData->content;
        $note->save();

        return $this->findById($note->id);
    }

    /**
     * Find note by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return Note|null
     */
    public function findById(int $id, array $relations = []): ?Note
    {
        return Note::with($relations)->firstWhere('id', $id);
    }

    /**
     * Checks if the note exists.
     *
     * @param int $id
     *
     * @return bool
     */
    public function exists(int $id): bool
    {
        return Note::where('id', $id)->exists();
    }

    /**
     * Get paginated notes.
     *
     * @param NoteFilterData $noteFilterData
     *
     * @return LengthAwarePaginator
     */
    public function getPaginated(NoteFilterData $noteFilterData): LengthAwarePaginator
    {
        $notes = Note::with($noteFilterData->meta->relations);

        if (!empty($noteFilterData->id)) {
            $notes->where(function (Builder $queryBuilder) use ($noteFilterData) {
                $queryBuilder->where('id', $noteFilterData->id);
            });
        }

        return $notes->orderBy(
            $noteFilterData->meta->sortField,
            $noteFilterData->meta->sortDirection
        )->paginate($noteFilterData->meta->limit);
    }

    /**
     * Delete note.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $note = $this->findById($id);

        if (empty($note)) {
            return false;
        }

        try {
            return (bool) $note->delete();
        } catch (Exception $e) {
            Log::error("Delete Note Exception: {$e->getMessage()}");
            return false;
        }
    }

}
