<?php

namespace App\Repositories;

use App\Data\QuestionData;
use App\Data\QuestionFilterData;
use App\Models\Question;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class QuestionRepository
{

    /**
     * Save question.
     *
     * @param QuestionData $questionData
     * @param Question|null $question
     *
     * @return Question|null
     */
    public function save(QuestionData $questionData, ?Question $question = null): ?Question
    {
        $question ??= new Question();
        $question->reviewer_id = $questionData->reviewerId;
        $question->content = $questionData->content;
        $question->attachments = $questionData->attachments;
        $question->hint = $questionData->hint;
        $question->answer_explanation = $questionData->answerExplanation;
        $question->save();

        return $this->findById($question->id);
    }

    /**
     * Find question by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return Question|null
     */
    public function findById(int $id, array $relations = []): ?Question
    {
        return Question::with($relations)->firstWhere('id', $id);
    }

    /**
     * Checks if the question exists.
     *
     * @param int $id
     *
     * @return bool
     */
    public function exists(int $id): bool
    {
        return Question::where('id', $id)->exists();
    }

    /**
     * Get paginated questions.
     *
     * @param QuestionFilterData $questionFilterData
     *
     * @return LengthAwarePaginator
     */
    public function getPaginated(QuestionFilterData $questionFilterData): LengthAwarePaginator
    {
        $questions = Question::with($questionFilterData->meta->relations);

        if (!empty($questionFilterData->id)) {
            $questions->where(function (Builder $queryBuilder) use ($questionFilterData) {
                $queryBuilder->where('id', $questionFilterData->id);
            });
        }

        return $questions->orderBy(
            $questionFilterData->meta->sortField,
            $questionFilterData->meta->sortDirection
        )->paginate($questionFilterData->meta->limit);
    }

    /**
     * Delete question.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $question = $this->findById($id);

        if (empty($question)) {
            return false;
        }

        try {
            return (bool) $question->delete();
        } catch (Exception $e) {
            Log::error("Delete Question Exception: {$e->getMessage()}");

            return false;
        }
    }

}
