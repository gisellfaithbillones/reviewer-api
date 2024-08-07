<?php

namespace App\Http\Requests;

use App\Data\AnswerData;
use App\Data\AnswerFilterData;

class AnswerRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'questionId' => 'required|integer',
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
     * @return AnswerData
     */
    public function toData(): AnswerData
    {
        return new AnswerData(
            questionId: $this->getInputAsInt('questionId'),
            content: $this->getInputAsString('content'),
            id: $this->route('answerId'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

    /**
     * Transform request to filter data object.
     *
     * @return AnswerFilterData
     */
    public function toFilterData(): AnswerFilterData
    {
        return new AnswerFilterData(
            questionId: $this->getInputAsInt('questionId'),
            content: $this->getInputAsString('content'),
            id: $this->getInputAsInt('id'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

}
