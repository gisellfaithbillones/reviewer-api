<?php

namespace App\Repositories;

use App\Data\ReviewerData;
use App\Data\ReviewerFilterData;
use App\Models\Reviewer;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class ReviewerRepository
{

    /**
     * Save reviewer.
     *
     * @param ReviewerData $reviewerData
     * @param Reviewer|null $reviewer
     *
     * @return Reviewer|null
     */
    public function save(ReviewerData $reviewerData, ?Reviewer $reviewer = null): ?Reviewer
    {
        $reviewer ??= new Reviewer();
        $reviewer->user_id = $reviewerData->userId;
        $reviewer->name = $reviewerData->name;
        $reviewer->visibility = $reviewerData->visibility;
        $reviewer->description = $reviewerData->description;
        $reviewer->cover_image = $reviewerData->coverImage;
        $reviewer->save();

        return $this->findById($reviewer->id);
    }

    /**
     * Find reviewer by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return Reviewer|null
     */
    public function findById(int $id, array $relations = []): ?Reviewer
    {
        return Reviewer::with($relations)->firstWhere('id', $id);
    }

    /**
     * Checks if the reviewer exists.
     *
     * @param int $id
     *
     * @return bool
     */
    public function exists(int $id): bool
    {
        return Reviewer::where('id', $id)->exists();
    }

    /**
     * Get paginated reviewers.
     *
     * @param ReviewerFilterData $reviewerFilterData
     *
     * @return LengthAwarePaginator
     */
    public function getPaginated(ReviewerFilterData $reviewerFilterData): LengthAwarePaginator
    {
        $reviewers = Reviewer::with($reviewerFilterData->meta->relations);

        if (!empty($reviewerFilterData->id)) {
            $reviewers->where(function (Builder $queryBuilder) use ($reviewerFilterData) {
                $queryBuilder->where('id', $reviewerFilterData->id);
            });
        }

        return $reviewers->orderBy(
            $reviewerFilterData->meta->sortField,
            $reviewerFilterData->meta->sortDirection
        )->paginate($reviewerFilterData->meta->limit);
    }

    /**
     * Delete reviewer.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $reviewer = $this->findById($id);

        if (empty($reviewer)) {
            return false;
        }

        try {
            return (bool) $reviewer->delete();
        } catch (Exception $e) {
            Log::error("Delete Reviewer Exception: {$e->getMessage()}");
            return false;
        }
    }

}
