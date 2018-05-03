<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class CorrecExam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $exam;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exam)
    {
        $this->exam = $exam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $questions = $this->exam->paper->questions();
        $scores = $this->exam->paper->scores();
        foreach ($this->exam->users as $key => $user) {
            $answers = json_decode($user->pivot->answers);
            $result = [];
            $score = 0;
            foreach ($answers as $key => $answer) {
               $question =  $questions->first(function ($item) use($key) {
                    return $item->id == $key;
                });
               if($question->answer == trim($answer)){
                    $score += $scores[$key];
                    array_push($result, [$key => ['status' => true, 'content' => $answer, 'answer' => $question->answer]]);
               } else {
                    array_push($result, [$key => ['status' => false, 'content' => $answer, 'answer' => $question->answer]]);
               }

            }
            $user->pivot->result = json_encode($result);
            $user->pivot->score = $score;
            $user->pivot->correct_at = Carbon::now();
            $user->pivot->touch();
            $user->pivot->save();
        }
    }
}
