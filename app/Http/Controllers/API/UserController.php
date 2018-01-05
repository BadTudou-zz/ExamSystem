<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Requests\IndexUser;
use App\Http\Requests\ShowUser;
use App\Http\Requests\UpdateUser;
use Validator;

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

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
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
}
