<?php

namespace App\Http\Requests;

use App\Data\ReviewerData;
use App\Data\ReviewerFilterData;

class ReviewerRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|integer',
            'name' => 'required|string',
            'visibility' => 'required|string',
            'description' => 'nullable|string',
            'coverImage' => 'nullable|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Transform request to data object.
     *
     * @return ReviewerData
     */
    public function toData(): ReviewerData
    {
        return new ReviewerData(
            userId: $this->getInputAsInt('userId'),
            name: $this->getInputAsString('name'),
            visibility: $this->getInputAsString('visibility'),
            description: $this->getInputAsString('description'),
            coverImage: $this->getInputAsString('coverImage'),
            id: $this->route('reviewerId'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

    /**
     * Transform request to filter data object.
     *
     * @return ReviewerFilterData
     */
    public function toFilterData(): ReviewerFilterData
    {
        return new ReviewerFilterData(
            userId: $this->getInputAsInt('userId'),
            name: $this->getInputAsString('name'),
            id: $this->getInputAsInt('id'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

}
