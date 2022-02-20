<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * Login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $user = User::where('username', $request->username)->first();
            if ($user) {
                $passwordCheck = Hash::check($request->password, $user->password);

                if ($passwordCheck == true) {
                    return response(['token' => $user->createToken('web')->plainTextToken],200);
                } else {
                    return response(['errors' => 'There is no user with this credentials, please try again', 'status' => 'Failed'], 400);
                }
            } else {
                return response(['errors' => 'There is no user with this credentials, please try again', 'status' => 'Failed'], 400);
            }
        } else {
            $messages = $validator->messages()->toArray();
            return response(['errors' => $messages, 'status' => 'Failed'], 400);
        }
    }

    /**
     * get list of all users
     */
    public function index(Request $request){
        $user = $this->getLoggedUser($request);
        if(!$user->hasPermissionTo('user_index')){
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }
        return response()->json(['users' => $user->where('status','!=','deleted')->get()],200);
    }

    private function getLoggedUser($request){
        $bearer = $request->header('Authorization');
        $bearer = str_replace('Bearer ','',$bearer);
        $token = PersonalAccessToken::findToken($bearer);
        return User::find($token->tokenable_id);
    }

    /**
     * create new user
     */
    public function store(Request $request,User $user){
        $loggedUser = $this->getLoggedUser($request);
        if (!$loggedUser->hasPermissionTo('user_create')) {
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }

        $validator = Validator::make(request()->all(), $user->getRules('store'));
        if (!$validator->passes()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $request['password'] = Hash::make($request->password);
        $user->create(request()->all());

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * get data from certain user
     */
    public function getData(Request $request){
        $user = $this->getLoggedUser($request);
        if (!$user->hasPermissionTo('user_get_data')) {
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }
        $user = User::find(request('id'));
        if(!$user){
            return response()->json(['errors' => 'The user with that id does not exist in database'], 404);
        }

        return response()->json(['data' => $user],200);
    }

    /**
     * update user's data
     */
    public function update(Request $request){
        $user = $this->getLoggedUser($request);
        if (!$user->hasPermissionTo('user_edit')) {
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }

        $user = User::find(request('id'));

        $validator = Validator::make(request()->all(), $user->getRules('update'));
        if (!$validator->passes()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $user->update(request()->all());

        return response()->json(['status' => 'success'], 200);

    }

    /**
     * delete user
     */
    public function delete(Request $request){
        $user = $this->getLoggedUser($request);
        if (!$user->hasPermissionTo('user_delete')) {
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }

        $validator = Validator::make(request()->all(), ['id' => 'required']);
        if (!$validator->passes()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $user = User::find(request('id'));
        if(!$user){
            return response()->json(['errors' => 'The user with that id does not exist in database'], 404);
        }

        return $user->update(['status' => 'deleted']);
    }

    /**
     * assign role to the user
     */
    public function assignRole(Request $request){
        $user = $this->getLoggedUser($request);
        if (!$user->hasPermissionTo('user_assign_role')) {
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }

        $user = User::find(request('id'));
        if($user->assignRole($request->role)){
            return response()->json(['status' => 'success'],200);
        }
        return response()->json(['errors'=> 'Something went wrong, please try again'],400);
    }

    /**
     * check role of user
     */
    public function checkRole(Request $request)
    {
        $user = $this->getLoggedUser($request);
        if (!$user->hasPermissionTo($request->get('permission'))) {
            return response()->json(['errors' => ['User has no permission to this action']], 403);
        }
        return response()->json(['status' => 'success'], 200);
    }
}
