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
use App\Http\Controllers\API\AnswerController;
use App\Http\Controllers\API\TreatmentGuidesController;
use App\Http\Controllers\API\ChangePasswordController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\FollowupController;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\ActionitemsController;
use App\Http\Controllers\API\MdwebhooksController;
use App\Http\Controllers\API\shipStationController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\BirthControlController;

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
Route::post('forgot_password', [RegisterController::class, 'forgot_password']);
Route::resource('blogs', BlogController::class);
Route::resource('products', ProductController::class);
Route::get('getalltags', [BlogController::class, 'getAllTags']);
Route::get('getmostpopular', [BlogController::class, 'most_popular']);
Route::resource('category', CategoryController::class);
Route::resource('cms', CmsController::class);
Route::get('cmspages/{pagenameid}', [CmsController::class, 'show']);
Route::get('faqlist/{category}', [FaqController::class, 'index']);
Route::get('faq_category', [FaqController::class, 'getFaqCategoryList']);
Route::resource('testimonial', TestimonialController::class);
Route::get('getAllStates', [CaseManagementController::class, 'getAllStates']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get("getbirthcontrol/{id}", [BirthControlController::class, 'show']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::resource('checkout', CheckoutController::class);
    //Treatment Guides
    Route::resource('treatmentGuides', TreatmentGuidesController::class);
    Route::get('treatmentGuides/{id}', [TreatmentGuidesController::class, 'show']);
    Route::resource('quiz', QuizController::class);
    Route::resource('quizAnswer', QuizAnswerController::class);
    Route::get('quizAnswer/user/{id}', [QuizAnswerController::class, 'getAnswerByUser']);
    Route::post('questionByOrderAndCategory', [QuizController::class, 'getQuizByOrderAndCategory']);
    Route::get('getQuestionListOfGeneral', [QuizController::class, 'getQuestionListOfGeneral']);
    Route::get('quizAnswer/question/{id}', [QuizAnswerController::class, 'getAnswerByQuestion']);
    Route::post('getQuizAnswer', [QuizAnswerController::class, 'getAnswerByUserQuestionCaseID']);
    Route::get('quizCategory', [QuizController::class, 'getQuizCategoryList']);
    Route::post('user/update/{id}', [UserController::class, 'update_user']);
    //Route::get('user/{id}', [UserController::class, 'show']);
    Route::get('userlist', [UserController::class, 'userlist']);
    Route::post('sendmail', [UserController::class, 'sendmail']);
    Route::post('addParentdetails', [UserController::class, 'addParentdetails']);
    Route::post('getParentdetails', [UserController::class, 'getParentdetails']);
    //Cart
    Route::resource('cart', CartController::class);
    Route::get('cart/item/{id}', [CartController::class, 'getCartByUser']);
    Route::get('cart/prescribeditem/{id}', [CartController::class, 'getCartByUserPrescribed']);
    Route::get('cart/addonitem/{id}', [CartController::class, 'getCartByUserAddOn']);
    Route::post('cart/addonItemUpdate/{id}', [CartController::class, 'addonItemUpdate']);
    Route::post('cart/cartRemove/{id}', [CartController::class, 'cartRemove']);
    Route::post('cart/prescribedItemUpdate', [CartController::class, 'prescribedItemUpdate']);
    Route::post('getFees', [FeeController::class, 'getFees']);
    Route::resource('caseManagement', CaseManagementController::class);
    Route::post('createOrder', [CheckoutController::class, 'store']);
    Route::post('addCheckoutAddress', [CheckoutController::class, 'addCheckoutAddress']);
    Route::post('updateCheckoutAddress', [CheckoutController::class, 'updateCheckoutAddress']);
    Route::post('orderList', [CheckoutController::class, 'orderList']);
    Route::post('getOrderDetail', [CheckoutController::class, 'getCheckoutdetail']);
    Route::post('getCheckoutAddress', [CheckoutController::class, 'getCheckoutAddress']);
    Route::post('getTaxes', [CheckoutController::class, 'getTaxes']);
    Route::post('getCheckoutByCustomer', [CheckoutController::class, 'getCheckoutByCustomer']);
    Route::post('getUsersLatestOrder', [CheckoutController::class, 'getUsersLatestOrder']);
    Route::get('getUpsellProductDetails', [ProductController::class, 'getUpsellProductDetails']);
    Route::get('getskincareplan', [ProductController::class, 'getskincareplan']);
    Route::post('ProductRecommend', [QuizAnswerController::class, 'ProductRecommend']);
    Route::post('ProductRecommendBasedONTretinoinFormula', [QuizAnswerController::class, 'ProductRecommendBasedONTretinoinFormula']);
    Route::post('ProductActive', [ProductController::class, 'ProductActive']);
    //MD API
    Route::post('create_patient', [CaseManagementController::class, 'create_patient']);
    Route::post('demo', [CaseManagementController::class, 'demo']);
    Route::post('getToken', [CaseManagementController::class, 'get_token']);
    Route::post('searchStateDetail', [CaseManagementController::class, 'searchStateDetail']); //search state data
    Route::post('getCitiesFromGivenState', [CaseManagementController::class, 'getCitiesFromGivenState']);
    Route::post('SearchCitiesFromGivenState', [CaseManagementController::class, 'SearchCitiesFromGivenState']); //search city data
    Route::post('createCaseFile', [CaseManagementController::class, 'createCaseFile']);
    Route::post('getPharmacies', [CaseManagementController::class, 'getPharmacies']);
    Route::post('getPharmacyById', [CaseManagementController::class, 'getPharmacyById']);
    Route::post('CreateCase', [CaseManagementController::class, 'CreateCase']);
    Route::post('getMdDetails', [CaseManagementController::class, 'getMdDetails']);
    Route::post('detach_file_from_case', [CaseManagementController::class, 'detach_file_from_case']);
    Route::post('createMessageFile', [CaseManagementController::class, 'createMessageFile']);
    Route::post('createMessage', [CaseManagementController::class, 'createMessage']);
    Route::post('setMessageAsRead', [CaseManagementController::class, 'setMessageAsRead']);
    Route::post('getMessages', [CaseManagementController::class, 'getMessages']);
    Route::post('DetachMessageFile', [CaseManagementController::class, 'DetachMessageFile']);
    Route::get('DeleteFile/{id}', [CaseManagementController::class, 'DeleteFile']);
    Route::post('getMdDetailForMessage', [CaseManagementController::class, 'getMdDetailForMessage']);
    Route::post('DetachNonmedicalMessageWithFile', [CaseManagementController::class, 'DetachNonmedicalMessageWithFile']);
    Route::post('getTestReport', [CaseManagementController::class, 'getTestReport']);
    //end of md api
    Route::post('updateFieldInCaseManagement', [CaseManagementController::class, 'updateFieldInCaseManagement']);

    //system message API
    Route::post('sendMessageNonMedical', [CaseManagementController::class, 'sendMessageNonMedical']);
    Route::post('getMessagesNonMedical', [CaseManagementController::class, 'getMessagesNonMedical']);
    Route::post('user/update_vouch_status', [UserController::class, 'updateVerifiedByVouch']);
    Route::get('user/vouch_details/{id}', [UserController::class, 'getVouchedDetails']);
    Route::post('user/add_user_pic', [UserController::class, 'addUserPic']);
    Route::post('user/get_user_pic', [UserController::class, 'getUserPic']);
    Route::post('add_recomeended_product', [CaseManagementController::class, 'add_recomeended_product']);

    //Offer & Promotion
    Route::resource('offerPromotion', OfferController::class);
    Route::post("applyGiftCard", [OfferController::class, 'applyGiftCard']);

    //Answer API
    Route::post('answer', [AnswerController::class, 'answer']);
    Route::post('getAnswer', [AnswerController::class, 'getAnswer']);

    //Follow Up
    Route::post('addFollowUpAnswer', [FollowupController::class, 'addFollowUpData']);
    Route::post('getFollowUpAnswer', [FollowupController::class, 'getFollowUpAnswer']);
    Route::post('updateFollowUpData', [FollowupController::class, 'updateFollowUpData']);
    Route::post('createFollowUpMDCase', [FollowupController::class, 'createFollowUpMDCase']);

    //payment
    Route::post('payments', [PaymentsController::class, 'store']);
    Route::post('subscribe_store', [PaymentsController::class, 'subscribe_store']);
    Route::post('cancel_subscription', [PaymentsController::class, 'cancel_subscription']);
    Route::post('customer_payment_methods', [PaymentsController::class, 'customer_payment_methods']);
    Route::post('customer_make_direct_payment', [PaymentsController::class, 'customer_make_direct_payment']);
    Route::post('getSubscriptionByUser', [PaymentsController::class, 'getSubscriptionByUser']);
    Route::post('changePaymentMethod', [PaymentsController::class, 'changePaymentMethod']);

    //Change Plan
    Route::get('changeMyPlan', [PaymentsController::class, 'changeMyPlan']);
    Route::post('updateMyPlan', [PaymentsController::class, 'updateMyPlan']);

    //Action Items

    Route::post('addIpledgeAgreement', [ActionitemsController::class, 'addIpledgeAgreement']);
    Route::post('getIpledgeAgreement', [ActionitemsController::class, 'getIpledgeAgreement']);
    Route::post('showActionItemsForm', [ActionitemsController::class, 'showActionItemsForm']);

    //webhook
    Route::post('webhookTriggers', [MdwebhooksController::class, 'webhookTriggers']);
    //Change Password
    Route::post('changePassword', [ChangePasswordController::class, 'changePassword']);

    Route::get('getshipstationOrderdetail', [shipStationController::class, 'getOrderDetails']);
    Route::get('getordershipments/{orderId}', [shipStationController::class, 'getshipments']);

    Route::get('showNotifications', [NotificationController::class, 'getHomeNotifications']);
    Route::get('getAllNotifcations', [NotificationController::class, 'getAllNotifications']);
    Route::get("getUnreadNotificationcount", [NotificationController::class, 'getUnreadNotifications']);
    Route::post("markasreadNotifications", [NotificationController::class, 'markAsreadNotification']);

    //BirthControl
    Route::post("createBirthControl", [BirthControlController::class, 'store']);
    Route::get("getbirthcontrol/{id}", [BirthControlController::class, 'show']);
});
