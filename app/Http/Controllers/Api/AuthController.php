<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Register a User
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // Request is valid, create new user
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        // User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Login a User
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // Request is validated
        // Create token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	    return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }
 	
 		// Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'accessToken' => $token,
        ]);
    }

    /**
     * Logout a User
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		// Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a User
     * 
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request, $token)
    { 
        $user = JWTAuth::authenticate($token);

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], Response::HTTP_OK);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'User not found, Token mismatch'
        ], Response::HTTP_OK);
    }

    /**
     * Update User Information
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate requests
        $validator = Validator::make($request->only('id', 'name', 'email'), [
            'id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email|unique:users'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);
    }
}
