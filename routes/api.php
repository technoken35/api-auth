<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\TokenGuard;
use App\Models\User;
use App\Auth;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// * Since we changed the default guard we no longer have to specify we want to use the API guard(auth:api), because the api guard is no the default auth guard

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});


//create a user
Route::get('/user-create',function(Request $request){
    App\Models\User::create([
        'name'=>'Kendall',
        'email'=>'hayeskendall21@gmail.com',
        'password'=>Hash::make('password'),
    ]);
});

Route::get('/new-user',function(){
    request()->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
    ]);


    $user= User::create([
        'name'=> request('name'),
        'email'=>request('email'),
        'password'=>Hash::make(request('password')),
    ]);

    return response()->json([
        'status'=>'success',
        'message'=>'new user created',
        'user'=>$user
    ],200);
});




//login a user
Route::post('/login',function(){
    $credentials= request()->only(['email','password']);

    //attempt functions work not sure why it says undefined
    $token = auth()->attempt($credentials);

    // after the user is identifies by the credentials we can pull the user off the request helper
    $user= request()->user();


    return response()->json([
        "jwt"=>$token,
        'user'=>$user
    ],200);

});

// get the authenticated user
// this request accepts a bearer token as a header and we set the application type to JSON
Route::middleware('auth')->get('/me',function(){
    return auth()->user();
});





//logout a user

//* To logout a user we would simply dump the token from wherever we stored it in the front end. We also need to revoke access to this JWT

Route::get('/logout',function(){
    Auth::guard('api')->logout();

    return response()->json([
        'status' => 'success',
        'message' => 'logout'
    ], 200);
});

Route::get('/test',function(){
    return[env('API_USER_EMAIL')];
});
