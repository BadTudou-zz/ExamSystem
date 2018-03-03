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
        $scores = json_decode(array_values($this->exam->paper->scores())[0]);
        foreach ($this->exam->users as $key => $user) {
            $answers = json_decode($user->pivot->answers);
            $score = 0;
            foreach ($answers as $key => $answer) {
               $question =  $questions->first(function ($item) use($key) {
                    return $item->id == $key;
                });
               if($question->answer == trim($answer)){
                    $score += $scores->$key;
               }

            }
            $user->pivot->score = $score;
            $user->pivot->correct_at = Carbon::now();
            $user->pivot->touch();
            $user->pivot->save();
        }
    }
}
