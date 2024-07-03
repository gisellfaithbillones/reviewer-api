<?php

namespace App\Repositories;

use App\Data\AnswerData;
use App\Data\AnswerFilterData;
use App\Models\Answer;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class AnswerRepository
{

    /**
     * Save answer.
     *
     * @param AnswerData $answerData
     * @param Answer|null $answer
     *
     * @return Answer|null
     */
    public function save(AnswerData $answerData, ?Answer $answer = null): ?Answer
    {
        $answer ??= new Answer();
        $answer->question_id = $answerData->questionId;
        $answer->content = $answerData->content;
        $answer->save();

        return $this->findById($answer->id);
    }

    /**
     * Find answer by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return Answer|null
     */
    public function findById(int $id, array $relations = []): ?Answer
    {
        return Answer::with($relations)->firstWhere('id', $id);
    }

    /**
     * Checks if the answer exists.
     *
     * @param int $id
     *
     * @return bool
     */
    public function exists(int $id): bool
    {
        return Answer::where('id', $id)->exists();
    }

    /**
     * Get paginated answers.
     *
     * @param AnswerFilterData $answerFilterData
     *
     * @return LengthAwarePaginator
     */
    public function getPaginated(AnswerFilterData $answerFilterData): LengthAwarePaginator
    {
        $answers = Answer::with($answerFilterData->meta->relations);

        if (!empty($answerFilterData->id)) {
            $answers->where(function (Builder $queryBuilder) use ($answerFilterData) {
                $queryBuilder->where('id', $answerFilterData->id);
            });
        }

        if (!empty($answerFilterData->questionId)) {
            $answers->where('question_id', $answerFilterData->questionId);
        }

        return $answers->orderBy(
            $answerFilterData->meta->sortField,
            $answerFilterData->meta->sortDirection
        )->paginate($answerFilterData->meta->limit);
    }

    /**
     * Delete answer.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $answer = $this->findById($id);

        if (empty($answer)) {
            return false;
        }

        try {
            return (bool) $answer->delete();
        } catch (Exception $e) {
            Log::error("Delete Answer Exception: {$e->getMessage()}");

            return false;
        }
    }

}
