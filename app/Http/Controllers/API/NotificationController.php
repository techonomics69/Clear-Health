<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Notifications;
use Auth;
use Exception;

class NotificationController extends BaseController
{
    public function getHomeNotifications(Request $request){
        try{
            $userId = $request->user_id;
            $records = (isset($request->records)) ? (empty($request->records)) ? 3 : $request->records : 3;
            $data = Notifications::where('user_id',$userId)->orderBy('id','desc')->paginate($records);
            if(count($data)>0){
                $queryString = ['user_id'=>$userId];
                $data->appends($queryString);
                return $this->sendResponse($data, 'Records found');
            }else{
               return $this->sendError('No records found');    
            }
        }catch(\Exception $ex){
           return $this->sendError($ex->getMessage());
        }
    }

    public function getAllNotifications(Request $request){
        try{
            $userId = $request->user_id;
            $data = Notifications::where('user_id',$userId)->orderBy('id','desc')->paginate(10);
            if(count($data)>0){
                $queryString = ['user_id'=>$userId];
                $data->appends($queryString);

                return $this->sendResponse($data, 'Records found');
            }else{
               return $this->sendError('No records found');    
            }
        }catch(\Exception $ex){
           return $this->sendError($ex->getMessage());
        }
    }

    public function getUnreadNotifications(Request $request){
        try{
            $userId = $request->user_id;
            $data = Notifications::where('user_id',$userId)
                    ->whereNull('read_at')->count();
            if($data>0){
                return $this->sendResponse($data, 'Records found');
            }else{
               return $this->sendError('No records found');    
            }
        }catch(\Exception $ex){
            return $this->sendError($ex->getMessage());
        }
    }
}
