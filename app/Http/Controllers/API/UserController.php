<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\LectureCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\LoginUser;
use App\Http\Requests\IndexUser;
use App\Http\Requests\ShowUser;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\DestroyUser;
use App\Http\Requests\UpdateUserPassword;
use Validator;
use App\Captcha;
use App\Util\CaptchaUtil;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public $successStatus = 200;

    public function index(IndexUser $request)
    {
        return new UserCollection(User::paginate());
    }

    public function show(ShowUser $request, $id)
    {
        return new UserResource(User::find($id));
    }

    public function update(UpdateUser $request, $id)
    {
        $user = User::find($id);
        $user->update($request->except('password'));
        return new UserResource($user);
    }

    public function updatePassword(UpdateUserPassword $request, $id)
    {
        $user = User::find($id);
        if ( Hash::check($request->get('password'), $user->password) ) {
            $user->update(['password' => Hash::make(trim($request->get('newPassword')))]) ;
        } else {
            return response()->json(['error'=>' password error'], 401);
        }
    }

    public function destroy(DestroyUser $request, $id)
    {
        User::find($id)->delete();
    }

    public function organizations(ShowUser $request, $id)
    {
        return new OrganizationCollection(User::find($id)->organizations()->paginate());
    }

    public function lectures(ShowUser $request, $id)
    {
        return new LectureCollection(User::find($id)->lectures()->paginate());
    }

    public function roles(ShowUser $request, $id)
    {
        return new RoleCollection(User::find($id)->roles()->paginate());
    }

    public function permissions(ShowUser $request, $id)
    {
        $permissions = User::find($id)->roles()->get()->map(function ($role){
            return $role->perms()->get();
        })[0];
        return new PermissionCollection($this->paginate($permissions));
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {   
        // 检测验证码
        if (!CaptchaUtil::check(0, Captcha::PURPOSE_LOGIN, $request->get('captcha')) ){
            return response()->json(['error'=>'Bad captcha！'], 400);
        }

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = Auth::user();

            // 删除之前的令牌
            $user->tokens()->delete();
            $data['token'] =  $user->createToken('MyApp')->accessToken;
            $data['user'] = $user;
            return response()->json(['data' => $data], $this->successStatus);
        } else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // 检测验证码
        if (!CaptchaUtil::check(0, Captcha::PURPOSE_REGISTER, $request->get('captcha')) ){
            return response()->json(['error'=>'Bad captcha！'], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'captcha' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User($input);
        $user->save();
        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['user'] = $user;

        return response()->json(['data'=>$data], $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
