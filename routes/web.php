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
use App\Http\Controllers\SideBarController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeadManagementController;
use App\Http\Controllers\LeadNoteController;
use App\Http\Controllers\LeadFileController;
use App\Http\Controllers\LeadFollowUpController;

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


Route::get('permission_error', function () {
    return view('error-page/permission_error');
})->middleware(['auth'])->name('permission_error');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    #region Customer Search
    Route::get('customer_search', function () {
        return view('admin/customer-search/customer_search');
    })->name('customer_search');
    Route::get('customer_info', function () {
        return view('admin/customer-search/customer_info');
    })->name('customer_info');
    Route::get('debit_card_info', function () {
        return view('admin/customer-search/debit_card_info');
    })->name('debit_card_info');
    #endregion Customer Search
    });

    
Route::middleware(['auth'])->group(function () {

#region complaint category
Route::get('complaint_category_create', [ComplaintCategoryController::class, 'create'])->middleware(['permission'])->name('complaint_category_create');
Route::get('complaint_category_index', [ComplaintCategoryController::class, 'index'])->middleware(['permission'])->name('complaint_category_index');
Route::get('complaint_category_edit/{id}', [ComplaintCategoryController::class, 'edit'])->middleware(['permission'])->name('complaint_category_edit');
Route::post('complaint_category_create', [ComplaintCategoryController::class, 'store'])->name('complaint_category_create');
Route::post('complaint_category_edit/{id}', [ComplaintCategoryController::class, 'update'])->name('complaint_category_edit');
#endregion complaint category

#region complaint product
Route::get('complaint_product_create', [ComplaintProductController::class, 'create'])->middleware(['permission'])->name('complaint_product_create');
Route::get('complaint_product_index', [ComplaintProductController::class, 'index'])->middleware(['permission'])->name('complaint_product_index');
Route::get('complaint_product_edit/{id}', [ComplaintProductController::class, 'edit'])->middleware(['permission'])->name('complaint_product_edit');
Route::post('complaint_product_create', [ComplaintProductController::class, 'store'])->name('complaint_product_create');
Route::post('complaint_product_edit/{id}', [ComplaintProductController::class, 'update'])->name('complaint_product_edit');
#endregion complaint product

#region e form category
Route::get('e_form_category_create', [EFormCategoryController::class, 'create'])->middleware(['permission'])->name('e_form_category_create');
Route::get('e_form_category_index', [EFormCategoryController::class, 'index'])->middleware(['permission'])->name('e_form_category_index');
Route::get('e_form_category_edit/{id}', [EFormCategoryController::class, 'edit'])->middleware(['permission'])->name('e_form_category_edit');
Route::post('e_form_category_create', [EFormCategoryController::class, 'store'])->name('e_form_category_create');
Route::post('e_form_category_edit/{id}', [EFormCategoryController::class, 'update'])->name('e_form_category_edit');
#endregion e form category

#region e form product
Route::get('e_form_product_create', [EFormProductController::class, 'create'])->middleware(['permission'])->name('e_form_product_create');
Route::get('e_form_product_index', [EFormProductController::class, 'index'])->middleware(['permission'])->name('e_form_product_index');
Route::get('e_form_product_edit/{id}', [EFormProductController::class, 'edit'])->middleware(['permission'])->name('e_form_product_edit');
Route::post('e_form_product_create', [EFormProductController::class, 'store'])->name('e_form_product_create');
Route::post('e_form_product_edit/{id}', [EFormProductController::class, 'update'])->name('e_form_product_edit');
#endregion e form product

#region Complaint type
Route::get('complaint_type_create', [ComplaintTypeController::class, 'create'])->middleware(['permission'])->name('complaint_type_create');
Route::get('complaint_type_index', [ComplaintTypeController::class, 'index'])->middleware(['permission'])->name('complaint_type_index');
Route::get('complaint_type_edit/{id}', [ComplaintTypeController::class, 'edit'])->middleware(['permission'])->name('complaint_type_edit');
Route::post('complaint_type_create', [ComplaintTypeController::class, 'store'])->name('complaint_type_create');
Route::post('complaint_type_edit/{id}', [ComplaintTypeController::class, 'update'])->name('complaint_type_edit');
#endregion Complaint type

#region Complaint management
Route::get('complaint_create', [ComplaintManagementController::class, 'create'])->middleware(['permission'])->name('complaint_create');
Route::get('complaint_index', [ComplaintManagementController::class, 'index'])->middleware(['permission'])->name('complaint_index');
Route::get('complaint_show/{id}', [ComplaintManagementController::class, 'show'])->middleware(['permission'])->name('complaint_show');
Route::get('get_product_category', [ComplaintManagementController::class, 'productCategory'])->name('get_product_category');
Route::get('get_complaint_type', [ComplaintManagementController::class, 'complaintType'])->name('get_complaint_type');
Route::post('complaint_create', [ComplaintManagementController::class, 'store'])->name('complaint_create');
Route::get('get_unit_groups', [ComplaintManagementController::class, 'unitGroup'])->name('get_unit_groups');
Route::post('complaint_edit/{id}', [ComplaintManagementController::class, 'update'])->name('complaint_edit');
Route::post('update_progress/{id}', [ComplaintManagementController::class, 'updateProgress'])->name('update_progress');
Route::get('get_cnic_complain_api', [ComplaintManagementController::class, 'cnicApi'])->name('get_cnic_complain_api');
#endregion Complaint management

#region E Form type
Route::resource('e_form_type', EFormTypeController::class)->middleware(['permission']);
#endregion E Form type

#region Escalation Group
Route::resource('escalation_group', EscalationGroupController::class)->middleware(['permission']);
#endregion Escalation Group

#region Daily Calendar
Route::resource('daily_calendar', DailyCalendarController::class)->middleware(['permission']);
#endregion Daily Calendar

#region Week End
Route::resource('week_end', WeekendsCalendarController::class)->middleware(['permission']);
#endregion Week End

#region Week End
Route::resource('holidays', HolidaysCalendarController::class)->middleware(['permission']);
#endregion Week End

#region Template
Route::resource('template', TemplateController::class)->middleware(['permission']);
#endregion Template

#region Unit
Route::resource('unit', UnitController::class)->middleware(['permission']);
#endregion Unit

#region Group
Route::resource('group', GroupController::class)->middleware(['permission']);
#endregion Group

#region User
Route::resource('user', UserController::class)->middleware(['permission']);
Route::get('user_status/{id}', [UserController::class, 'status'])->name('user_status');
Route::get('get_all_regions', [UserController::class, 'GetAllRegion'])->name('get_all_regions');
Route::get('get_unit_regions', [UserController::class, 'GetUnitRegion'])->name('get_unit_regions');
#endregion User

#region Role
Route::resource('role', RoleController::class)->middleware(['permission']);
#endregion Role

#region E From management
Route::get('e_form_create', [EFormManagementController::class, 'create'])->middleware(['permission'])->name('e_form_create');
Route::get('e_form_index', [EFormManagementController::class, 'index'])->middleware(['permission'])->name('e_form_index');
Route::get('e_form_show/{id}', [EFormManagementController::class, 'show'])->middleware(['permission'])->name('e_form_show');
Route::post('e_form_store', [EFormManagementController::class, 'store'])->name('e_form_store');
Route::get('get_e_form_type', [EFormManagementController::class, 'eFormType'])->name('get_e_form_type');
Route::post('e_form_edit/{id}', [EFormManagementController::class, 'update'])->name('e_form_edit');
Route::post('e_form_update_progress/{id}', [EFormManagementController::class, 'updateProgress'])->name('e_form_update_progress');
Route::get('get_cnic_api', [EFormManagementController::class, 'cnicApi'])->name('get_cnic_api');
#endregion E From management

#region Announcement management
Route::get('announcement_create', [AnnouncementController::class, 'create'])->middleware(['permission'])->name('announcement_create');
Route::get('announcement_index', [AnnouncementController::class, 'index'])->middleware(['permission'])->name('announcement_index');
Route::get('announcement_edit/{id}', [AnnouncementController::class, 'edit'])->middleware(['permission'])->name('announcement_edit');
Route::post('announcement_submit', [AnnouncementController::class, 'store'])->name('announcement_submit');
Route::get('delete_annoucement', [AnnouncementController::class, 'destroyShow'])->name('delete_annoucement');
Route::post('announcement_delete/{id}', [AnnouncementController::class, 'destroy'])->name('announcement_delete');
Route::post('announcement_update/{id}', [AnnouncementController::class, 'update'])->name('announcement_update');
#endregion Announcement management
#region Reports
Route::get('report_agent_activity_logs', [ReportController::class, 'agentActivity'])->name('report_agent_activity_logs');
Route::get('report_session_history_logs', [ReportController::class, 'sessionHistory'])->name('report_session_history_logs');
Route::get('report_transaction_logs', [ReportController::class, 'transaction'])->name('report_transaction_logs');
Route::get('report_complaints', [ReportController::class, 'complaints'])->name('report_complaints');
Route::get('report_escalation', [ReportController::class, 'escalation'])->name('report_escalation');
Route::get('report_complaint_tat', [ReportController::class, 'complaintTat'])->name('report_complaint_tat');
Route::get('report_complaint_status', [ReportController::class, 'complaintStatus'])->name('report_complaint_status');
Route::get('report_sms_interim', [ReportController::class, 'smsInterim'])->name('report_sms_interim');
Route::get('report_send_emails', [ReportController::class, 'sendEmails'])->name('report_send_emails');
Route::get('report_eforms', [ReportController::class, 'eForm'])->name('report_eforms');
Route::get('report_sms_details', [ReportController::class, 'smsDetails'])->name('report_sms_details');
#endregion Reports

Route::get('get_product_category_eform', [EFormTypeController::class, 'productCategory'])->name('get_product_category_eform');
// ->middleware(['permission'])
Route::resource('lead', LeadManagementController::class);
Route::get('lead_user', [LeadManagementController::class, 'leadUser'])->name('lead_user');
Route::get('lead_delete', [LeadManagementController::class, 'leadDelete'])->name('lead_delete');

Route::resource('lead_note', LeadNoteController::class);
Route::get('lead_note_delete', [LeadNoteController::class, 'leadNoteDelete'])->name('lead_note_delete');

Route::resource('lead_file', LeadFileController::class);
Route::get('lead_file_delete', [LeadFileController::class, 'leadFileDelete'])->name('lead_file_delete');

Route::resource('lead_follow_up', LeadFollowUpController::class);
Route::get('lead_follow_up_delete', [LeadFollowUpController::class, 'leadFollowUpDelete'])->name('lead_follow_up_delete');
Route::get('chat', [TemplateController::class, 'chat'])->name('chat');


});


Route::get('search', function () {
    // return view('admin/lead/lead_index');
})->name('search');
Route::get('crm_force_logout', function () {
    // return view('admin/lead/lead_index');
})->name('crm_force_logout');
Route::get('crm_account_unlock', function () {
    // return view('admin/lead/lead_index');
})->name('crm_account_unlock');

Route::get('side_bar_view', [SideBarController::class, 'index'])->name('side_bar_view');



require __DIR__.'/auth.php';
