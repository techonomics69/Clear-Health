<?php
namespace App\Helper;
use App\Models\Activity_log;
use DB;
use Config;
use Exception;

class activityHelper {
    
    public static function insertActivity($data){
        try{
            $insert = Activity_log::create($data);
            if($insert->id > 0){
                return $insert->id;
            }
            return 0;
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }
}
?>