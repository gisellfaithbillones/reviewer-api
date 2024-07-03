<?php

namespace App\Repositories;

use App\Data\ChoiceData;
use App\Data\ChoiceFilterData;
use App\Models\Choice;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class ChoiceRepository
{

    /**
     * Save choice.
     *
     * @param ChoiceData $choiceData
     * @param Choice|null $choice
     *
     * @return Choice|null
     */
    public function save(ChoiceData $choiceData, ?Choice $choice = null): ?Choice
    {
        $choice ??= new Choice();
        $choice->question_id = $choiceData->questionId;
        $choice->content = $choiceData->content;
        $choice->save();

        return $this->findById($choice->id);
    }

    /**
     * Find choice by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return Choice|null
     */
    public function findById(int $id, array $relations = []): ?Choice
    {
        return Choice::with($relations)->firstWhere('id', $id);
    }

    /**
     * Checks if the choice exists.
     *
     * @param int $id
     *
     * @return bool
     */
    public function exists(int $id): bool
    {
        return Choice::where('id', $id)->exists();
    }

    /**
     * Get paginated choices.
     *
     * @param ChoiceFilterData $choiceFilterData
     *
     * @return LengthAwarePaginator
     */
    public function getPaginated(ChoiceFilterData $choiceFilterData): LengthAwarePaginator
    {
        $choices = Choice::with($choiceFilterData->meta->relations);

        if (!empty($choiceFilterData->id)) {
            $choices->where(function (Builder $queryBuilder) use ($choiceFilterData) {
                $queryBuilder->where('id', $choiceFilterData->id);
            });
        }

        if (!empty($choiceFilterData->questionId)) {
            $choices->where('question_id', $choiceFilterData->questionId);
        }

        return $choices->orderBy(
            $choiceFilterData->meta->sortField,
            $choiceFilterData->meta->sortDirection
        )->paginate($choiceFilterData->meta->limit);
    }

    /**
     * Delete choice.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $choice = $this->findById($id);

        if (empty($choice)) {
            return false;
        }

        try {
            return (bool) $choice->delete();
        } catch (Exception $e) {
            Log::error("Delete Choice Exception: {$e->getMessage()}");

            return false;
        }
    }

}
