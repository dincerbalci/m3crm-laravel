<?php

namespace App\Http\Controllers;

use App\Models\EFormManagement;
use App\Models\EFormCategory;
use App\Models\EFormType;
use App\Models\EFormProduct;
use App\Models\Unit;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EFormManagementController extends Controller
{
    public  $objUser;
    public  $objEFormManagement;

    public function __construct()
  {
      $this->objUser = new User();
      $this->objEFormManagement = new EFormManagement();
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $priority=DB::table('tbl_priority')->where('is_active','1')->get();
        $status=DB::table('tbl_status')->where('isactive','1')->get();
        $product=EFormProduct::where('isactive','1')->get();
        $eForm=$this->objEFormManagement->getAllEForm($request);
        $loginId = Session::get('login_id');
        $userType = Session::get('user_type');
        return view('admin/e-form/e_form_index',compact('eForm','priority','status','product','userType','loginId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priority=DB::table('tbl_priority')->where('is_active','1')->get();
        $category=EFormCategory::where('isactive','1')->where('id','<>','1')->get();
        $unit=Unit::where('group_id','4')->get();
        return view('admin/e-form/e_form_create',compact('priority','category','unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $eFormNumber         = isset($request->e_form_number) ? $request->e_form_number : '';
        $groupId            = isset($request->group_id) ? $request->group_id : 0;
        $cnic                = isset($request->cnic) ? ($request->cnic) : '';
        $customerName           = isset($request->customer_name) ? ($request->customer_name) : '';
        $cust_rim            = isset($request->txtCustomerRim) ? ($request->txtCustomerRim) : '';
        $prod_code           = isset($request->txtProductCode) ? ($request->txtProductCode) : '';
        $prodCategory          = isset($request->product_category) ? $request->product_category : 0;
        $productId          = isset($request->product_id) ? $request->product_id : 0;
        $eFormType          = isset($request->e_form_type) ? $request->e_form_type : 0;
        $priority            = isset($request->priority) ? $request->priority : 0;
        $accountNumber          = isset($request->account_number) ? $request->account_number : '';
        $cardNumber             = isset($request->card_number)?$request->card_number: '';
        $cardType           = isset($request->card_type) ? $request->card_type : '';
        $leaves              = isset($request->leaves) ? $request->leaves : 0;
        $collectionMode     = isset($request->collection_mode) ? $request->collection_mode : '';
        $cardTitle          = isset($request->card_title) ? $request->card_title : '';
        $frequency           = isset($request->frequency) ? $request->frequency : '';
        $channel             = isset($request->channel) ? $request->channel : '';
        $poBox              = isset($request->po_box) ? $request->po_box : '';
        $officeAddress         = isset($request->office_address) ? ($request->office_address) : '';
        $residenceAddress      = isset($request->residence_address) ? ($request->residence_address) : '';
        $delieveryAddress      = isset($request->delievery_address) ? ($request->delievery_address) : '';
        $alternateAddress      = isset($request->alternate_address) ? ($request->alternate_address) : '';
        $residenceNumber       = isset($request->residence_number) ? $request->residence_number : '';
        $officeNumber          = isset($request->office_number) ? $request->office_number : '';
        $mobileNumber          = isset($request->mobile_number) ? $request->mobile_number : '';
        $email               = isset($request->email_address) ? $request->email_address : '';
        $company             = isset($request->company) ? ($request->company) : '';
        $department          = isset($request->department) ? ($request->department) : '';
        $emirate             = isset($request->emirate) ? ($request->emirate) : '';
        $isEmail            = isset($request->is_email) ? $request->is_email : 0;
        $customerEmail          = isset($request->customer_e_mail) ? $request->customer_e_mail : '';
        $isSms              = isset($request->is_sms) ? $request->is_sms : 0;
        $customerMobile         = isset($request->customer_mobile) ? $request->customer_mobile : '';
        $language            = isset($request->language) ? ($request->language) : '';
        $isCallBack        = isset($request->call_back) ? $request->call_back : 0;
        $fromDate           = isset($request->from_date) ? $request->from_date : '';
        $toDate             = isset($request->to_date) ? $request->to_date : '';
        $motherMaiden       = isset($request->mother_maiden_name) ? $request->mother_maiden_name : '';
        $dob                 = isset($request->dob) ? $request->dob : '';
        $dob=str_replace(","," ",$request->dob);
        $dob=date("Y-m-d",strtotime($dob));
        $transaction         = isset($request->transaction) ? $request->transaction : '';
        $amount              = isset($request->amount) ? $request->amount : '';
        $amountRemaining    = isset($request->amount_remaining) ? $request->amount_remaining : '';
        $customerBranchId     = isset($request->customer_branch_id)?$request->customer_branch_id: '';
        $description      = isset($request->notes)?($request->notes): '';

        if($fromDate != '' && $toDate != ''){
            $fromDate  = date('Y-m-d h:i:s', strtotime($fromDate));
            $toDate    = date('Y-m-d h:i:s', strtotime($toDate));
        }
		$dateTime = GetCurrentDateTime();
        $userType = Session::get('user_type');
        $agentId = Session::get('login_id');
        $eformUnitId = Session::get('unit_id');
        $eformUnitName = Session::get('unit_name');

        $endDateTime = $this->GetEndDate($prodCategory,$productId,$eFormType);
        $dataCounter = explode('|',$this->GenDailyCounter());
        if($channel == "2"){
            $customerNumber = $mobileNumber;
        }
        $path='';
        if ($request->hasFile('file')) {
            $destinationPath = base_path('public/uploads/eform/' . $agentId);
            $file = $request->file('file');
            $fileNameDb=$file->getClientOriginalName();
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $size = $file->getSize();
            $file->move($destinationPath, $filename);
            $path = "uploads/eform/" .$agentId . "/". $filename;
        }
        $data=EFormManagement::create([
            'daily_counter' => $dataCounter[1],
            'from_unit_id' => $eformUnitId,
            'agent_id' => $agentId,
            'is_approved'=>'1',
            'eform_num' => $dataCounter[0],
            'product_category' => $prodCategory,
            'product_id' => $productId,
            'eform_type_id' => $eFormType,
            'priority_id' => $priority,
            'status_id' => '1',
            'current_datetime' => $dateTime,
            'closed_datetime' => '',
            'end_datetime' => $endDateTime,
            'file_path'=>$path,
        ]);
        $details=DB::table('tbl_eform_details')->insert([
            'eform_id' => $data->id,
            'cnic' => $cnic,
            'customer_name' => $customerName,
            'mother_maiden' => $motherMaiden,
            'dob' => $dob,
            'customer_branch_id' => $customerBranchId,
            'description' => $description,
            'customer_rim' => $cust_rim,
            'account_no' => $accountNumber,
            'card_no' => $cardNumber,
            'card_type' => $cardType,
            'channel' => $channel,
            'pobox_no' => $poBox,
            'office_address' => $officeAddress,
            'residence_address' => $residenceAddress,
            'delievery_address' => $delieveryAddress,
            'alternate_address' => $alternateAddress,
            'residence_num' => $residenceNumber,
            'office_num' => $officeNumber,
            'mobile_num' => $mobileNumber,
            'email' => $email,
            'company_name' => $company,
            'department' => $department,
            'emirate' => $emirate,
            'is_email' => $isEmail,
            'customer_email' => $customerEmail,
            'is_sms' => $isSms,
            'customer_mobile_num' => $customerMobile,
            'language' => $language,
            'is_call_back' => $isCallBack,
            'no_of_leaves' => $leaves,
            'collection_mode' => $collectionMode,
            'frequency' => $frequency,
            'card_title' => $cardTitle,
            'transaction_name' => $transaction,
            'amount' => $amount,
            'amount_remaining' => $amountRemaining,
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
        $eFrom=EFormType::where('product_category_id',$prodCategory)->where('product_id',$productId)->where('id',$eFormType)->where('operation_mode','1')->get();
        if(count($eFrom) > 0)
        {
            $groupId=$eFrom[0]->group_id;
            $userGroup= DB::select(DB::raw("SELECT GROUP_CONCAT(user_id) AS user_id FROM tbl_users_group WHERE group_id = '$groupId'"));
            $usersId=$userGroup[0]->user_id;
            if($usersId != ''){
                $eFormManagement=EFormManagement::find($data->id);
                $eFormManagemen['group_id']=$groupId;
                $eFormManagemen['user_id']=$usersId;
                $eFormManagement->save();
            }
        }
        

        if($isSms == 1){
            SaveSMSCompEform('eform',$data->id,'10',$customerMobile);
        }
        if($userType == '3'){

            $emailUsers = $this->objUser->GetEmailByBranchUsers(44);
            SaveEmailCompEform('eform',$data->id,'8',$emailUsers[0]->emails);

            $this->ActivityAgentLogs('Add E-Form',$dataCounter[0]."|".$cnic,'E-Form');

            $this->SaveEFormStatus($agentId,$data->id,1,0,0,0,"E-Form Initiated By $eformUnitName");

        }
        else if($userType == '2'){

            $this->ActivityLogs("Add E-Form [CNIC:$cnic, Complaint #: $dataCounter[0]]");

            $emailUsers = $this->objUser->GetEmailByUserType(2);
            SaveEmailCompEform('eform',$data->id,'7',$emailUsers[0]->emails);

            $this->ActivityLogs("Add Eform [CNIC:$cnic, Eform #: $dataCounter[0]]");
            $this->SaveEFormStatus($agentId,$data->id,1,0,0,0,"E-Form Initiated By $eformUnitName");
        }
        else if ($userType == '4'){

            $emailUsers = $this->objUser->GetEmailAdcAndBranch($eformUnitId);
            SaveEmailCompEform('eform',$data->id,'7',$emailUsers[0]->emails);

            $this->ActivityLogs("Add Eform [CNIC:$cnic, Eform #: $dataCounter[0]]");
            $this->SaveEFormStatus($agentId,$data->id,1,0,0,0,"E-Form Initiated By $eformUnitName");

        }
       return $this->redirect();
    }
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EFormManagement  $eFormManagement
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        
        $disa           = "";
        $dis_button     = "";
        $disable_user='';
        $disabled       = "";
        $disable_info   = "";
        $email_checked  = "";
        $sms_checked    = "";
        $panel_title    = "";
        $display_button = "display: none";
        $bread_crumbs   = "";
        $call_back_checked          = "";
        $isactive    = "";
        $is_approved = "";
        $checkSupervisor = "0";
        $pageName = 'e_form_show';
        $permissionType = "update";
        $userType = Session::get('user_type');
        $data =$this->objEFormManagement->getEFormById($id);
        $activityData =$this->objEFormManagement->getEformActivity($id);
        $disable_info        = $data[0]->progress == 100 ? "disabled='disabled'" : "";
        $disabled            = $data[0]->eform_id != 0 ? "disabled='disabled'" : "";
        $disa                = $data[0]->progress == 100 ? "disabled='disabled'" : "";
        $button              = $data[0]->group_id == 0 ? "Forward" : "Submit";
        $email_checked       = $data[0]->is_email == 0 ? "checked='checked'" : "";
        $sms_checked         = $data[0]->is_sms == 0 ? "checked='checked'" : "";
        $call_back_checked   = $data[0]->is_call_back == 0 ? "checked='checked'" : "";
        $dis_button          = ($data[0]->status_id == 3 || $data[0]->status_id == 4) ? "disabled='disabled'" : "";
        $display_button      = ($data[0]->status_id == 3 && $userType == 2) ? "" : "display: none";
        // $is_subscription     = ($data[0]->subscription_date) == "" ? "display: none" : "";
        $comments_progress   = $userType == 2 ? $data[0]->comments_progress : '';
        $is_approved         = $data[0]->is_approved == 1 ? "checked='checked'" : "";
        $approval_dis        = $data[0]->is_approved == 1 ? "disabled='disabled'" : "";
        if($userType != '1')
        {
            $checkPermission = $this->objUser->GetPermissions($pageName,$permissionType,$userType);
            $JsonPermission = json_decode($checkPermission,true);
            $checkSupervisor = $JsonPermission[0][$permissionType];
        }
        if($checkSupervisor == "0" || $userType == "1"){
            $disable_info = "disabled='disabled'";
            $approval_dis = "disabled='disabled'";
            $disable_user = "disabled='disabled'";
            $dis_button = "disabled='disabled'";
        }

        $groupIdArr=array('4','5');
        $groupId=$data[0]->group_id;
        $group=DB::table('tbl_groups')->where('isactive','1')->whereIn('id',$groupIdArr)->get();
        $units=Unit::where('group_id',$groupId)->get();
        $source=DB::table('tbl_source')->get();
        $priority=DB::table('tbl_priority')->where('is_active','1')->get();
        $category=EFormCategory::where('isactive','1')->where('id','<>','1')->get();
        return view('admin/e-form/e_form_show',compact('data','activityData','group','priority','category','source','units','disable_info','disabled','disa',
        'button','email_checked','sms_checked','call_back_checked','dis_button','display_button','comments_progress','is_approved','approval_dis','disable_user'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EFormManagement  $eFormManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(EFormManagement $eFormManagement)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EFormManagement  $eFormManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $dateTime = GetCurrentDateTime();
        $groupId            = ($request->group_id != '')? $request->group_id: 0;
        $unitId             = ($request->unit_id  != '')? $request->unit_id:  0;
        $approved            = 1;
        $groupName          = $group=Group::find($groupId);
        $progress            = isset($request->progress)? $request->progress: '';
        $notes               = isset($request->activity_note)? $request->activity_note: '';
        $loginId = Session::get('login_id');
        $eFormManagement=EFormManagement::find($id);
        // $user_id             = ($request->user  != '')? $request->user:  0;
        // $source              = isset($request->source)? $request->source: '';
        // $unit_id = implode(",", $unit_id);
        // $user_id = implode(",", $user_id);
        // $user_id = implode(",", $user_id);
        // $query_part = "";
        if($approved == 1){

            if($progress == '100'){
                // source = '$source' cant find soyrce noman bhai sy puchnaa hai
                $statusId = '3';
                $eFormManagement['comments_progress']=$notes;
                $eFormManagement['progress']=$progress;
                $eFormManagement['status_id']=$statusId;
                $eFormManagement['group_id']=$groupId;
                $eFormManagement['unit_id']=$unitId;
                $eFormManagement['is_approved']=$approved;
                $eFormManagement['closed_datetime']=$dateTime;
                $eFormManagement->save();

                $dataFromUnitId=$eFormManagement['from_unit_id'];
                $dataUnitId=$eFormManagement['unit_id'];
                //43 is ufone branch unit
                if($dataFromUnitId == '43'){
                    $emailUsers = $this->objUser->GetEmailByBranchUsers($dataUnitId);
                    SaveEmailCompEform('eform',$id,'9',$emailUsers[0]->emails);
                }else{
                    $emailUsers = $this->objUser->GetEmailFromAndTo($dataFromUnitId, $dataUnitId);
                    SaveEmailCompEform('eform',$id,'9',$emailUsers[0]->emails);
                }
                $dataCheck = $this->CheckSMSEmail($id); //check customer allow sms or not
                $isSms = $dataCheck[0]->is_sms;
                $customerMobileNo = $dataCheck[0]->customer_mobile_no;

                if($isSms == 1){
                    SaveSMSCompEform('eform',$id,'12',$customerMobileNo);
                }
                $source='';
                $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes);

                $activityDescription = "Closed EForm [EForm #: $id, Closed Date: $dateTime]";
                $this->ActivityLogs($activityDescription);

            }
            elseif($progress == '101'){
                //source = '$source'
                $statusId = '5';
                $progress = '0';
                $eFormManagement['comments_progress']=$notes;
                $eFormManagement['progress']=$progress;
                $eFormManagement['status_id']=$statusId;
                $eFormManagement['is_approved']='1';
                $eFormManagement['group_id']='0';
                $eFormManagement['user_id']='0';
                $eFormManagement['unit_id']='0';
                $eFormManagement->save();
                $source='';
                $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes);

                $activityDescription = "Invalid EForm [EForm #: $id]";
                $this->ActivityLogs($activityDescription);
            }
            else{
                // $eFormManagement['user_id']=$user_id;
                $eFormManagement['status_id']='2';
                $eFormManagement['forward_datetime']=$dateTime;
                $eFormManagement['progress']=$progress;
                $eFormManagement['forward_by']=$loginId;
                $eFormManagement['group_id']=$groupId;
                $eFormManagement['unit_id']=$unitId;
                $eFormManagement['is_approved']='1';
                $eFormManagement->save();
                $emailUsers = $this->objUser->GetEmailAdcAndBranch($unitId);
                SaveEmailCompEform('eform',$id,'8',$emailUsers[0]->emails);

                $dataCheck = $this->CheckSMSEmail($id); //check customer allow sms or not
                $isSms = $dataCheck[0]->is_sms;
                $customerMobileNo = $dataCheck[0]->customer_mobile_no;

                if($isSms == 1){
                    SaveSMSCompEform('eform',$id,'11',$customerMobileNo);
                }

                $toUnits = $this->objUser->GetOrganizationUnitById($unitId);
                $unitName=$toUnits[0]->unit_name;

                $this->ActivityLogs("Forward EForm [To Group: ($groupName), To Branch: ($unitName), Approved: $approved, EForm #: $id]");
                $this->SaveEFormStatus($loginId,$id,2,$unitId,0,0,$notes);
                $this->SaveEFormStatus($loginId,$id,2,$unitId,0,0,"E-Form Forwarded To $unitName");
            }

        }
        return $this->redirect();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EFormManagement  $eFormManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(EFormManagement $eFormManagement)
    {
        //
    }
    public function eFormType(Request $request)
    {
        $productId=$request->product_id;
        return EFormType::where('product_id',$productId)->where('isactive','1')->get();
    }
    public function getEndDate($prodCateg,$productId,$eFormType){
        $data= DB::select(DB::raw("SELECT tat FROM tbl_eform_type WHERE id = '$eFormType' AND product_category_id = '$prodCateg' AND product_id = '$productId' AND isactive = 1"));
         $tat   = $data[0]->tat;
         $tat = ($tat/24);	//convert hours into number of days
         $currentDate = GetCurrentDate();
         return $this->GetWorkingDays($currentDate,$tat);
    }
    public function GetWorkingDays($startDate,$wDays) {

        $wDays2 = ($wDays*2);
        $newDate = date('Y-m-d', strtotime("{$startDate} +{$wDays} weekdays"));
        $checkFrame = date('Y-m-d', strtotime("{$startDate} +{$wDays2} weekdays"));
        $holidays = GetHolidaysCalendar();
        foreach ($holidays as $holiday) {

            $holidayTs = strtotime($holiday['holidays']);

            // if holiday falls between start date and new date, then account for it
            if ($holidayTs >= strtotime($startDate) && $holidayTs <= strtotime($checkFrame)) {

                // check if the holiday falls on a working day
                $h = date('w', $holidayTs);
                if ($h != 0 && $h != 6 ) {
                    // holiday falls on a working day, add an extra working day
                    $newDate = date('Y-m-d', strtotime("{$newDate} + 1 weekdays"));
                }
            }
        }

        return $newDate;
    }
    public function GenDailyCounter()
    {
        $firstDigit = "EF";
        $today = date("Y-m-d");
        $datePart = date("ymd");
        $row= DB::select(DB::raw("SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_eform_add` WHERE DATE(current_datetime) = '$today'")); 
        $secondDigit = sprintf('%03d', (int)$row[0]->daily_counter);
        $nextCounter = $firstDigit.$datePart.$secondDigit;
        return $nextCounter."|".$row[0]->daily_counter;
    }
    public function SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes)
    {
        DB::table('tbl_eform_status')->insert([
                'login_id'=>$loginId,
                'eform_id'=>$id,
                'current_state'=>$statusId,
                'assign_to'=>$unitId,
                'source'=>$source,
                'progress'=>$progress,
                'comments'=>$notes,
        ]);
    }
    public function CheckSMSEmail($id)
    {
        return DB::select(DB::raw("SELECT is_sms,is_email,customer_mobile_num customer_mobile_no FROM tbl_eform_details WHERE eform_id = '$id'")); 
    }
    public function updateProgress(Request $request , int $id)
    {
        $dateTime = GetCurrentDateTime();
        $activityDescription = "";
        $groupId            = ($request->group_id != '')? $request->group_id: 0;
        $unitId             = ($request->unit_id  != '')? $request->unit_id:  0;
        $approved            = 1;
        $groupName          = $group=Group::find($groupId);
        $progress            = isset($request->progress)? $request->progress: '';
        $notes               = isset($request->activity_note)? $request->activity_note: '';
        $loginId = Session::get('login_id');
        $eFormManagement=EFormManagement::find($id);

        $saveGroupId    = $eFormManagement['group_id'];
        $saveUnitId     = $eFormManagement['unit_id'];
        $approved       = 1;

        if($progress == '100'){

            $statusId = '3';
            $eFormManagement['closed_datetime']=$dateTime;
            $activityDescription = "Closed EForm [EForm #: $id, Closed Date: $dateTime]";
            $this->ActivityLogs($activityDescription);

            $emailUsers = $this->objUser->GetEmailCMUAndBranch($unitId);
            SaveEmailCompEform('eform',$id,'9',$emailUsers[0]->emails);

            $dataCheck = $this->CheckSMSEmail($id); //check customer allow sms or not
            $isSms = $dataCheck[0]->is_sms;
            $customerMobileNo = $dataCheck[0]->customer_mobile_no;

            if($isSms == 1){
                SaveSMSCompEform('eform',$id,'12',$customerMobileNo);
            }
            $source='';
            $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes);

        }
        elseif($progress == '101'){

            $statusId = '5';
            $progress = '0';
            $eFormManagement['group_id']=0;
            $eFormManagement['user_id']=0;
            $eFormManagement['unit_id']=0;
            $source='';
            $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes);

            $activityDescription = "Invalid EForm [EForm #: $id]";
            $this->ActivityLogs($activityDescription);
        }
        else{

            $statusId = '2';
            $activityDescription = "In Progress EForm [EForm #: $id, Progress: $progress%]";
            
            if($saveUnitId == $unitId){
                $source='';
                $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes);
                $this->ActivityLogs($activityDescription);
            }
            else{

                $fromUnits = $this->objUser->GetOrganizationUnitById($saveUnitId); //unit_name
                $toUnits = $this->objUser->GetOrganizationUnitById($unitId);
                $fromUnits=$fromUnits[0]->unit_name;
                $toUnits=$toUnits[0]->unit_name;
                $source='';
                $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$notes);
                $extraNotes = "EForm Forward from $fromUnits to $toUnits";
                $this->SaveEFormStatus($loginId,$id,$statusId,$unitId,$source,$progress,$extraNotes);
                $activityDescription = $extraNotes . " [EForm #: $id]";
                $this->ActivityLogs($activityDescription);
            }
        }
        $eFormManagement['progress']=$progress;
        $eFormManagement['comments_progress']=$notes;
        $eFormManagement['status_id']=$statusId;
        $eFormManagement['group_id']=$groupId;
        $eFormManagement['unit_id']=$unitId;
        $eFormManagement['is_approved']=1;
        $eFormManagement->save();

       return $this->redirect();

    }
    private function redirect()
    {
        return redirect()->route('e_form_index');

    }
}
