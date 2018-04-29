<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\Index as IndexExam;
use App\Http\Requests\Exam\Store as StoreExam;
use App\Http\Requests\Exam\Update as UpdateExam;
use App\Http\Requests\Exam\Show as ShowExam;
use App\Http\Requests\Exam\Destroy as DestroyExam;
use App\Http\Requests\Exam\Answer as AnswerExam;
use App\Http\Requests\Exam\Begin as BeginExam;
use App\Http\Requests\Exam\AddUsers as AddUsersToExam;
use App\Http\Requests\Exam\DeleteUsers as DeleteUsersFromExam;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\ExamResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserExamResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Jobs\CorrecExam;
use App\Util\OrmUtil;

use App\Exam;
use App\User;

class ExcelController extends Controller
{
        public function test () {
            dd(public_path());
        }
}
