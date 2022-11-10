<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintCategoryController;
use App\Http\Controllers\EFormCategoryController;
use App\Http\Controllers\ComplaintProductController;
use App\Http\Controllers\EFormProductController;
use App\Http\Controllers\ComplaintManagementController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\EFormTypeController;
use App\Http\Controllers\EscalationGroupController;
use App\Http\Controllers\DailyCalendarController;
use App\Http\Controllers\WeekendsCalendarController;
use App\Http\Controllers\HolidaysCalendarController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EFormManagementController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


#region complaint category
Route::get('complaint_category_create', [ComplaintCategoryController::class, 'create'])->name('complaint_category_create');
Route::post('complaint_category_create', [ComplaintCategoryController::class, 'store'])->name('complaint_category_create');
Route::get('complaint_category_index', [ComplaintCategoryController::class, 'index'])->name('complaint_category_index');
Route::get('complaint_category_edit/{id}', [ComplaintCategoryController::class, 'edit'])->name('complaint_category_edit');
Route::post('complaint_category_edit/{id}', [ComplaintCategoryController::class, 'update'])->name('complaint_category_edit');
#endregion complaint category

#region complaint product
Route::get('complaint_product_create', [ComplaintProductController::class, 'create'])->name('complaint_product_create');
Route::post('complaint_product_create', [ComplaintProductController::class, 'store'])->name('complaint_product_create');
Route::get('complaint_product_index', [ComplaintProductController::class, 'index'])->name('complaint_product_index');
Route::get('complaint_product_edit/{id}', [ComplaintProductController::class, 'edit'])->name('complaint_product_edit');
Route::post('complaint_product_edit/{id}', [ComplaintProductController::class, 'update'])->name('complaint_product_edit');
#endregion complaint product

#region e form category
Route::get('e_form_category_create', [EFormCategoryController::class, 'create'])->name('e_form_category_create');
Route::post('e_form_category_create', [EFormCategoryController::class, 'store'])->name('e_form_category_create');
Route::get('e_form_category_index', [EFormCategoryController::class, 'index'])->name('e_form_category_index');
Route::get('e_form_category_edit/{id}', [EFormCategoryController::class, 'edit'])->name('e_form_category_edit');
Route::post('e_form_category_edit/{id}', [EFormCategoryController::class, 'update'])->name('e_form_category_edit');
#endregion e form category

#region e form product
Route::get('e_form_product_create', [EFormProductController::class, 'create'])->name('e_form_product_create');
Route::post('e_form_product_create', [EFormProductController::class, 'store'])->name('e_form_product_create');
Route::get('e_form_product_index', [EFormProductController::class, 'index'])->name('e_form_product_index');
Route::get('e_form_product_edit/{id}', [EFormProductController::class, 'edit'])->name('e_form_product_edit');
Route::post('e_form_product_edit/{id}', [EFormProductController::class, 'update'])->name('e_form_product_edit');
#endregion e form product

#region Complaint type
Route::get('complaint_type_create', [ComplaintTypeController::class, 'create'])->name('complaint_type_create');
Route::post('complaint_type_create', [ComplaintTypeController::class, 'store'])->name('complaint_type_create');
Route::get('complaint_type_index', [ComplaintTypeController::class, 'index'])->name('complaint_type_index');
Route::get('complaint_type_edit/{id}', [ComplaintTypeController::class, 'edit'])->name('complaint_type_edit');
Route::post('complaint_type_edit/{id}', [ComplaintTypeController::class, 'update'])->name('complaint_type_edit');
#endregion Complaint type

#region Complaint management
Route::get('complaint_create', [ComplaintManagementController::class, 'create'])->name('complaint_create');
Route::get('get_product_category', [ComplaintManagementController::class, 'productCategory'])->name('get_product_category');
Route::get('get_complaint_type', [ComplaintManagementController::class, 'complaintType'])->name('get_complaint_type');
Route::post('complaint_create', [ComplaintManagementController::class, 'store'])->name('complaint_create');
Route::get('complaint_index', [ComplaintManagementController::class, 'index'])->name('complaint_index');
Route::get('get_unit_groups', [ComplaintManagementController::class, 'unitGroup'])->name('get_unit_groups');
Route::get('complaint_show/{id}', [ComplaintManagementController::class, 'show'])->name('complaint_show');
Route::post('complaint_edit/{id}', [ComplaintManagementController::class, 'update'])->name('complaint_edit');
Route::post('update_progress/{id}', [ComplaintManagementController::class, 'updateProgress'])->name('update_progress');
#endregion Complaint management

#region E Form type
Route::resource('e_form_type', EFormTypeController::class);
#endregion E Form type

#region Escalation Group
Route::resource('escalation_group', EscalationGroupController::class);
#endregion Escalation Group

#region Daily Calendar
Route::resource('daily_calendar', DailyCalendarController::class);
#endregion Daily Calendar

#region Week End
Route::resource('week_end', WeekendsCalendarController::class);
#endregion Week End

#region Week End
Route::resource('holidays', HolidaysCalendarController::class);
#endregion Week End

#region Template
Route::resource('template', TemplateController::class);
#endregion Template

#region Unit
Route::resource('unit', UnitController::class);
#endregion Unit

#region Group
Route::resource('group', GroupController::class);
#endregion Group

#region User
Route::resource('user', UserController::class);
Route::get('user_status/{id}', [UserController::class, 'status'])->name('user_status');
Route::get('get_all_regions', [UserController::class, 'GetAllRegion'])->name('get_all_regions');
Route::get('get_unit_regions', [UserController::class, 'GetUnitRegion'])->name('get_unit_regions');
#endregion User

#region Role
Route::resource('role', RoleController::class);
#endregion Role

#region E From management
Route::get('e_form_create', [EFormManagementController::class, 'create'])->name('e_form_create');
Route::post('e_form_store', [EFormManagementController::class, 'store'])->name('e_form_store');
Route::get('get_e_form_type', [EFormManagementController::class, 'eFormType'])->name('get_e_form_type');
Route::get('e_form_index', [EFormManagementController::class, 'index'])->name('e_form_index');
Route::get('e_form_show/{id}', [EFormManagementController::class, 'show'])->name('e_form_show');
Route::post('e_form_edit/{id}', [EFormManagementController::class, 'update'])->name('e_form_edit');
Route::post('e_form_update_progress/{id}', [EFormManagementController::class, 'updateProgress'])->name('e_form_update_progress');
#endregion E From management

#region Announcement management
Route::get('announcement_create', [AnnouncementController::class, 'create'])->name('announcement_create');
Route::post('announcement_submit', [AnnouncementController::class, 'store'])->name('announcement_submit');
Route::get('delete_annoucement', [AnnouncementController::class, 'destroyShow'])->name('delete_annoucement');
Route::post('announcement_delete/{id}', [AnnouncementController::class, 'destroy'])->name('announcement_delete');
Route::get('announcement_index', [AnnouncementController::class, 'index'])->name('announcement_index');
Route::get('announcement_edit/{id}', [AnnouncementController::class, 'edit'])->name('announcement_edit');
Route::post('announcement_update/{id}', [AnnouncementController::class, 'update'])->name('announcement_update');
#endregion Announcement management

#region Customer Search
Route::get('customer_search', function () {
    return view('admin/customer-search/customer_search');
})->name('customer_search');
Route::get('customer_info', function () {
    return view('admin/customer-search/customer_info');
})->name('customer_info');
#endregion Customer Search

Route::get('get_product_category_eform', [EFormTypeController::class, 'productCategory'])->name('get_product_category_eform');

});











// Route::get('e_form_create', function () {
//     return view('admin/e-form/e_form_create');
// })->name('e_form_create');

// Route::get('e_form_index', function () {
//     return view('admin/e-form/e_form_index');
// })->name('e_form_index');

// Route::get('e_form_type_create', function () {
//     return view('admin/e-form/e_form_type_create');
// })->name('e_form_type_create');

// Route::get('e_form_type_index', function () {
//     return view('admin/e-form/e_form_type_index');
// })->name('e_form_type_index');

// Route::get('e_form_type_edit', function () {
//     return view('admin/e-form/e_form_type_edit');
// })->name('e_form_type_edit');



// Route::get('complaint_type_create', function () {
//     return view('admin/complaint/complaint_type_create');
// })->name('complaint_type_create');

// Route::get('complaint_type_index', function () {
//     return view('admin/complaint/complaint_type_index');
// })->name('complaint_type_index');

// Route::get('complaint_type_edit', function () {
//     return view('admin/complaint/complaint_type_edit');
// })->name('complaint_type_edit');

// Route::get('user_create', function () {
//     return view('admin/administration/user_create');
// })->name('user_create');

// Route::get('user_index', function () {
//     return view('admin/administration/user_index');
// })->name('user_index');
// Route::get('user_edit', function () {
//     return view('admin/administration/user_edit');
// })->name('user_edit');

// Route::get('group_edit', function () {
//     return view('admin/group/group_edit');
// })->name('group_edit');

// Route::get('group_create', function () {
//     return view('admin/group/group_create');
// })->name('group_create');

// Route::get('group_index', function () {
//     return view('admin/group/group_index');
// })->name('group_index');

// Route::get('role_index', function () {
//     return view('admin/role/role_index');
// })->name('role_index');

// Route::get('role_create', function () {
//     return view('admin/role/role_create');
// })->name('role_create');

// Route::get('role_edit', function () {
//     return view('admin/role/role_edit');
// })->name('role_edit');

// Route::get('unit_index', function () {
//     return view('admin/organization-unit/unit_index');
// })->name('unit_index');

// Route::get('unit_create', function () {
//     return view('admin/organization-unit/unit_create');
// })->name('unit_create');

// Route::get('unit_edit', function () {
//     return view('admin/organization-unit/unit_edit');
// })->name('unit_edit');

// Route::get('template_index', function () {
//     return view('admin/template/template_index');
// })->name('template_index');

// Route::get('template_create', function () {
//     return view('admin/template/template_create');
// })->name('template_create');

// Route::get('template_edit', function () {
//     return view('admin/template/template_edit');
// })->name('template_edit');


// Route::get('calender_index', function () {
//     return view('admin/calender/calender_index');
// })->name('calender_index');

// Route::get('calender_daily_create', function () {
//     return view('admin/calender/calender_daily_create');
// })->name('calender_daily_create');

// Route::get('calender_daily_edit', function () {
//     return view('admin/calender/calender_daily_edit');
// })->name('calender_daily_edit');

// Route::get('calender_weekend_create', function () {
//     return view('admin/calender/calender_weekend_create');
// })->name('calender_weekend_create');

// Route::get('calender_weekend_edit', function () {
//     return view('admin/calender/calender_weekend_edit');
// })->name('calender_weekend_edit');

// Route::get('calender_eventholiday_create', function () {
//     return view('admin/calender/calender_eventholiday_create');
// })->name('calender_eventholiday_create');

// Route::get('calender_eventholiday_edit', function () {
//     return view('admin/calender/calender_eventholiday_edit');
// })->name('calender_eventholiday_edit');

// Route::get('escalation_group_create', function () {
//     return view('admin/escalation-group/escalation_group_create');
// })->name('escalation_group_create');

// Route::get('escalation_group_index', function () {
//     return view('admin/escalation-group/escalation_group_index');
// })->name('escalation_group_index');

// Route::get('escalation_group_edit', function () {
//     return view('admin/escalation-group/escalation_group_edit');
// })->name('escalation_group_edit');

// Route::get('complaint_category_create', function () {
//     return view('admin/complaint-category/complaint_category_create');
// })->name('complaint_category_create');

// Route::get('complaint_category_edit', function () {
//     return view('admin/complaint-category/complaint_category_edit');
// })->name('complaint_category_edit');

// Route::get('complaint_category_index', function () {
//     return view('admin/complaint-category/complaint_category_index');
// })->name('complaint_category_index');


// Route::get('e_form_category_create', function () {
//     return view('admin/e-form-category/e_form_category_create');
// })->name('e_form_category_create');

// Route::get('e_form_category_edit', function () {
//     return view('admin/e-form-category/e_form_category_edit');
// })->name('e_form_category_edit');

// Route::get('e_form_category_index', function () {
//     return view('admin/e-form-category/e_form_category_index');
// })->name('e_form_category_index');

// Route::get('complaint_product_create', function () {
//     return view('admin/complaint-product/complaint_product_create');
// })->name('complaint_product_create');

// Route::get('complaint_product_edit', function () {
//     return view('admin/complaint-product/complaint_product_edit');
// })->name('complaint_product_edit');

// Route::get('complaint_product_index', function () {
//     return view('admin/complaint-product/complaint_product_index');
// })->name('complaint_product_index');

// Route::get('e_form_product_create', function () {
//     return view('admin/e-form-product/e_form_product_create');
// })->name('e_form_product_create');

// Route::get('e_form_product_edit', function () {
//     return view('admin/e-form-product/e_form_product_edit');
// })->name('e_form_product_edit');

// Route::get('e_form_product_index', function () {
//     return view('admin/e-form-product/e_form_product_index');
// })->name('e_form_product_index');


require __DIR__.'/auth.php';
