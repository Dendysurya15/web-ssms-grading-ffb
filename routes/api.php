<?php

use App\Http\Controllers\CountController;
use App\Mail\EmailGrading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/insert_count/{ripe?}/{unripe?}/{overripe?}/{abnormal?}/{empty_bunch?}', [CountController::class, 'store']);

Route::get('/send_email_grading_total', function () {
    $recipients = 'dendysurya15@gmail.com';
    try {
        Mail::to($recipients)
            ->send(new EmailGrading());
        return "Email sent successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }

    // return view('emailLayout');
});
// Route::get('/greet', 'UserController@greet');