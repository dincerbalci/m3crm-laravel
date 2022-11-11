<?php

namespace App\Http\Controllers;

use App\Models\ComplaintManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\ComplaintCategory;
use App\Models\User;
use App\Models\ComplaintProduct;
use App\Models\ComplaintType;
use Illuminate\Support\Facades\Date;


class ComplaintManagementController extends Controller
{

      public  $objComplaintManagement;
      public  $objUser;

      public function __construct()
    {
        $this->objComplaintManagement = new ComplaintManagement();
        $this->objUser = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complaint=$this->objComplaintManagement->getComplaint($request);
        $priority=DB::table('tbl_priority')->where('is_active','1')->get();
        $complaintStatus=DB::table('tbl_status')->where('isactive','1')->get();
        $product=DB::table('tbl_product')->where('isactive','1')->whereDate('end_date','>=','2020-10-07')->get();

        return view('admin/complaint/complaint_index',compact('complaint','priority','complaintStatus','product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $complaintCategory=ComplaintCategory::where('isactive','1')->whereNull('end_date')->orderBy('fullname')->get();
        $complaintCategory=ComplaintCategory::where('isactive','1')->orderBy('fullname')->get();
        $priority=DB::table('tbl_priority')->where('is_active','1')->get();
        $branch=DB::table('tbl_org_unit')->where('group_id','4')->get();
        $channel=DB::table('tbl_channel')->get();
        $source=DB::table('tbl_source')->where('id','>','4')->get();
        $language=DB::table('tbl_language')->get();

        return view('admin/complaint/complaint_create',compact('complaintCategory','priority','branch','channel','source','language'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'complaint_lodge_by' => ['required'],
            'complaint_title' => ['required'],
            'cnic' => ['required'],
            'product_category' => ['required'],
            'product' => ['required'],
            'complaint_type' => ['required'],
            'card_number' => ['required'],
            'complaint_nature' => ['required'],
            'customer_branch' => ['required'],
            'complaint_against_branch' => ['required'],
            'source' => ['required'],
            'note' => ['required'],
            'language' => ['required'],
            'call_back_phone' => ['required'],
            'residence_address' => ['required'],
        ]);
        $productCateg=$request->product_category;
        $productId=$request->product;
        $cnic=$request->cnic;
        $complaintType=$request->complaint_type;
        $channel=$request->channel;
        $callbackNum=$request->call_back_phone;
        $userType = Session::get('user_type');

        $getDuplicate = $this->objComplaintManagement->GetDuplicateComplaint($cnic,$productCateg,$productId,$complaintType);
        // dd(count($getDuplicate));
        // return count($getDuplicate);
        if(count($getDuplicate) == 0){
           $this->insertToComplaintAndDetails($request);
           return 'insert';
        }else{

            return view('admin/complaint/complaint_duplicate',compact('getDuplicate','userType'));
            // $sb='';
            // foreach($getDuplicate as $row){

            //     $status = "";
            //     $check_over = $this->CheckOverDue($row["end_date"]);

            //     if($row["status_id"] == '1'){

            //         $status = strtoupper($row["complaint_status"]);
            //         if($check_over == 1){
            //             $label = "danger";
            //         }else
            //             $label = "info";

            //     }
            //     else if($row["status_id"] == '2'){
            //         //only in progress status check for overdue
            //         if($check_over == 1){
            //             $status = "OVERDUE";
            //             $label = "danger";
            //         }else{
            //             if(($userType != 1 || $userType != 3) && $row["progress"] != 0)
            //                 $status = "IN PROGRESS";
            //             else
            //                 $status = "FORWARD";

            //             $label = "info";
            //         }

            //     }


            //     $sb .= "<tr>
			// 				<td>".$row["complaint_num"]."</td>
			// 				<td>".$row["compl_title"]."</td>
			// 				<td>".$row["cnic"]."</td>
			// 				<td>".$row["progress"]."%</td>
			// 				<td>".$row["priority"]."</td>
			// 				<td> <span class='label label-".$label."'>".$status."</span> </td>
			// 				<td>".$row["create_date"]."</td>
			// 				<td>".$row["end_date"]."</td>
			// 			</tr>";
            // }

            // echo "duplicate|$sb";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComplaintManagement  $complaintManagement
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $userType = Session::get('user_type');
        $unitId = Session::get('unit_id');
        $roleId = Session::get('role_id');
        $isOnlyCmuAllow=env('IS_ONLY_CMU_ALLOW');
        $disa       = "";
        $dis_button = "";
        $disabled = "";
        $disable_info = "";
        $display_button = "display: none";
        $isactive     = "";
        $is_approved  = "";
        $bread_crumbs = "";
        $panel_title  = "";
        $disable_user='';
        $is_favor = "none";
        $pageName = 'complaint_show';
        $permissionType = "update";
        $checkSupervisor='';
        if($userType != '1')
        {
            $checkPermission = $this->objUser->GetPermissions($pageName,$permissionType,$userType);
            $JsonPermission = json_decode($checkPermission,true);
            $checkSupervisor = $JsonPermission[0][$permissionType];
        }


        $complaint=$this->objComplaintManagement->ComplaintShow($id);
        $activityData=$this->objComplaintManagement->GetComplaintStatus($id);
        $smsDetails=$this->objComplaintManagement->GetSaveSMSByComplaint($id);
        $escalationDetails=$this->objComplaintManagement->GetSaveEscalationByComplaint($id);
        $complaintCategory=ComplaintCategory::where('isactive','1')->orderBy('fullname')->get();
        $priority=DB::table('tbl_priority')->where('is_active','1')->get();
        $groupId=$complaint[0]->group_id;
        $units=DB::table('tbl_org_unit')->where('group_id',$groupId)->get();
        $favor=DB::table('tbl_favor')->get();
        $branch=DB::table('tbl_org_unit')->get();
        $channel=DB::table('tbl_channel')->get();
        $source=DB::table('tbl_source')->get();
        $groupIdArr=array('4','5');
        $group=DB::table('tbl_groups')->where('isactive','1')->whereIn('id',$groupIdArr)->get();
        $language=DB::table('tbl_language')->get();

        $disable_info        = $complaint[0]->progress == 100 ? "disabled='disabled'" : "";
        $disabled            = $complaint[0]->complaint_id != 0 ? "disabled='disabled'" : "";
        $button              = ($userType == 2 && $complaint[0]->progress == 0) ? "Forward" : "Submit";
        $email_checked       = $complaint[0]->is_email == 0 ? "checked='checked" : "";
        $sms_checked         = $complaint[0]->is_sms == 0 ? "checked='checked'" : "";
        $call_back_checked   = $complaint[0]->is_call_back == 0 ? "checked='checked'" : "";
        $dis_button          = (($complaint[0]->status_id == 3 || $complaint[0]->status_id == 4 || $complaint[0]->group_id == 0) && $userType != 2) ? "disabled='disabled'" : "";
        $display_button      = ($complaint[0]->status_id == 3 && $userType == 2) ? "" : "display: none";
        $comments_progress   = $userType == 2 ? $complaint[0]->comments_progress : '';
        $is_approved         = $complaint[0]->is_approved == 1 ? "checked='checked'" : "";
        $approval_dis        = $complaint[0]->is_approved == 1 ? "disabled='disabled'" : "";
        $disabled_types = ( ($userType != 2) || ($complaint[0]->progress != 0 || $complaint[0]->unit_id != 0) ) ? "disabled='disabled'" : "";

        if($isOnlyCmuAllow == "1"){    //only cmu allow to forward complaints to branches

            // check cmu for forward complaints
            if($userType != 2){
                // $disable_info = "disabled='disabled'";
                $disable_info = "readonly";
                $approval_dis = "disabled='disabled'";
                //$disable_user = "disabled='disabled'";
            }

			//$data[0]["progress"] == 0 ||
            // check branch authorizer user for update progress complaints
            if(($checkSupervisor == "0" || $complaint[0]->progress == 0 || $complaint[0]->progress == 100) && $userType != 2){
                $disable_user = "disabled='disabled'";
            }

            if($userType != 2){
                if(($complaint[0]->from_unit_id <> $complaint[0]->unit_id) && ($complaint[0]->unit_id <> $unitId)){
                    $disable_user = "disabled='disabled'";

                }else{
                    $disable_user = "";
                }

            }


            if($complaint[0]->progress == 100 || ($complaint[0]->progress == 90 && $userType != 2)){
                $disable_user = "disabled='disabled'";
                $dis_button = "disabled='disabled'";

            }

        }
        else{   //all branches and cmu allow to forward complaints to branches

            if($checkSupervisor == "0" || $userType == "1"){
                // $disable_info = "disabled='disabled'";
                $disable_info = "readonly";
                $approval_dis = "disabled='disabled'";
                $disable_user = "disabled='disabled'";

            }

            if($complaint[0]->progress == 100){
                $disable_user = "disabled='disabled'";

            }

        }

		if($roleId == 2){	//For Complaint Handling Departs (Creator)
			// $disable_info = "disabled='disabled'";
            $disable_info = "readonly";
			$disable_user = "disabled='disabled'";
			$dis_button = "disabled='disabled'";

		}

		//for complaint closed and mark for bank and customer favor
        if($complaint[0]->progress >= "90" || $userType == "2"){
            $is_favor = "block";
        }

        return view('admin/complaint/complaint_show',compact('complaint','activityData',
        'smsDetails','escalationDetails','complaintCategory',
        'priority','branch','channel','source','language',
        'group','units','dis_button','button','disabled','disable_info','disabled_types','disable_user','userType','favor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComplaintManagement  $complaintManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplaintManagement $complaintManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComplaintManagement  $complaintManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_category' => ['required'],
            'product' => ['required'],
            'complaint_type' => ['required'],
            'customer_branch' => ['required'],
            'unit_id' => ['required'],
            'source' => ['required'],
            'activity_note' => ['required'],
            'group_id' => ['required'],
        ]);

        $datetime = GetCurrentDateTime();
        $complaint=ComplaintManagement::find($id);
        $loginId = Session::get('login_id');
        $progress=$request->progress;
        $categoryId=$request->product_category;
        $productId=$request->product;
        $complaintTypeId=$request->complaint_type;
        $customerBranchId=$request->customer_branch;
        $unitId=$request->unit_id;
        $source=$request->source;
        $notes=$request->activity_note;
        $groupId=$request->group_id;
        $amount=$request->amount;
        $group=DB::table('tbl_groups')->where('id',$groupId)->get();
        $groupName=$group[0]->group_name;

        $previousStatusId =$complaint['status_id']; // $this->GetComplaintPreviousStatus($id);
        $saveCategoryId=$complaint['product_category'];
        $complaintNo=$complaint['complaint_num'];
        $saveProductId=$complaint['product_id'];
        $saveTypeId=$complaint['complaint_type_id'];
        $saveCustomerBranchId=$complaint['customer_branch_id'];
        if($progress == '90'){
            $statusId = '4';
            $complaint['comments_progress']=$notes;//0
            $complaint['progress']=$progress;//0
            $complaint['status_id']=$statusId;//0
            $complaint['group_id']=$groupId;
            $complaint['unit_id']=$unitId;
            $complaint['is_approved']='1';
            $complaint->save();

            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,'0',$unitId,$source,$progress,$notes);

            $activityDescription = "Resolved Complaint [Complaint #: $complaintNo, Resolved Date: $datetime]";
            $this->ActivityLogs($activityDescription);

            $emailUsers = $this->objUser->GetEmailByBranchUsers(2);
            SaveEmailCompEform('complaint',$id,'17',$emailUsers[0]->emails);

        }
        elseif($progress == '100'){
            $statusId = '3';
            $complaint['comments_progress']=$notes;//0
            $complaint['progress']=$progress;//0
            $complaint['status_id']=$statusId;//0
            $complaint['group_id']=$groupId;
            $complaint['unit_id']=$unitId;
            $complaint['is_approved']='1';
            $complaint['close_date']=$datetime;
            $complaint->save();

            $emailUsers = $this->objUser->GetEmailCMUAndBranch($unitId);
            SaveEmailCompEform('complaint',$id,'3',$emailUsers[0]->emails);

            $this->SendSMSEmailCustomer($id,'complaint_closed');

            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,'0',$unitId,$source,$progress,$notes);

            $activity_description = "Closed Complaint [Complaint #: $complaintNo, Closed Date: $datetime]";
            $this->ActivityLogs($activity_description);

        }
        elseif($progress == '101'){
            $statusId = '5';
            $progress = '0';
            $complaint['comments_progress']=$notes;//0
            $complaint['progress']=$progress;//0
            $complaint['status_id']=$statusId;//0
            $complaint['group_id']='0';
            $complaint['user_id']='0';
            $complaint['unit_id']='0';
            $complaint['is_approved']='1';
            $complaint['close_date']=$datetime;
            $complaint->save();

            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,'0',$unitId,$source,$progress,$notes);

            $activity_description = "Invalid Complaint [Complaint #: $complaintNo]";
            $this->ActivityLogs($activity_description);

        }
        else{

            if($saveCategoryId <> $categoryId){
                $complaint['product_category']=$categoryId;
                $this->ActivityLogs("Complaint Category Changed [Complaint #: ($complaintNo), From Category: ($saveCategoryId), To Category: ($categoryId)]");
            }

            if($saveProductId <> $productId){
                $complaint['product_id']=$productId;
                $this->ActivityLogs("Complaint Product Changed [Complaint #: ($complaintNo), From Product: ($saveProductId), To Product: ($productId)]");
            }

            if($saveTypeId <> $complaintTypeId){
                $complaint['complaint_type_id']=$complaintTypeId;
                $this->ActivityLogs("Complaint Type Changed [Complaint #: ($complaintNo), From Type: ($saveTypeId), To Type: ($complaintTypeId)]");
            }

            if($saveCustomerBranchId <> $customerBranchId){
                DB::table('tbl_complaint_details')->where('complaint_id', $id)->update(['customer_branch_id' => $customerBranchId]);
                $this->ActivityLogs("Complaint Customer Branch Changed [Complaint #: ($complaintNo), From Branch Id: ($saveCustomerBranchId), To Branch Id: ($customerBranchId)]");
            }

            $complaint['status_id']='2';
            $complaint['forward_date']=$datetime;//0
            $complaint['progress']=$progress;//0
            $complaint['forward_by']=$loginId;
            $complaint['group_id']=$groupId;
            $complaint['unit_id']=$unitId;
            $complaint['user_id']='0';
            $complaint['is_approved']='1';
            $complaint['amount']=$amount;
            $complaint->save();

            $emailUsers = $this->objUser->GetEmailByBranchUsers($unitId);
            SaveEmailCompEform('complaint',$id,'2',$emailUsers[0]->emails);

            if($progress == 0){
                $this->objComplaintManagement->SetEmailEscalation($id,$unitId);
            }

            $toUnits = $this->objUser->GetOrganizationUnitById($unitId);
            $toUnits = $toUnits[0]->unit_name;
            $this->ActivityLogs("Forward Complaint [To Group: ($groupName), To Branch: ($toUnits), Approved: 1, Complaint #: $complaintNo]");
            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,2,'',$unitId,0,0,"Complaint Forwarded To $toUnits");

            return $this->redirect();


        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComplaintManagement  $complaintManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplaintManagement $complaintManagement)
    {
        //
    }
    public  function productCategory(Request $request)
    {
        $productCategoryId=$request->product_category_id;
        $endDate=$request->end_date;
        /*if($endDate == 'not null')
        {
            $complaintProduct=ComplaintProduct::where('product_category',$productCategoryId)->where('isactive','1')->get();
        }
        else
        {
            $complaintProduct=ComplaintProduct::where('product_category',$productCategoryId)->where('isactive','1')->whereNull('end_date')->get();
        }*/

        $complaintProduct = ComplaintProduct::where('product_category',$productCategoryId)->where('isactive','1')->get();

        return $complaintProduct;
    }
    public function complaintType(Request $request)
    {
        $productId=$request->product_id;
        $endDate=$request->end_date;
        /*if($endDate == 'not null')
        {
        $complaintType=ComplaintType::where('product_id',$productId)->where('isactive','1')->get();
        }
        else
        {
        $complaintType=ComplaintType::where('product_id',$productId)->where('isactive','1')->whereNull('end_date')->get();
        }*/

        $complaintType=ComplaintType::where('product_id',$productId)->where('isactive','1')->get();

        return $complaintType;

    }
    private function getEndDate($productCateg,$productId,$complaintType,$start_date='')
    {
		//AND isactive = 1
        $complaintType=ComplaintType::where('id',$complaintType)->where('product_category_id',$productCateg)
        ->where('product_id',$productId)->get();

        $tat = $complaintType[0]->tat;
		$tat = !empty($tat) ? $tat : "7";

		if($start_date != ''){
            $current_date = $start_date;
        }else{
            $current_date = GetCurrentDate();
        }

        return $this->GetWorkingDays($current_date,$tat);
    }
    public function GetWorkingDays($startDate, $wDays)
    {

        if($startDate < '2022-04-16' || $startDate > '2022-05-07'){  //when Saturday Off
            //echo "sat off";die;
            $new_date = $this->GetWorkingDaysBeforeSaturdayOff($startDate, $wDays);
            return $new_date;

        }else{ //when Saturday On
            //echo "sat on";die;
            $wDays2 = ($wDays * 2);
            // using + weekdays excludes weekends
            // $new_date = date('Y-m-d', strtotime("{$startDate} +{$wDays} weekdays"));
            // $check_frame = date('Y-m-d', strtotime("{$startDate} +{$wDays2} weekdays"));

            //using new function to add saturday as a working day
            $new_date = $this->GetNextBusinessDate($startDate, $wDays);
            $check_frame = $this->GetNextBusinessDate($startDate, $wDays2);

            foreach (GetHolidaysCalendar() as $holiday) {
                $isDateIsFallInHoliday = $holiday['holidays'] == $startDate;
                $holiday_ts = strtotime($holiday['holidays']);
                if (
                    ($holiday_ts >= strtotime($startDate)) &&
                    ($holiday_ts <= strtotime($check_frame)) &&
                    ($holiday_ts <= strtotime($new_date))
                ) {

                    // check if the holiday falls on a working day
                    $h = date('w', $holiday_ts);


                    //remove $h !== 6 condition to add Saturday as a working
                    if ($h != 0) {
                        // holiday falls on a working day, add an extra working day
                        $new_date = date('Y-m-d', strtotime("{$new_date} +1 weekdays"));
                        $isDateIsFallInHoliday ?
                            $new_date = date('Y-m-d', strtotime("{$new_date} -1 day")) : false;
                    }
                }
            }

            return $new_date;
        }
    }
    private function GetWorkingDaysBeforeSaturdayOff($startDate, $wDays)
    {

        $wDays2 = ($wDays * 2);
        // using + weekdays excludes weekends
        $new_date = date('Y-m-d', strtotime("{$startDate} +{$wDays} weekdays"));
        $check_frame = date('Y-m-d', strtotime("{$startDate} +{$wDays2} weekdays"));

        foreach (GetHolidaysCalendar() as $holiday) {
            $isDateIsFallInHoliday = $holiday['holidays'] == $startDate;
            $holiday_ts = strtotime($holiday['holidays']);
            if (
                ($holiday_ts >= strtotime($startDate)) &&
                ($holiday_ts <= strtotime($check_frame)) &&
                ($holiday_ts <= strtotime($new_date))
            ) {

                // check if the holiday falls on a working day
                $h = date('w', $holiday_ts);

                if ($h != 0 && $h != 6) {
                    // holiday falls on a working day, add an extra working day
                    $new_date = date('Y-m-d', strtotime("{$new_date} +1 weekdays"));
                    $isDateIsFallInHoliday ?
                        $new_date = date('Y-m-d', strtotime("{$new_date} -1 day")) : false;
                }
            }
        }

        return $new_date;
    }
    private  function GetNextBusinessDate($from, $wDays)
    {
        $workingDays = [1, 2, 3, 4, 5, 6]; # date format = N (1 = Monday, ...)

        $from = new DateTime($from);
        while ($wDays) {
            $from->modify('+1 day');
            if (! in_array($from->format('N'), $workingDays)) {
                continue;
            }
            $wDays--;
        }
        return $from->format('Y-m-d'); #  or just return DateTime object
    }
    private function insertToComplaintAndDetails(Request $request)
    {
        $productCateg=$request->product_category;
        $productId=$request->product;
        $cnic=$request->product;
        $complaintType=$request->complaint_type;
        $channel=$request->channel;
        $callbackNum=$request->call_back_phone;
        $response_no=$request->customer_mobile;

        $endDatetime = $this->getEndDate($productCateg,$productId,$complaintType);
        $smsInterimDate = $this->GetWorkingDays(GetCurrentDate(),11); //for sms interim every 11th working days but calculate from today so pass param is 10 :) // but now  calculate from next working days so pass 11
        $dataCounter = explode('|',$this->objComplaintManagement->GenComplaintCounter());

        $complaintNum = $dataCounter[0];
		$dailyCounter = $dataCounter[1];

        $datetime = GetCurrentDateTime();

        $userTypeId = Session::get('user_type');
        $complaintUnitName = Session::get('unit_name');
        $complaintUnitId = Session::get('unit_id');
        $loginId = Session::get('login_id');

        if($channel == "2"){
            $response_no = $callbackNum;
        }

        $complaintData = ComplaintManagement::create([
            'daily_counter' => $dailyCounter,
            'from_unit_id' => $complaintUnitId,
            'complaint_num' => $complaintNum,
            'agent_id' => $loginId,
            'group_id' => '0',
            'user_id' => '0',
            'product_category' => $request->product_category,
            'product_id' => $request->product,
            'complaint_type_id' => $request->complaint_type,
            'priority_id' => $request->priority,
            'status_id' => '1',
            'create_date' => $datetime,
            'end_date' => $endDatetime,
            'source' => $request->source,
            'amount' => $request->amount
        ]);
        $complaintId=$complaintData->complaint_id;
        DB::table('tbl_complaint_details')->insert(
            [   'complaint_id' => $complaintId,
                'compl_title' => $request->complaint_title,
                'cnic' => $request->cnic,
                'customer_name' => $request->customer_name,
                'mother_maiden' => $request->mother_maiden_name,
                'dob'=> DATE('Y-m-d',strtotime($request->date_of_birth)),
                'account_no' => $request->card_number,
                'complaint_nature' => $request->complaint_nature,
                'channel' => $request->channel,
                'complaint_measures' => '',
                'customer_branch_id' => $request->customer_branch,
                'description' => $request->note,
                'callback_num' => $request->call_back_phone,
                'delivery_address' => '',
                'residence_address' => $request->residence_address,
                'office_address' => '',
                'alternate_address' => '',
                'email' => $request->customer_e_mail,
                'office_phone' => $request->phone_office,
                'mobile_number' => '',
                'residence_phone' => '',
                'is_email' => $request->e_mail,
                'customer_email' => $request->customer_e_mail,
                'is_sms' => $request->sms,
                'response_number' =>  $response_no,
                'is_call_back' => $request->call_back,
                'against_branch_id' => $request->complaint_against_branch,
                'sms_interim_counter' => '1',
                'sms_interim_date' => $smsInterimDate,
                'language' => $request->language,

            ]
        );

        $data= DB::select(DB::raw("SELECT group_id FROM tbl_complaint_type WHERE product_category_id = '$productCateg' AND
         product_id = '$productId' AND id = '$complaintType' AND operation_mode = '1'"));
         if(count($data) > 0){
            $groupId = $data[0]->group_id;
            $usersId = DB::select(DB::raw("SELECT GROUP_CONCAT(user_id) AS user_id FROM tbl_users_group WHERE group_id = '$groupId'"));
            $usersId = $usersId[0]->user_id;
            if($usersId != ''){
                ComplaintManagement::where('complaint_id', $complaintId)
                ->update(['group_id' => $groupId,'user_id' => $usersId]);
            }
        }


            $this->SendSMSEmailCustomer($complaintId,'complaint_initiated');

            if($userTypeId == '3'){

                $this->ActivityAgentLogs('Add Complaint',$complaintNum."|".$cnic,'Complaint');

                $emailUsers = $this->objUser->GetEmailByUserType(2);
                SaveEmailCompEform('complaint',$complaintId,'1',$emailUsers[0]->emails);

            }else if($userTypeId == '2'){

                $this->ActivityLogs("Add Complaint [CNIC:$cnic, Complaint #: $complaintNum]");

                $emailUsers = $this->objUser->GetEmailByUserType(2);
                SaveEmailCompEform('complaint',$complaintId,'1',$emailUsers[0]->emails);

            }else if($userTypeId == '4'){

                $this->ActivityLogs("Add Complaint [CNIC:$cnic, Complaint #: $complaintNum]");

                $emailUsers = $this->objUser->GetEmailCMUAndBranch($complaintUnitId);
                SaveEmailCompEform('complaint',$complaintId,'1',$emailUsers[0]->emails);

            }else{

                $this->ActivityLogs("Add Complaint [CNIC:$cnic, Complaint #: $complaintNum]");

                if($channel == "2"){
                    $complaintUnitName = "Internet Banking";
                    $emailUsers = $this->objUser->GetEmailCMU();
                    SaveEmailCompEform('complaint',$complaintId,'1',$emailUsers[0]->emails);
                }else{
                    $emailUsers = $this->objUser->GetEmailCMUAndBranch($complaintUnitId);
                    SaveEmailCompEform('complaint',$complaintId,'1',$emailUsers[0]->emails);
                }
            }

            $this->objComplaintManagement->SaveComplaintStatus($loginId,$complaintId,1,1,'',0,0,0,"Complaint Initiated By $complaintUnitName");
			//$this->SetEmailEscalation($complaintId,$complaint_type);

        return true;
    }
   public static  function CheckOverDue($datetime)
   {
    if($datetime != '0000-00-00 00:00:00'){

        $str = date("Y-m-d", strtotime($datetime));
        $current_date = date("Y-m-d");

        if ($current_date > $datetime){
            return 1;
        }
         else{
            return 0;
        }

    }
    else{
        return 0;
    }


   }
    private function SendSMSEmailCustomer($complaintId,$type)
    {
        $dataCheck = $this->objComplaintManagement->CheckSMSEmail($complaintId); //check customer allow sms/email or not
        $isSms = $dataCheck[0]->is_sms;
        $customerMobileNo = $dataCheck[0]->customer_mobile_no;
        $languageCheck = $dataCheck[0]->language;

        if ($isSms == 1) {

            if ($type == 'complaint_initiated'){
                $templateId = $languageCheck == '1' ? '4' : '19'; //for language selection 4 = Eng & 19 = Urd
            }elseif($type == 'complaint_closed'){
                $templateId = $languageCheck == '1' ? '6' : '21'; //for language selection 6 = Eng & 21 = Urdu
            }

            SaveSMSCompEform($type, $complaintId, $templateId, $customerMobileNo);

        }

        $isEmail = $dataCheck[0]->is_email;
        $customerEmail = $dataCheck[0]->customer_email;

        if ($isEmail == 1 && $customerEmail != ""){

            if ($type == 'complaint_initiated'){
                $templateId = $languageCheck == '1' ? '22' : '25'; //for language selection 22 = Eng & 25 = Urd
            }elseif($type == 'complaint_closed'){
                $templateId = $languageCheck == '1' ? '24' : '27'; //for language selection 24 = Eng & 27 = Urdu
            }

            SaveEmailCompEform('complaint', $complaintId, $templateId, $customerEmail);
        }
    }
   public static function GetUserUnitForComplaint($unitId)
   {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(unit_name) unit_name FROM tbl_org_unit WHERE id IN ($unitId)"));
   }
   public function unitGroup(Request $request)
   {
        $group=$request->group;
        $unitIds=$request->unitId;
        $isAll=$request->is_all;
        $sb='';

        if($isAll == 1){
            if($group == 4){
                $sb .= "<option value='0'> ALL </option>";
            }else{
                $sb .= "<option value='-99'> Select Branch </option>";
            }
        }
        $data=DB::table('tbl_org_unit')->where('group_id',$group)->get();

        foreach($data as $unit){

            $unitId        = $unit->id;
            $unitName      = $unit->unit_name;
            $branchCode    = $unit->branch_code;
            $branchCode    = $branchCode != "" ? "($branchCode)"  : "";
            $selected=$unitIds == $unitId ? "Selected" : '';
            $sb .= "<option value=".$unitId." $selected> $unitName $branchCode </option>";
        }
        return $sb;

   }
   public function updateProgress(Request $request, int $id)
   {
    $activityDescription = "";

    $userId             = '0';
    $groupId            =is_null($request->group_id) ? '0' :$request->group_id;
    $unitId             =is_null($request->unit_id) ? '0' :$request->unit_id;
    $source             =is_null($request->source) ? '' :$request->source;
    $progress           =is_null($request->progress) ? '' :$request->progress;
    $notes              =is_null($request->activity_note) ? '' :$request->activity_note;
    $approved           = '1';
    $favor              = is_null($request->favor) ? '1' :$request->favor;
    $closeNotes        = is_null($request->close_notes) ? '' :$request->close_notes;

    $complaint=ComplaintManagement::find($id);
    $previousStatusId =$complaint['status_id']; // $this->GetComplaintPreviousStatus($id);
    $saveUnitId =$complaint['unit_id'];
    $saveGroupId=$complaint['group_id'];
    $complaintNo=$complaint['complaint_num'];

    $datetime = GetCurrentDateTime();

    $userType = Session::get('user_type');
    $loginId = Session::get('login_id');


    if($progress == '90'){

        $statusId = '4';

        if($saveUnitId == $unitId){
            if($userType == 4 || $userType == 5){

                $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$notes);

                $activity_description = "Resolved Complaint [Complaint #: $complaintNo, Resolved Date: $datetime]";
                $this->ActivityLogs($activity_description);

                $emailUsers = $this->objUser->GetEmailByBranchUsers(2);
                SaveEmailCompEform('complaint',$id,'17',$emailUsers[0]->emails);
            }
        }
        else{

            $progress = "80";   //reassign status revert progress to 80 percent again
            $statusId = "2";   //status revert to inprogress again

            $fromUnits = $this->objUser->GetOrganizationUnitById($saveUnitId);
            $toUnits = $this->objUser->GetOrganizationUnitById($unitId);
            $fromUnits=$fromUnits[0]->unit_name;
            $toUnits=$toUnits[0]->unit_name;
            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$notes);
            $extraNotes = "Complaint Re-Assign from $fromUnits to $toUnits";
            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$extraNotes);

            $activityDescription = $extraNotes . " [Complaint #: $complaintNo]";
            $this->ActivityLogs($activityDescription);

            $complaint['forward_by']=$loginId;

            $emailUsers = $this->objUser->GetEmailByBranchUsers($unitId);
            SaveEmailCompEform('complaint',$id,'2',$emailUsers[0]->emails);
        }

    }
    elseif($progress == '100'){

        $statusId = '3';
        $complaint['close_date']=$datetime;

        $activityDescription = "Closed Complaint [Complaint #: $complaintNo, Closed Date: $datetime]";
        $this->ActivityLogs($activityDescription);

        $emailUsers = $this->objUser->GetEmailCMUAndBranch($unitId);
        SaveEmailCompEform('complaint',$id,'3',$emailUsers[0]->emails);

        $this->SendSMSEmailCustomer($id,'complaint_closed');

        $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$notes);
    }
    elseif($progress == '101'){

        $statusId = '5';
        $progress = '0';
        $complaint['group_id']='0';
        $complaint['user_id']='0';
        $complaint['unit_id']='0';

        $activityDescription = "Invalid Complaint [Complaint #: $complaintNo]";
        $this->ActivityLogs($activityDescription);

        $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$notes);
    }
    else{
        $statusId = '2';
        $activityDescription = "In Progress Complaint [Complaint #: $complaintNo, Progress: $progress%]";

        if($saveUnitId == $unitId){

            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$notes);
            $this->ActivityLogs($activityDescription);

        }
        else{

            $fromUnits = $this->objUser->GetOrganizationUnitById($saveUnitId);
            $toUnits = $this->objUser->GetOrganizationUnitById($unitId);
            $fromUnits=$fromUnits[0]->unit_name;
            $toUnits=$toUnits[0]->unit_name;

            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$notes);
            $extraNotes = "Complaint Forward from $fromUnits to $toUnits";
            $this->objComplaintManagement->SaveComplaintStatus($loginId,$id,$previousStatusId,$statusId,$userId,$unitId,$source,$progress,$extraNotes);

            $activityDescription = $extraNotes . " [Complaint #: $complaintNo]";
            $this->ActivityLogs($activityDescription);

            $complaint['forward_by']=$loginId;


            $emailUsers = $this->objUser->GetEmailByBranchUsers($unitId);
            SaveEmailCompEform('complaint',$id,'2',$emailUsers[0]->emails);

            //here update tbl_escalation_execute table for email escalation dates
        }
    }
            $complaint['comments_progress']=$notes;
            $complaint['progress']=$progress;
            $complaint['status_id']=$statusId;
            $complaint['group_id']=$groupId;
            $complaint['unit_id']=$unitId;
            $complaint['is_approved']=$approved;
            $complaint['favor']=$favor;
            $complaint['close_notes']=$closeNotes;
            $complaint->save();

            return redirect()->back();

   }

}
