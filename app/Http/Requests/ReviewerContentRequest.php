<?php

namespace App\Http\Requests;

use App\Data\AnswerData;
use App\Data\ChoiceData;
use App\Data\QuestionData;
use App\Data\ReviewerContentData;
use App\Data\ReviewerContentItemData;

class ReviewerContentRequest extends BaseRequest
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
            'items' => 'required|array',
            'items.*.question' => 'required',
            'items.*.question.content' => 'required|string',
            'items.*.question.attachments' => 'nullable|array',
            'items.*.question.hint' => 'nullable|string',
            'items.*.question.answerExplanation' => 'nullable|string',
            'items.*.choices' => 'required|array',
            'items.*.choices.*.questionId' => 'required|integer',
            'items.*.choices.*.content' => 'required|string',
            'items.*.answers' => 'required|array',
            'items.*.answer.*.content' => 'required|string'
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
     * @return ReviewerContentData
     */
    public function toData(): ReviewerContentData
    {
        $reviewerId = $this->getInputAsInt('reviewerId');
        $items = $this->getInputAsArray('items');
        $itemDataList = [];

        foreach ($items as $item) {
            $itemDataList[] = new ReviewerContentItemData(
                question: $this->composeQuestionData($item['question']),
                choices: $this->composeChoiceDataList($item['choices']),
                answers: $this->composeAnswerDataList($item['answers'])
            );
        }

        return new ReviewerContentData(
            reviewerId: $reviewerId,
            items: $itemDataList,
            authUser: $this->getAuthUserData(),
            meta: $this->getMetaData()
        );
    }

    /**
     * Compose question data.
     *
     * @param array $question
     *
     * @return QuestionData
     */
    private function composeQuestionData(array $question): QuestionData
    {
        return new QuestionData(
            reviewerId: 0,
            content: $question['content'],
            attachments: $question['attachments'] ?? null,
            hint: $question['hint'] ?? null,
            answerExplanation: $question['answerExplanation'] ?? null
        );
    }

    /**
     * Compose choice data list.
     *
     * @param array $choices
     *
     * @return ChoiceData[]|array
     */
    private function composeChoiceDataList(array $choices): array
    {
        $choiceDataList = [];

        foreach ($choices as $choice) {
            $choiceDataList[] = new ChoiceData(
                questionId: 0,
                content: $choice['content']
            );
        }

        return $choiceDataList;
    }

    /**
     * Compose answer data list.
     *
     * @param array $answers
     *
     * @return AnswerData[]|array
     */
    private function composeAnswerDataList(array $answers): array
    {
        $answerDataList = [];

        foreach ($answers as $answer) {
            $answerDataList[] = new AnswerData(
                questionId: 0,
                content: $answer['content']
            );
        }

        return $answerDataList;
    }

}
