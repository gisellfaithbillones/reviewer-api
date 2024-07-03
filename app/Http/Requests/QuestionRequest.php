<?php

namespace App\Http\Requests;

use App\Data\QuestionData;
use App\Data\QuestionFilterData;

class QuestionRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string'
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
     * @return QuestionData
     */
    public function toData(): QuestionData
    {
        return new QuestionData(
            content: $this->getInputAsString('content'),
            id: $this->route('questionId'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

    /**
     * Transform request to filter data object.
     *
     * @return QuestionFilterData
     */
    public function toFilterData(): QuestionFilterData
    {
        return new QuestionFilterData(
            content: $this->getInputAsString('content'),
            id: $this->getInputAsInt('id'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

}
