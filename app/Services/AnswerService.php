<?php

namespace App\Services;

use App\Data\AnswerData;
use App\Data\AnswerFilterData;
use App\Data\ServiceResponseData;
use App\Repositories\AnswerRepository;
use App\Utils\ServiceResponseUtil;

class AnswerService
{

    private AnswerRepository $answerRepository;

    /**
     * AnswerService constructor.
     *
     * @param AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * Create answer.
     *
     * @param AnswerData $answerData
     *
     * @return ServiceResponseData
     */
    public function create(AnswerData $answerData): ServiceResponseData
    {
        $answer = $this->answerRepository->save($answerData);

        if (empty($answer)) {
            return ServiceResponseUtil::error('Failed to create answer.');
        }

        return ServiceResponseUtil::success('Answer successfully added.', $answer);
    }

    /**
     * Get paginated answers.
     *
     * @param AnswerFilterData $answerFilterData
     *
     * @return ServiceResponseData
     */
    public function getPaginated(AnswerFilterData $answerFilterData): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->answerRepository->getPaginated($answerFilterData)
        );
    }

    /**
     * Get answer by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return ServiceResponseData
     */
    public function getById(int $id, array $relations = []): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->answerRepository->findById($id, $relations)
        );
    }

    /**
     * Update answer.
     *
     * @param AnswerData $answerData
     *
     * @return ServiceResponseData
     */
    public function update(AnswerData $answerData): ServiceResponseData
    {
        $answer = $this->answerRepository->findById($answerData->id);

        if (empty($answer)) {
            return ServiceResponseUtil::error('Failed to update answer.');
        }

        $answer = $this->answerRepository->save($answerData, $answer);

        if (empty($answer)) {
            return ServiceResponseUtil::error('Failed to update answer.');
        }

        return ServiceResponseUtil::success('Answer successfully updated.', $answer);
    }

    /**
     * Delete answer.
     *
     * @param int $id
     *
     * @return ServiceResponseData
     */
    public function delete(int $id): ServiceResponseData
    {
        $answer = $this->answerRepository->findById($id);

        if (empty($answer)) {
            return ServiceResponseUtil::error('Failed to delete answer.');
        }

        $isDeleted = $this->answerRepository->delete($id);

        if (!$isDeleted) {
            return ServiceResponseUtil::error('Failed to delete answer.');
        }

        return ServiceResponseUtil::success('Answer successfully deleted.');
    }

}
