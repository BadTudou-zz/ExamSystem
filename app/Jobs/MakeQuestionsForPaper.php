<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Paper;
use App\PaperSection;
use App\Question;
use App\Tag;
use App\QuestionType;


class MakeQuestionsForPaper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->maker();
    }

    protected function maker()
    {
        $paper = Paper::findOrFail($this->data['id']);
        $tags = [];
        $types = json_decode($this->data['types']);
        $result = [];
        $sections = $paper->sections ? explode(",", $paper->sections) : [];

        foreach ($types as $typeId => $type) {
            logger($type->score);
            $questionNumber =  $type->number;
            $questions = $this->makeQuestionByTypeAndNumber($typeId, $questionNumber);

            $questionType = QuestionType::find($typeId);
            // 统计信息
            array_push($result, ['type_id' => $typeId, 'type' => $questionType->toArray(), 'number' => $questionNumber, 'count' => count($questions)]);

             // 创建试卷章节
            $section = new PaperSection();
            $section['name'] = $questionType->title;
            $section['describe'] = $questionType->title;
            $section['score'] = ((integer)$questionNumber * (integer)$type->score);
            $section['number'] = count($questions);
            $section['question_type'] = $questionType->id;
            $section['questions'] = implode(",", $questions);
            $section['scores'] = json_encode(array_fill_keys($questions, $type->score));
            $section->save();

            // 将试卷章节添加到试卷
            array_push($sections, $section->id);
            $paper->update(['sections' => implode(",", $sections)]);
        }

        return $result;
    }

    protected function makeQuestionByTypeAndNumber($typeId, $number)
    {
        return Question::where('type_id', $typeId)->limit($number)->inRandomOrder()->select('id')->get()->pluck('id')->all();
    }
}
