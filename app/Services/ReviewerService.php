<?php

namespace App\Services;

use App\Data\AnswerData;
use App\Data\ChoiceData;
use App\Data\ReviewerContentData;
use App\Data\ReviewerContentItemData;
use App\Data\ReviewerData;
use App\Data\ReviewerFilterData;
use App\Data\ServiceResponseData;
use App\Repositories\AnswerRepository;
use App\Repositories\ChoiceRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ReviewerRepository;
use App\Utils\ServiceResponseUtil;
use Illuminate\Support\Facades\DB;

class ReviewerService
{

    public function __construct(
        private readonly ReviewerRepository $reviewerRepository,
        private readonly QuestionRepository $questionRepository,
        private readonly ChoiceRepository $choiceRepository,
        private readonly AnswerRepository $answerRepository,
    )
    {
    }

    /**
     * Create reviewer.
     *
     * @param ReviewerData $reviewerData
     *
     * @return ServiceResponseData
     */
    public function create(ReviewerData $reviewerData): ServiceResponseData
    {
        $reviewer = $this->reviewerRepository->save($reviewerData);

        if (empty($reviewer)) {
            return ServiceResponseUtil::error('Failed to create reviewer.');
        }

        return ServiceResponseUtil::success('Reviewer successfully added.', $reviewer);
    }

    /**
     * Create reviewer content.
     *
     * @param ReviewerContentData $reviewerContentData
     *
     * @return ServiceResponseData
     */
    public function createContent(ReviewerContentData $reviewerContentData): ServiceResponseData
    {
        $reviewer = $this->reviewerRepository->findById($reviewerContentData->reviewerId);

        if (empty($reviewer)) {
            return ServiceResponseUtil::error('Failed to create reviewer content. Reviewer not found.');
        }

        return DB::transaction(function () use ($reviewerContentData, $reviewer) {
            /** @var ReviewerContentItemData $item */
            foreach ($reviewerContentData->items as $item) {
                $question = $this->questionRepository->save($item->question);

                if (empty($question)) {
                    continue;
                }

                /** @var ChoiceData $choiceData */
                foreach ($item->choices as $choiceData) {
                    $choiceData->questionId = $question->id;
                    $this->choiceRepository->save($choiceData);
                }

                /** @var AnswerData $answerData */
                foreach ($item->answers as $answerData) {
                    $answerData->questionId = $question->id;
                    $this->answerRepository->save($answerData);
                }
            }

            return ServiceResponseUtil::success('Reviewer content successfully updated.', $reviewer);
        });
    }

    /**
     * Get paginated reviewers.
     *
     * @param ReviewerFilterData $reviewerFilterData
     *
     * @return ServiceResponseData
     */
    public function getPaginated(ReviewerFilterData $reviewerFilterData): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->reviewerRepository->getPaginated($reviewerFilterData)
        );
    }

    /**
     * Get reviewer by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return ServiceResponseData
     */
    public function getById(int $id, array $relations = []): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->reviewerRepository->findById($id, $relations)
        );
    }

    /**
     * Update reviewer.
     *
     * @param ReviewerData $reviewerData
     *
     * @return ServiceResponseData
     */
    public function update(ReviewerData $reviewerData): ServiceResponseData
    {
        $reviewer = $this->reviewerRepository->findById($reviewerData->id);

        if (empty($reviewer)) {
            return ServiceResponseUtil::error('Failed to update reviewer.');
        }

        $reviewer = $this->reviewerRepository->save($reviewerData, $reviewer);

        if (empty($reviewer)) {
            return ServiceResponseUtil::error('Failed to update reviewer.');
        }

        return ServiceResponseUtil::success('Reviewer successfully updated.', $reviewer);
    }

    /**
     * Delete reviewer.
     *
     * @param int $id
     *
     * @return ServiceResponseData
     */
    public function delete(int $id): ServiceResponseData
    {
        $reviewer = $this->reviewerRepository->findById($id);

        if (empty($reviewer)) {
            return ServiceResponseUtil::error('Failed to delete reviewer.');
        }

        $isDeleted = $this->reviewerRepository->delete($id);

        if (!$isDeleted) {
            return ServiceResponseUtil::error('Failed to delete reviewer.');
        }

        return ServiceResponseUtil::success('Reviewer successfully deleted.');
    }

}
