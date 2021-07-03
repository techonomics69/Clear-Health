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
            $userId = Auth::user()->id;
            $data = Notifications::where('user_id',$userId)->paginate(3);
            if(count($data)>0){
                $this->sendResponse($data, 'Records found');
            }else{
                $this->sendError('No records found');    
            }
        }catch(\Exception $ex){
            $this->sendError($ex->getMessages());
        }
    }
}
