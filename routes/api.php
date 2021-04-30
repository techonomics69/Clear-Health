<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
  
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CmsController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuizAnswerController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\FeeController;
use App\Http\Controllers\API\CaseManagementController;
use App\Http\Controllers\API\CheckoutController;
  
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
  
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('forgot_password',[RegisterController::class, 'forgot_password']);
     
//Route::middleware('auth:api')->group( function () {
    Route::resource('checkout',CheckoutController::class);
    Route::resource('products', ProductController::class);
    Route::resource('blogs', BlogController::class);
    Route::get('getalltags',[BlogController::class, 'getAllTags']);
    Route::get('getmostpopular',[BlogController::class, 'most_popular']);
    
    Route::resource('category', CategoryController::class);
    Route::resource('cms', CmsController::class);
    Route::get('cmspages/{pagenameid}',[CmsController::class,'show']);
    Route::get('faqlist/{category}', [FaqController::class, 'index']);
    Route::get('faq_category', [FaqController::class ,'getFaqCategoryList']);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('quiz', QuizController::class);
    Route::resource('quizAnswer', QuizAnswerController::class);
    Route::get('quizAnswer/user/{id}', [QuizAnswerController::class, 'getAnswerByUser']);
    Route::get('quizAnswer/question/{id}', [QuizAnswerController::class, 'getAnswerByQuestion']);
    Route::post('getQuizAnswer', [QuizAnswerController::class, 'getAnswerByUserQuestionCaseID']);
    Route::get('quizCategory', [QuizController::class ,'getQuizCategoryList']);
	Route::post('user/update/{id}', [UserController::class, 'update_user']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::get('userlist', [UserController::class, 'userlist']);
    Route::post('sendmail', [UserController::class, 'sendmail']); 
    Route::post('addParentdetails', [UserController::class, 'addParentdetails']);
    Route::post('getParentdetails', [UserController::class, 'getParentdetails']);
    Route::resource('cart', CartController::class);
    Route::get('cart/item/{id}',[CartController::class, 'getCartByUser']);
    Route::get('cart/prescribeditem/{id}',[CartController::class, 'getCartByUserPrescribed']);
    Route::post('getFees',[FeeController::class, 'getFees']);
    Route::resource('caseManagement', CaseManagementController::class);
    Route::post('createOrder', [CheckoutController::class, 'store']);
    Route::post('addCheckoutAddress', [CheckoutController::class, 'addCheckoutAddress']);
    Route::post('getCheckoutdetail', [CheckoutController::class, 'getCheckoutdetail']);
    Route::post('getCheckoutAddress', [CheckoutController::class, 'getCheckoutAddress']);
    Route::get('getUpsellProductDetails', [ProductController::class, 'getUpsellProductDetails']);
    Route::get('getskincareplan', [ProductController::class, 'getskincareplan']);
    Route::post('ProductRecommend',[QuizAnswerController::class, 'ProductRecommend']);
    Route::post('ProductActive',[ProductController::class, 'ProductActive']);

    //MD API

    Route::post('create_patient', [CaseManagementController::class, 'create_patient']);
    Route::post('demo', [CaseManagementController::class, 'demo']);
    Route::post('getToken', [CaseManagementController::class, 'get_token']);
    Route::post('searchStateDetail', [CaseManagementController::class, 'searchStateDetail']);//search state data
    Route::get('getAllStates', [CaseManagementController::class, 'getAllStates']);
    Route::post('getCitiesFromGivenState', [CaseManagementController::class, 'getCitiesFromGivenState']);
    Route::post('SearchCitiesFromGivenState', [CaseManagementController::class, 'SearchCitiesFromGivenState']);//search city data
    Route::post('createCaseFile', [CaseManagementController::class, 'createCaseFile']);
    Route::post('getPharmacies', [CaseManagementController::class, 'getPharmacies']); 
    Route::post('getPharmacyById', [CaseManagementController::class, 'getPharmacyById']);
     Route::post('CreateCase', [CaseManagementController::class, 'CreateCase']);
    //end of md api

    Route::group(['middleware' => 'auth:api'], function(){});
//});