<?php

namespace App\Services;

use App\Data\ReviewerData;
use App\Data\ReviewerFilterData;
use App\Data\ServiceResponseData;
use App\Repositories\ReviewerRepository;
use App\Utils\ServiceResponseUtil;

class ReviewerService
{

    private ReviewerRepository $reviewerRepository;

    /**
     * ReviewerService constructor.
     *
     * @param ReviewerRepository $reviewerRepository
     */
    public function __construct(ReviewerRepository $reviewerRepository)
    {
        $this->reviewerRepository = $reviewerRepository;
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
