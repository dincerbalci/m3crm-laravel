<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\Logs;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    use Logs;
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $userId=$request->user_name;
        $password=$request->password;
        $objUser =new User();
        $exists = $objUser->GetDbUser($userId);
        $userIp = \Request::ip();
        $user_agent=$request->server('HTTP_USER_AGENT');

        if(!empty($exists)){

			$user_name = $exists[0]->user_name;
			$user_type = $exists[0]->user_type;

            if($exists[0]->islogin == 1){
                /*echo $output = "user login";
                exit;*/
            }
            if($exists[0]->isactive == 0){
                $request->session()->flash('error', 'User deactive');
                return redirect()->back();
            }

            if($exists[0]->login_attempt > 3){
                $request->session()->flash('error', 'User block');
                return redirect()->back();
            }
			
            $checkuser = $objUser->GetCheckUser($userId);
            if (!Hash::check($password, $checkuser[0]->password)) {
                if($user_type != "1")
                {
                    $login_attempt = $checkuser[0]->login_attempt + 1;
					$updateUser = $objUser->UpdateUserlogin($user_name,$login_attempt);
                }
                  $request->session()->flash('error', 'Login Fail, pls check password');
                 return redirect()->back();
             }

            if(!empty($checkuser)){

                if($checkuser[0]->isfirstlogin == 0){
                    $domain = request()->getHttpHost();
                    $userId=$checkuser[0]->id.'{{(----)}}'.$domain;
                    $userId=base64_encode($userId);
                    $request->session()->flash('error', 'First time login please change your password');
                    return redirect()->route('change_password',$userId);
                }

                $isExpire = $objUser->GetCheckUserExpiry($userId);

                if(!empty($isExpire))
                {
                    if($checkuser[0]->login_attempt > 3){
                        $request->session()->flash('error', 'User block to many login attempt');
                        return redirect()->back();
                    }


                    Session::put('user_name',$checkuser[0]->first_name." ".$checkuser[0]->last_name);
                    Session::put('login_id',$checkuser[0]->id);
                    Session::put('user_id',$checkuser[0]->user_name);
                    Session::put('user_type',$checkuser[0]->user_type);
                    Session::put('email',$checkuser[0]->email);
                    Session::put('group_id',$checkuser[0]->group_id);
                    Session::put('group_name',$checkuser[0]->group_name);
                    Session::put('unit_name',$checkuser[0]->unit_name);
                    Session::put('branch_code',$checkuser[0]->branch_code != "" ?  " (".$checkuser[0]->branch_code.")" : "");
                    Session::put('role_id',$checkuser[0]->role_id);
                    Session::put('unit_id',$checkuser[0]->unit_id);
                    Session::put('all_complaints',$checkuser[0]->is_all_complaint);
                    Session::put('all_eforms',$checkuser[0]->is_all_eform);
                    Session::put('dark_mode',$checkuser[0]->dark_mode);
                    Session::put('is_login','1');
                    Session::put('is_end_session','0');
                    Session::put('is_validate','0');

                    //print_r($_SESSION);die;

                    $updateUser = $objUser->UpdateUserlogin($user_name,0,1);
					
					$group_name = $checkuser[0]->group_name;
					Session::put('session_id', $this->SessionLoginLogs(Session::get('login_id'), Session::get('user_name'), $user_agent, $userIp));
					
					Session::put('sidebar_menu', $objUser->GetSidebarMenu($checkuser[0]->id,$checkuser[0]->user_type));
					$this->ActivityLogs("Success Login Attempt [User Id:$userId, Group Name:$group_name, User IP:$userIp]");
					// $output = "200";
		            //print_r($_SESSION['sidebar_menu']);die;
                }
                else
                {
					$group_name = $checkuser[0]->group_name;
					$this->ActivityLogs("Expired Login Attempt [User Id:$userId, Group Name:$group_name, User IP:$userIp]");
                }
            }
            else{
					$group_name = $checkuser[0]->group_name;

                $this->ActivityLogs("Failed Login Attempt [User Id:$userId, Group Name:$group_name, User IP:$userIp]");
				 if($user_type != "1"){
					$login_attempt = $exists['login_attempt'] + 1;
					$updateUser = $objUser->UpdateUserlogin($user_name,$login_attempt);
				 }
                //  $output = "fail password";
            }
        }
        else{
			$this->ActivityLogs("Invalid Login Attempt [User Id:$userId, User IP:$userIp]");
            // $output = "fail_exists";
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->session()->flush();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function changePassword($id)
    {
        $idD=base64_decode($id);
        $idD=explode('{{(----)}}',$idD);
        $idD=$idD[0];
        
        $user = User::find($idD);
        if(is_null($user))
        {
            return redirect()->route('login');
        }
        if($user->isfirstlogin == 1){
            return redirect()->route('login');
        }
        return view('auth/change_password',compact('id'));
    }
    public function changePasswordUpdate(Request $request)
    {
        
        $id=$request->user_id;
        $id=base64_decode($id);
        $id=explode('{{(----)}}',$id);
        $id=$id[0];
        
        $user = User::findOrFail($id);
        if($user->isfirstlogin == 1){
            return redirect()->route('login');
        }

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'confirmed|max:8|different:old_password',
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password),
                'isfirstlogin' => '1',
            ])->save();

            $request->session()->flash('success', 'Password changed');

            return redirect()->route('login');
        } else {
            $request->session()->flash('error', 'Password does not match');
            return redirect()->back();
        }

    }
    public function darkMode()
    {

        $userId=Session::get('login_id');
        $user = User::Find($userId);
        if($user->dark_mode == 'light')
        {
            Session::put('dark_mode','dark');
            $dark='dark';
        }
        else
        {
            Session::put('dark_mode','light');
            $dark='light';
        }
        $user->dark_mode =$dark;
        $user->save();
        return redirect()->route('dashboard');
    }
}