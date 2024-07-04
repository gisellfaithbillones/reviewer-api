<?php

namespace App\Http\Requests;

use App\Data\NoteData;
use App\Data\NoteFilterData;

class NoteRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'reviewerId' => 'required|integer',
            'title' => 'nullable|string',
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
     * @return NoteData
     */
    public function toData(): NoteData
    {
        return new NoteData(
            reviewerId: $this->getInputAsInt('reviewerId'),
            title: $this->getInputAsString('title'),
            content: $this->getInputAsString('content'),
            id: $this->route('noteId'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

    /**
     * Transform request to filter data object.
     *
     * @return NoteFilterData
     */
    public function toFilterData(): NoteFilterData
    {
        return new NoteFilterData(
            reviewerId: $this->getInputAsInt('reviewerId'),
            id: $this->getInputAsInt('id'),
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

}
