<?php
use Illuminate\Support\Facades\DB;

function convertSec($sec)
{
    $init = $sec;
    $hours = floor($init / 3600);
    $minutes = floor(($init / 60) % 60);
    $seconds = $init % 60;
    
    return "$hours:$minutes:$seconds";
}
function GetCurrentDate(){
    $mytime = Carbon\Carbon::now();
    return $mytime->toDateString();
}
function GetCurrentDateTime()
{
    $mytime = Carbon\Carbon::now();
    return $mytime->toDateTimeString();
}
function GetHolidaysCalendar()
	{
        $data=DB::select(DB::raw("SELECT  from_date, to_date , is_repeat FROM tbl_calendar_holidays"));
		
		$holidays = [];
		foreach ($data as $holiday) {
			if ($holiday->from_date == $holiday->to_date) {
				$holidays[] = ['holidays' => checkRepeatDate($holiday->from_date, $holiday->is_repeat)];
			} else {
				$i = 0;
				$startTime = strtotime($holiday->from_date);
				$endTime = strtotime($holiday->to_date);
				do {
					$newTime = strtotime('+' . $i++ . ' days', $startTime);
					$date = date('Y-m-d', $newTime);
					$holidays[] = ['holidays' => checkRepeatDate($date, $holiday->is_repeat)];
				} while ($newTime < $endTime);
			}
		}
		
		
		return $holidays;
	}
	
function checkRepeatDate($date, $isRepeat)
{
	if ($isRepeat) {
		$year = explode('-', $date)[0];
		return str_replace($year, date('Y'), $date);
	}
	return $date;
}	

function SaveSMSCompEform($type,$compEformId,$templateId,$toNumber){

	$isSmsSend=env('iS_SMS_SEND');

	if($isSmsSend == "1"){

		if($toNumber <> ""){
			$toNumber = NumberFormat($toNumber);
			DB::table('tbl_sms_comp_eform')->insert(
				[   'to_number' => $toNumber, 
					'type' => $type,
					'comp_eform_id' => $compEformId,
					'template_id' => $templateId,
				]
			);
		}
	}
}
function SaveEmailCompEform($type,$compEformId,$templateId,$user_id){
		
	$isEmailSend=env('iS_EMAIL_SEND');

	if($isEmailSend == "1"){
		DB::table('tbl_emails_comp_eform')->insert(
			[   'to_email' => $user_id, 
				'type' => $type,
				'comp_eform_id' => $compEformId,
				'template_id' => $templateId,
			]
		);
	}

}

function LeadTime($created_date, $closed_date){

	$start_ts = strtotime($created_date);
	$end_ts = strtotime($closed_date);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}
function GetComplaintAging($startDate,$endDate='') {
		
	$start = new DateTime($startDate);

	if($endDate <> '' && $endDate <> '0000-00-00 00:00:00' && $endDate <> '1970-01-01' && $endDate <> '-0001-11-30'){
		$end = new DateTime($endDate);
	}else{
		$end = new DateTime(GetCurrentDate());
	}

	// otherwise the  end date is excluded (bug?)
	$end->modify('+1 day');

	$interval = $end->diff($start);

	// total days
	$days = $interval->days;

	// create an iterateable period of date (P1D equates to 1 day)
	$period = new DatePeriod($start, new DateInterval('P1D'), $end);

	// best stored as array, so you can add more than one
	//$holidays = array('2020-02-25');

	$data = GetHolidaysCalendar();

	$holidays = array();
	foreach ($data as $line){
		array_push($holidays,$line['holidays']);
	}

	foreach($period as $dt) {
		$curr = $dt->format('D');

		// for the updated question
		if (in_array($dt->format('Y-m-d'), $holidays)) {
			$days--;
			continue;
		}

		if ($startDate < '2022-04-16' || $startDate > '2022-05-07'){

			// substract if Saturday or Sunday
			if ($curr == 'Sat' || $curr == 'Sun') {
				$days--;
			}

		}else{

			// substract only Sunday
			if ($curr == 'Sun') {
				$days--;
			}
		}
	}

	return $days;
}

function NumberFormat($msisdn){

	$msisdn = trim($msisdn);
	$initial = substr($msisdn, 0, 2);
	if($initial == '03' || $initial == '92'){
		if($initial == '03') {
			$msisdn = '92'.substr($msisdn, 1, strlen($msisdn));
		}
	}

	return $msisdn;
}

