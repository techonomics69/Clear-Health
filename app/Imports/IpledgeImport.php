<?php

namespace App\Imports;

use App\Models\Ipledge;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IpledgeImport implements ToModel, WithHeadingRow

//class IpledgeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

     // protected $patients_type;


  public function  __construct($patients_type)
    {
      $this->patients_type= $patients_type; 
  }

     // function __construct($patients_type) {
     //        $this->$patients_type = $patients_type;
     // }
 
    public function model(array $row)
    {

        $ipledge_data = Ipledge::where('patient_id',$row['patient_id'])->get(); 

            $patientstype = $this->patients_type;

        if(!empty($ipledge_data) && count($ipledge_data)>0){
                
        }else{

            return new Ipledge([
            'patient_id'     => $row['patient_id'],
            'addon_date'    => isset($row['addon_date']) ? $row['addon_date'] : null,
            'addon_by' => isset($row['addon_by']) ? $row['addon_by'] : "",
            'patient_name' => isset($row['patient_name']) ? $row['patient_name'] : "",
            'patients_type' => $patientstype,
            'gender' => isset($row['gender']) ? $row['gender'] : "",
            'assigned_date' => isset($row['assigned_date']) ? $row['assigned_date'] : null,
            'assigned_by' => isset($row['assigned_by']) ? $row['assigned_by'] : "",
            'notes' => isset($row['notes']) ? $row['notes'] : "",
        ]); 
        }
       
        
    }
}
