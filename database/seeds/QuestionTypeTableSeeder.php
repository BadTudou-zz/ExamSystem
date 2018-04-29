<?php

use Illuminate\Database\Seeder;
use App\QuestionType;

class QuestionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['SINGLE_CHOICE', 'MULTIPLE_CHOICE', 'TRUE_FALSE', 'FILL_IN', 'SHORT_ANSWER'];
        $titles = ['单选题', '多选题', '判断题', '填空题', '简答题'];
        $delimiters = ['!', '@', '#', '$', '%'];

        foreach ($names as $key => $name) {
            $questionType = new QuestionType();
            $questionType->name = $name;
            $questionType->title = $titles[$key];
            $questionType->delimiter = $delimiters[$key];
            $questionType->save();
        }
        
    }
}
