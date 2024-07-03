<?php

namespace App\Http\Requests;

use App\Data\ChoiceData;
use App\Data\ChoiceFilterData;

class ChoiceRequest extends BaseRequest
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
     * @return ChoiceData
     */
    public function toData(): ChoiceData
    {
        return new ChoiceData(
            questionId: $this->getInputAsInt('questionId'),
            content: $this->getInputAsString('content'),
            id: $this->route('choiceId'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

    /**
     * Transform request to filter data object.
     *
     * @return ChoiceFilterData
     */
    public function toFilterData(): ChoiceFilterData
    {
        return new ChoiceFilterData(
            questionId: $this->getInputAsInt('questionId'),
            content: $this->getInputAsString('content'),
            id: $this->getInputAsInt('id'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

}
