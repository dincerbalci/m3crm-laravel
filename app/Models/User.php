<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   
    const CREATED_AT = 'create_datetime';
    const UPDATED_AT = 'update_datetime';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'password', 'first_name','last_name','email','employee_id','mobile_no','region_id','unit_id','group_id',
        'role_id','isactive','islogin','isfirstlogin','isadmin','login_attempt','create_datetime','update_datetime','expiry_date','last_login',
        'token','token_expiry','is_all_complaint','is_all_eform','user_type','dark_mode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Get the tbl_users first_name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return $this->attributes['first_name'] = ucwords($value);
    }
    /**
     * Get the tbl_users last_name.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return $this->attributes['last_name'] = ucwords($value);
    }
    public function GetDbUser($userId)
    {
        $checkusr= DB::select(DB::raw("SELECT user_name, user_type, isactive, islogin, login_attempt FROM tbl_users WHERE user_name = '$userId'"));
        return $checkusr;
    }

    public function GetCheckUser($userId){
        $getcheckuser= DB::select(DB::raw("SELECT u.*,IFNULL(g.group_name,'Admin') group_name, IFNULL(t.unit_name,'Admin') unit_name, t.branch_code
        FROM tbl_users u
        LEFT JOIN tbl_groups g ON u.group_id = g.id
        LEFT JOIN tbl_org_unit t ON u.unit_id= t.id
        WHERE user_name = '$userId' "));
        return $getcheckuser;
    } 
    public function GetCheckUserExpiry($userId)
    {
        $date = GetCurrentDate();
        $getUser=User::where('user_name',$userId)->where('expiry_date', '>=', '2022-10-20')->get();
        return $getUser;
    }
    public function UpdateUserlogin($userName, $loginAttempt, $isLogin="0"){
        $userData=User::where('user_name',$userName)->get();
        $user = User::find($userData[0]->id);
        $user['last_login'] = GetCurrentDate();
        $user['login_attempt'] = $loginAttempt;
        if($isLogin == 1){
            $user['islogin'] = $isLogin;
        }
        $user->save();
    }
    public function GetSidebarMenu($loginId,$userType)
    {
        if($userType == 1){
        $query= DB::select(DB::raw("SELECT pg.page_name,pg.page_title,tbl_modules.`modules_icon`, tbl_modules.parent_id,tbl_modules.`id` AS module_id ,(SELECT md.`name` FROM tbl_modules md WHERE md.id = tbl_modules.parent_id) AS module,pg.page_icon
                        FROM tbl_modules
                        INNER JOIN tbl_pages pg ON pg.`module_id` = tbl_modules.`id`
                        WHERE pg.is_active = 1 GROUP BY pg.page_name
                        ORDER BY tbl_modules.`parent_id`, tbl_modules.`id`, pg.page_title"));
        }
        else{
            $query= DB::select(DB::raw("SELECT pg.page_name,pg.page_title ,tbl_modules.`modules_icon`, tbl_modules.parent_id,tbl_modules.`id` AS module_id ,(SELECT md.`name` FROM tbl_modules md WHERE md.id = tbl_modules.parent_id) AS module,pg.page_icon
            FROM tbl_roles_permissions gp
            INNER JOIN tbl_users_role ug ON ug.`role_id` = gp.`role_id`
            INNER JOIN tbl_modules ON tbl_modules.`id` = gp.`module_id`
            INNER JOIN tbl_pages pg ON pg.`module_id` = tbl_modules.`id`
            WHERE ug.`user_id` = '$loginId' AND (`create` = 1 OR `update` = 1 OR `delete` = 1 OR `view` = 1) AND pg.is_active = 1
            GROUP BY pg.page_name ORDER BY tbl_modules.`parent_id`, tbl_modules.`id`, pg.page_title"));

        }
        //echo $query;die;
        return $query;
    }
    public function GetEmailByUserType($userType)
    {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(email) AS emails FROM tbl_users WHERE user_type = '$userType' AND isactive = '1'"));
    }
    public function GetEmailCMUAndBranch($unitId)
    {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(email) AS emails FROM tbl_users WHERE user_type = '2' AND isactive = '1' OR unit_id = '$unitId'"));
    }
    public function GetEmailCMU()
    {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(email) AS emails FROM tbl_users WHERE user_type = '2' AND isactive = '1'"));
    }
    public function GetPermissions($pageName, $permission,$userType)
    {

        if($userType == 1){

            $data = DB::select(DB::raw("SELECT 1 AS permission_type,tbl_modules.`parent_id`,tbl_pages.`page_name` FROM `tbl_modules`
                      INNER JOIN tbl_pages ON tbl_pages.`module_id` = tbl_modules.`id`
                      WHERE tbl_pages.`page_name` = '$pageName' LIMIT 1"));

        }else{
            $roleId = Session::get('role_id');
            $data = DB::select(DB::raw("SELECT `$permission`,tbl_modules.`parent_id`,tbl_pages.`page_name` FROM `tbl_roles_permissions`
            INNER JOIN tbl_modules ON tbl_modules.`id` = tbl_roles_permissions.`module_id`
            INNER JOIN tbl_pages ON tbl_pages.`module_id` = tbl_roles_permissions.`module_id`
            WHERE role_id IN ('$roleId') AND tbl_pages.`page_name` = '$pageName'
            ORDER BY `$permission` DESC LIMIT 1"));
        }


        return json_encode($data);

        //return 1;
    }
    public function GetEmailByBranchUsers($unitId)
    {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(email) AS emails FROM tbl_users WHERE unit_id = '$unitId' AND isactive = '1'"));
    }
    public function GetOrganizationUnitById($id)
    {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(unit_name) unit_name FROM tbl_org_unit WHERE id IN ($id)"));
    }
    public function GetUsers($request)
    {
        $groupId=$request->group_id;
        $search=$request->search;
        $email=$request->email;
        $status=$request->status;
        $unitId=$request->unit_id;
        $paginationEnv=env('PAGINATION');
        
        $user= DB::table('tbl_users AS u')
        ->leftJoin('tbl_groups AS t', 't.id', '=', 'u.group_id')
        ->leftJoin('tbl_org_unit AS b', 'b.id', '=', 'u.unit_id')
        ->select(DB::raw("u.* ,t.group_name user_type_name, CONCAT(b.unit_name,' (',b.branch_code,')') branch_name,
        (SELECT GROUP_CONCAT(r.primary_name) FROM tbl_roles r INNER JOIN tbl_users_role ur ON r.id = ur.role_id WHERE ur.user_id = u.id) role_name"))
        ->where('u.id','!=','1')
        ->when($groupId, function ($query, $groupId) {
          return $query->whereRaw("FIND_IN_SET($groupId,u.group_id)");
        })
        ->when($email, function ($query, $email) {
            return $query->where('u.email', $email);
          })
        ->when($unitId, function ($query, $unitId) {
        return $query->where('b.id', $unitId);
        })
        ->when($search, function ($query, $search) {
        return $query->whereRaw("CONCAT(b.unit_name,b.branch_code,t.group_name,u.first_name) like '%$search%'");
        })
        ->when($status, function ($query, $status) {
        if($status != '99')
        {
            $status=$status == 'active' ? '1' : '0';
            return $query->where('u.isactive', $status);
        }
        })
        ->orderBy('u.id', 'desc')->paginate($paginationEnv);
        $user->appends(['group_id' => $groupId,'email'=>$email,'status'=>$status,'unit_id'=>$unitId,'search'=>$search]);
        return $user;

    }
    public function GetEmailAdcAndBranch($unitId)
    {
        //44 is adc back office id in tbl_org_unit
        return DB::select(DB::raw("SELECT GROUP_CONCAT(email) AS emails FROM tbl_users WHERE isactive = '1' AND (unit_id = '44' OR unit_id = '$unitId')"));
    }
    public function GetEmailFromAndTo($dataFromUnitId, $dataUnitId)
    {
        return DB::select(DB::raw("SELECT GROUP_CONCAT(email) AS emails FROM tbl_users WHERE isactive = '1' AND (unit_id = '44' OR unit_id = '$dataFromUnitId' OR unit_id = '$dataUnitId')"));
    }

   

   
}
