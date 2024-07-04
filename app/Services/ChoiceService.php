<?php

namespace App\Services;

use App\Data\ChoiceData;
use App\Data\ChoiceFilterData;
use App\Data\ServiceResponseData;
use App\Repositories\ChoiceRepository;
use App\Utils\ServiceResponseUtil;

class ChoiceService
{

    public function __construct(
        private readonly ChoiceRepository $choiceRepository
    )
    {
    }

    /**
     * Create choice.
     *
     * @param ChoiceData $choiceData
     *
     * @return ServiceResponseData
     */
    public function create(ChoiceData $choiceData): ServiceResponseData
    {
        $choice = $this->choiceRepository->save($choiceData);

        if (empty($choice)) {
            return ServiceResponseUtil::error('Failed to create choice.');
        }

        return ServiceResponseUtil::success('Choice successfully added.', $choice);
    }

    /**
     * Get paginated choices.
     *
     * @param ChoiceFilterData $choiceFilterData
     *
     * @return ServiceResponseData
     */
    public function getPaginated(ChoiceFilterData $choiceFilterData): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->choiceRepository->getPaginated($choiceFilterData)
        );
    }

    /**
     * Get choice by id.
     *
     * @param int $id
     * @param array $relations
     *
     * @return ServiceResponseData
     */
    public function getById(int $id, array $relations = []): ServiceResponseData
    {
        return ServiceResponseUtil::map(
            $this->choiceRepository->findById($id, $relations)
        );
    }

    /**
     * Update choice.
     *
     * @param ChoiceData $choiceData
     *
     * @return ServiceResponseData
     */
    public function update(ChoiceData $choiceData): ServiceResponseData
    {
        $choice = $this->choiceRepository->findById($choiceData->id);

        if (empty($choice)) {
            return ServiceResponseUtil::error('Failed to update choice.');
        }

        $choice = $this->choiceRepository->save($choiceData, $choice);

        if (empty($choice)) {
            return ServiceResponseUtil::error('Failed to update choice.');
        }

        return ServiceResponseUtil::success('Choice successfully updated.', $choice);
    }

    /**
     * Delete choice.
     *
     * @param int $id
     *
     * @return ServiceResponseData
     */
    public function delete(int $id): ServiceResponseData
    {
        $choice = $this->choiceRepository->findById($id);

        if (empty($choice)) {
            return ServiceResponseUtil::error('Failed to delete choice.');
        }

        $isDeleted = $this->choiceRepository->delete($id);

        if (!$isDeleted) {
            return ServiceResponseUtil::error('Failed to delete choice.');
        }

        return ServiceResponseUtil::success('Choice successfully deleted.');
    }

}
