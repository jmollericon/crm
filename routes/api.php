<?php

use App\Http\Resources\TodayTaskResource;
use App\Http\Resources\UpcomingResource;
use App\Models\Today;
use App\Models\Upcoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

# UPcoming Task
# Get all the upcoming task
Route::get('/upcoming', function() {
    $upcoming = Upcoming::all();

    return UpcomingResource::collection($upcoming);
});
# Add a new task
Route::post('/upcoming', function(Request $request) {
    return Upcoming::create([
        'title' => $request->title,
        'taskId' => $request->taskId,
        'waiting' => $request->waiting
    ]);
});
# Delete upcoming task
Route::delete('/upcoming/{taskId}', function($taskId) {
    DB::table('upcomings')->where('taskId', $taskId)->delete();

    return 204;
});

# Today Task
Route::post('/dailytask', function(Request $request) {
    return Today::create([
        'id' => $request->id,
        'title' => $request->title,
        'taskId' => $request->taskId
    ]);
});
# Delete Today Task
Route::delete('/dailytask/{taskId}', function($taskId) {
    DB::table('todays')->where('taskId', $taskId)->delete();

    return 204;
});
# Get all todays task
Route::get('/dailytask', function() {
    $today = Today::all();

    return TodayTaskResource::collection($today);
});
