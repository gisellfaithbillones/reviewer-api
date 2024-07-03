<?php

namespace App\Services;

use App\Data\QuestionData;
use App\Data\QuestionFilterData;
use App\Data\ServiceResponseData;
use App\Repositories\QuestionRepository;
use App\Utils\ServiceResponseUtil;

class QuestionService
{

    private QuestionRepository $questionRepository;

    /**
     * QuestionService constructor.
     *
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Create question.
     *
     * @param QuestionData $questionData
     *
     * @return ServiceResponseData
     */
    public function create(QuestionData $questionData): ServiceResponseData
    {
        $question = $this->questionRepository->save($questionData);

        if (empty($question)) {
            return ServiceResponseUtil::error('Failed to create question.');
        }

        return ServiceResponseUtil::success('Question successfully added.', $question);
    }

    /**
     * Get paginated questions.
     *
     * @param QuestionFilterData $questionFilterData
     *
     * @return ServiceResponseData
     */
    public function getPaginated(QuestionFilterData $questionFilterData): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->questionRepository->getPaginated($questionFilterData)
        );
    }

    /**
     * Get question by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return ServiceResponseData
     */
    public function getById(int $id, array $relations = []): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->questionRepository->findById($id, $relations)
        );
    }

    /**
     * Update question.
     *
     * @param QuestionData $questionData
     *
     * @return ServiceResponseData
     */
    public function update(QuestionData $questionData): ServiceResponseData
    {
        $question = $this->questionRepository->findById($questionData->id);

        if (empty($question)) {
            return ServiceResponseUtil::error('Failed to update question.');
        }

        $question = $this->questionRepository->save($questionData, $question);

        if (empty($question)) {
            return ServiceResponseUtil::error('Failed to update question.');
        }

        return ServiceResponseUtil::success('Question successfully updated.', $question);
    }

    /**
     * Delete question.
     *
     * @param int $id
     *
     * @return ServiceResponseData
     */
    public function delete(int $id): ServiceResponseData
    {
        $question = $this->questionRepository->findById($id);

        if (empty($question)) {
            return ServiceResponseUtil::error('Failed to delete question.');
        }

        $isDeleted = $this->questionRepository->delete($id);

        if (!$isDeleted) {
            return ServiceResponseUtil::error('Failed to delete question.');
        }

        return ServiceResponseUtil::success('Question successfully deleted.');
    }

}
