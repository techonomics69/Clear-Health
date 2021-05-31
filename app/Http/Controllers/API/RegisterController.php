<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Validator;
use Exception;
use DB; 
use Carbon\Carbon; 
use Illuminate\Support\Str;
use App\Models\CaseManagement;

   
class RegisterController extends BaseController 
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                // 'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ],[
                // 'name.required' => 'Please enter name',
                'email.required' => 'Please enter email address',
                'email.email' => 'Please enter valid email address',
                'email.unique' => 'The email address entered is already registered. Kindly try using a different email address',
                'password.required' => 'Please enter password',
                'c_password.required' => 'Please enter confirm password',
                'c_password.same' => 'Password not matched with confirm password',
            ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
       
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $customerRole = Role::findByName('Customer');
            $input['role'] = $customerRole->id;
            $user = User::create($input);
            if($user->id>0){
                $user->assignRole($customerRole->id);
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                    $user = Auth::user(); 
                    $success['token'] =  $user->createToken('MyApp')->accessToken;
                    $success['email'] =  $user->email;    
                    $success['user_id'] =  $user->id;    
                }else{
                    $success['token'] =  $user->createToken('MyApp')->accessToken;
                    $success['email'] =  $user->email;
                    $success['user_id'] =  $user->id;
                }
                
       
                return $this->sendResponse($success, 'User register successfully.');    
            }else{
                return $this->sendError('Unauthorised', array('Failed to register, please try again'));
            }
        }catch(\Exception $ex){
            //return $this->sendError('Server error',array($ex->getMessage()));
        }
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {   
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ],[
                'email.required' => 'Please enter email address',
                'password.required' => 'Please enter password',
            ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
            if(!empty($request->email)):
                $user = User::where('email',$request->email) -> first();
                if(empty($user)):
                    return $this->sendError('Unauthorised.', array('Invalid email or user'));
                endif;
            endif;
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                $success['email'] =  $user->email;
                $success['user_id'] =  $user->id;

       $case_status1 =  CaseManagement::OrderBy("user_id" , "DESC")->first(); 

       echo"<pre>";
       print_r($case_status1);
       echo"</pre>";
       die();
                return $this->sendResponse($success, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('Unauthorised.', array('Password does not matched'));
            } 
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }
        
    }

    public function forgot_password(Request $request){
        try{
            $emails = User::select('email')->where('role','!=','1')->get();
            $validator = Validator::make($request->all(), [
                //'email' => ['required',Rule::in($emails)]
                'email' => ['required']
            ],[
                'email.required' => 'Please enter email address',
            ]);

            if(!empty($request->email)):
                $user = User::where('email',$request->email) -> first();
                if(empty($user)):
                    return $this->sendError('Unauthorised.', array('Invalid email or user'));
                endif;
            endif;

            $token = Str::random(64);

            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );

       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }

            $details = [
                'title' => 'Please click on below link to reset your password',
                'token' => $token
            ];
   
            \Mail::to($request->email)->send(new \App\Mail\ForgotPassMail($details));

            return $this->sendResponse(array(), 'Password reset link is sent successfully');

        }catch(\Exception $ex){
             return $this->sendError('Server error',array($ex->getMessage()));
        }
    }

}