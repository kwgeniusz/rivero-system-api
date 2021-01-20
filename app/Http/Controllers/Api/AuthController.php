<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
// use Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function username()
    {
            return 'userName';
    }

    public function register(Request $request)
    {

         $credentials = request(['countryId','companyId','changeCompany','fullName','userName','userPassword','email','dateCreated','lastUserId']);
         $credentials['userPassword'] = bcrypt($request->userPassword);
 
          return response(['user'=> $credentials]);
         $user = User::create($credentials);
 
         $accessToken = $user->createToken('authToken')->accessToken;
 
         return response(['user'=> $user, 'access_token'=> $accessToken]);
        
    }
    public function login(Request $request)
    {
        
        $credentials = request(['userName', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['data' => ['errors' => 'Please, check your login data']], 401);
        }
        // return Auth::attempt($credentials);
        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json(['data' => [
            'user' => Auth::user(),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ]], 200);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function session()
    {
        $user = auth()->user();
        return response()->json(['data' => ['user' => $user, 'message' => 'success']], 200);
    }
    
    public function logout(Request $request)
    {
        if ($request->user()->token()->revoke()) {
            return response()->json(['data' => ['message' => 'Successfully logged out']], 200);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
