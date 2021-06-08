<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\faqcategorycontroller;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizCategoryController;
use App\Http\Controllers\IpledgeimportsController;
use App\Http\Controllers\CaseManagementController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\MdManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\TreatmentGuidesController;
use App\Http\Controllers\CaseStatusUpdateGetPrescriptionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    // Artisan::call('optimize --force');
});



Route::get('logout', function () {
    Auth::logout();
    // Artisan::call('cache:clear');
    //return redirect()->intended('login');
    return redirect(\URL::previous());
});

// Reset Password Routes

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'getPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('reset.password'); 

//Admin Routes
Route::group(['middleware' => ['auth']],function(){  

// Dashboard Routes    
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name("home.dashboard");
// Roles Routes  
    Route::get('admin/roles', [RoleController::class, 'index'])->name("roles.index");
    Route::get('admin/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('admin/roles/store', [RoleController::class, 'store'])->name("roles.store");
    Route::get('admin/roles/show/{id}', [RoleController::class, 'show'])->name("roles.show");
    Route::get('admin/roles/edit/{id}', [RoleController::class, 'edit'])->name("roles.edit");
    Route::patch('admin/roles/update/{id}', [RoleController::class, 'update'])->name("roles.update");
    Route::delete('admin/roles/destroy/{id}', [RoleController::class, 'destroy'])->name("roles.destroy");
// Users routes
    Route::get('admin/users', [UserController::class, 'index'])->name("users.index"); 
    Route::get('admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('admin/users/store', [UserController::class, 'store'])->name("users.store");   
    Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name("users.edit");   
    Route::put('admin/users/update/{id}', [UserController::class, 'update'])->name("users.update");  
    Route::get('admin/users/show/{id}', [UserController::class, 'show'])->name("users.show");
    Route::delete('admin/roles/delete/{id}', [UserController::class, 'destroy'])->name("users.destroy");    
 // Categories Routes
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('admin/categories/show/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('admin/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('admin/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('admin/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');  

// Products Routes
    Route::get('admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('admin/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('admin/products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('admin/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('admin/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('admin/products/upsell', [ProductController::class, 'upsell'])->name('products.upsell'); 

// Cms Routes
    Route::get('admin/cms', [CmsController::class, 'index'])->name('cms.index');
    Route::get('admin/cms/create', [CmsController::class, 'create'])->name('cms.create');
    Route::post('admin/cms/store', [CmsController::class, 'store'])->name('cms.store');
    Route::get('admin/cms/show/{id}', [CmsController::class, 'show'])->name('cms.show');
    Route::get('admin/cms/edit/{id}', [CmsController::class, 'edit'])->name('cms.edit');
    Route::patch('admin/cms/update/{id}', [CmsController::class, 'update'])->name('cms.update');
    Route::delete('admin/cms/destroy/{id}', [CmsController::class, 'destroy'])->name('cms.destroy');  

// Blogs Routes
    Route::get('admin/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('admin/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('admin/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('admin/blog/show/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('admin/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::patch('admin/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('admin/blog/destroy/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');

// Faqs Routes
    Route::get('admin/faq', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('admin/faq/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::post('admin/faq/store', [FaqController::class, 'store'])->name('faqs.store');
    Route::get('admin/faq/show/{id}', [FaqController::class, 'show'])->name('faqs.show');
    Route::get('admin/faq/edit/{id}', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::patch('admin/faq/update/{id}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('admin/faq/destroy/{id}', [FaqController::class, 'destroy'])->name('faqs.destroy');

//  Faqcategory's routes
    Route::get('admin/faqcategory',[faqcategorycontroller::class, 'index'])->name('faqcategory.index');
    Route::get('admin/faqcategory/create',[faqcategorycontroller::class, 'create'])->name('faqcategory.create');      
    Route::post('admin/faqcategory/store',[faqcategorycontroller::class, 'store'])->name('faqcategory.store');
    Route::get('admin/faqcategory/edit/{id}',[faqcategorycontroller::class, 'edit'])->name('faqcategory.edit');
    Route::patch('admin/faqcategory/update/{id}',[faqcategorycontroller::class, 'update'])->name('faqcategory.update');
    Route::delete('admin/faqcategory/destroy/{id}',[faqcategorycontroller::class, 'destroy'])->name('faqcategory.destroy');

// Permission Routes
    Route::get('admin/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('admin/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('admin/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('admin/permissions/show/{id}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('admin/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::patch('admin/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('admin/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');   

// Tags Routes
    Route::get('admin/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('admin/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('admin/tags/store', [TagController::class, 'store'])->name('tags.store');
    Route::get('admin/tags/show/{id}', [TagController::class, 'show'])->name('tags.show');
    Route::get('admin/tags/edit/{id}', [TagController::class, 'edit'])->name('tags.edit');
    Route::patch('admin/tags/update/{id}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('admin/tags/destroy/{id}', [TagController::class, 'destroy'])->name('tags.destroy');    

// Testomonial Routes
    Route::get('admin/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('admin/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('admin/testimonials/store', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('admin/testimonials/show/{id}', [TestimonialController::class, 'show'])->name('testimonials.show');
    Route::get('admin/testimonials/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::patch('admin/testimonials/update/{id}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('admin/testimonials/destroy/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');   

// Customer Routes
    Route::get('admin/customer', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('admin/customer/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('admin/customer/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('admin/customer/show/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('admin/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::patch('admin/customer/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('admin/customer/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy'); 
    

// Change password Routes

    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change.index');
    Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');    
    
// Quiz Routes
    Route::get('admin/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('admin/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('admin/quiz/store', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('admin/quiz/show/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::get('admin/quiz/edit/{id}', [QuizController::class, 'edit'])->name('quiz.edit');
    Route::patch('admin/quiz/update/{id}', [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('admin/quiz/destroy/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy');
    Route::post('admin/quiz/orderUpdate', [QuizController::class, 'orderUpdate'])->name('orderUpdate.update');
    Route::get('admin/quiz/option', [QuizController::class, 'option'])->name('quiz.option');
    
// Quiz Category Routes
    Route::get('admin/quizCategory', [QuizCategoryController::class, 'index'])->name('quizCategory.index');
    Route::get('admin/quizCategory/create', [QuizCategoryController::class, 'create'])->name('quizCategory.create');
    Route::post('admin/quizCategory/store', [QuizCategoryController::class, 'store'])->name('quizCategory.store');
    Route::get('admin/quizCategory/show/{id}', [QuizCategoryController::class, 'show'])->name('quizCategory.show');
    Route::get('admin/quizCategory/edit/{id}', [QuizCategoryController::class, 'edit'])->name('quizCategory.edit');
    Route::patch('admin/quizCategory/update/{id}', [QuizCategoryController::class, 'update'])->name('quizCategory.update');
    Route::delete('admin/quizCategory/destroy/{id}', [QuizCategoryController::class, 'destroy'])->name('quizCategory.destroy');  

    //Ipledge
    //Route::resource('admin/ipledgeimports',\App\Http\Controllers\IpledgeimportsController::class);  
    Route::get('admin/ipledgeimports', [IpledgeimportsController::class, 'index'])->name('ipledgeimports.index');
    Route::get('admin/ipledgeimports/create', [IpledgeimportsController::class, 'create'])->name('ipledgeimports.create');
    Route::post('import', [IpledgeimportsController::class, 'import'])->name('import');
    Route::get('admin/ipledgeimports/downloaddocuments/{id}', [IpledgeimportsController::class, 'downloaddocuments'])->name('IpledgefileDownload');   

    //User Case Management 
    Route::get('admin/casemanagement', [CaseManagementController::class, 'index'])->name('casemanagement.index');
    Route::get('admin/casemanagement/show/{id}', [CaseManagementController::class, 'show'])->name('casemanagement.show');
    Route::post('admin/casemanagement/upload_pregnancy_test_report', [CaseManagementController::class, 'upload_pregnancy_test_report'])->name('upload_pregnancy_test_report');
    Route::post('admin/casemanagement/upload_blood_test_report', [CaseManagementController::class, 'upload_blood_test_report'])->name('upload_blood_work_test_report');
    Route::post('admin/casemanagement/i_pledge_agreement', [CaseManagementController::class, 'i_pledge_agreement'])->name('i_pledge_agreement');
    Route::post('CaseStatus',[CaseManagementController::class, 'getCaseStatus']);
     Route::post('admin/casemanagement/sendMessageNonMedical', [CaseManagementController::class, 'sendMessageNonMedical'])->name('sendMessageNonMedical');


    //fees
    Route::get('admin/fees', [FeesController::class, 'index'])->name('fees.index');
    Route::get('admin/fees/create', [FeesController::class, 'create'])->name('fees.create');
    Route::post('admin/fees/store', [FeesController::class, 'store'])->name('fees.store');
    Route::get('admin/fees/show/{id}', [FeesController::class, 'show'])->name('fees.show');
    Route::get('admin/fees/edit/{id}', [FeesController::class, 'edit'])->name('fees.edit');
    Route::patch('admin/fees/update/{id}', [FeesController::class, 'update'])->name('fees.update');
    Route::delete('admin/fees/destroy/{id}', [FeesController::class, 'destroy'])->name('fees.destroy');

    //Md Managment
    Route::get('admin/mdmanagement', [MdManagementController::class, 'index'])->name('mdmanagement.index');
    Route::get('admin/mdmanagement/create', [MdManagementController::class, 'create'])->name('mdmanagement.create');
    Route::post('admin/mdmanagement/store', [MdManagementController::class, 'store'])->name('mdmanagement.store');
    Route::get('admin/mdmanagement/show/{id}', [MdManagementController::class, 'show'])->name('mdmanagement.show');
    Route::get('admin/mdmanagement/edit/{id}', [MdManagementController::class, 'edit'])->name('mdmanagement.edit');
    Route::patch('admin/mdmanagement/update/{id}', [MdManagementController::class, 'update'])->name('mdmanagement.update');
    Route::delete('admin/mdmanagement/destroy/{id}', [MdManagementController::class, 'destroy'])->name('mdmanagement.destroy');

    //Order Management
    Route::get('admin/ordermanagement', [OrderManagementController::class, 'index'])->name('ordermanagement.index');
    Route::get('admin/ordermanagement/show/{id}', [OrderManagementController::class, 'show'])->name('ordermanagement.show');

     //TreatmentGuides
    Route::get('admin/treatmentGuides', [TreatmentGuidesController::class, 'index'])->name('treatmentGuides.index');
    Route::get('admin/treatmentGuides/create', [TreatmentGuidesController::class, 'create'])->name('treatmentGuides.create');
    Route::post('admin/treatmentGuides/store', [TreatmentGuidesController::class, 'store'])->name('treatmentGuides.store');
    Route::get('admin/treatmentGuides/show/{id}', [TreatmentGuidesController::class, 'show'])->name('treatmentGuides.show');
    Route::get('admin/treatmentGuides/edit/{id}', [TreatmentGuidesController::class, 'edit'])->name('treatmentGuides.edit');
    Route::patch('admin/treatmentGuides/update/{id}', [TreatmentGuidesController::class, 'update'])->name('treatmentGuides.update');
    Route::delete('admin/treatmentGuides/destroy/{id}', [TreatmentGuidesController::class, 'destroy'])->name('treatmentGuides.destroy');


    //cron 
    Route::get('admin/CaseStatusUpdateGetPrescriptionController', [CaseStatusUpdateGetPrescriptionController::class, 'index'])->name('CaseStatusUpdateGetPrescriptionController');
    
});


