<?php

use Illuminate\Http\Request;
use App\Models\ConstractorOffer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\api\PlanController;
use App\Http\Controllers\api\OfferController;
use App\Http\Controllers\api\BuyingController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\ProviderController;
use App\Http\Controllers\api\ConstractorOfferController;
use App\Http\Controllers\api\ConsaltantProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Admin

Route::controller(ProviderController::class)->group(function (){

    Route::get('admin/provider/all' , 'show');
    Route::get('admin/provider/show/{id}' , 'showOne');
    Route::post('admin/provider/accept/{id}' , 'accept');
    Route::post('admin/provider/reject/{id}' , 'reject');

});







Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ProjectController::class)->group(function(){
    Route::post('project/create' , 'create');
    Route::get('project/showOne' , 'showOne');
    Route::get('project/all' , 'showAll');
});


Route::controller(OfferController::class)->group(function(){
    Route::post('offer/create' , 'create');
    Route::get('offer/project/{id}' , 'ShowProjectOffer');
    Route::get('offer/user' , 'ShowUserOffer');
    Route::post('offer/accept/{id}' , 'acceptOffer');
});


Route::controller(BuyingController::class)->group(function(){

    Route::post('buying/create' , 'create');
    Route::get('buying/all' , 'show');
    Route::get('buying/user' , 'ShowUserBuying');

});


Route::controller(ConsaltantProjectController::class)->group(function(){

    Route::post('consaltant/project/create' , 'create');
    Route::get('consaltant/project/get' , 'showAll');
    Route::get('consaltant/project/user' , 'ShowUserProject');

});


Route::controller(ConstractorOfferController::class)->group(function(){

    Route::post('constractor/offer/create' , 'create');
    Route::get('constractor/offer/project/{id}' , 'ShowoProjectOffer');

});


Route::controller(PlanController::class)->group(function(){

    Route::post('plan/create' , 'create');

});


Route::controller(PaymentController::Class)->group(function(){

    Route::post('payment/create' , 'create');
    Route::post('payment/update/main/{id}' , 'updateMain');

});

Route::controller(ChatController::class)->group(function(){

    Route::post('/chat/start',  'startConversation');
    Route::post('/chat/send', 'sendMessage');
    Route::get('/chat/conversations','getUserConversations');
    Route::get('/chat/messages/{conversation_id}','getMessages');

});

Route::controller(ProviderController::class)->group(function(){

    Route::post('provide/data/create' , 'create');

});
