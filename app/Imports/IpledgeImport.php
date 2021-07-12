<?php

namespace App\Imports;

use App\Models\Ipledge;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class IpledgeImport implements  OnEachRow

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

  public function startRow(): int
    {
        return 3;
    }

     // function __construct($patients_type) {
     //        $this->$patients_type = $patients_type;
     // }
 
    // public function model(array $row)
    // {
        
    //     //print_r($row)."<br>";
    //     // $ipledge_data = Ipledge::where('patient_id',$row['patient_id'])->get(); 

    //     //     $patientstype = $this->patients_type;

    //     // if(!empty($ipledge_data) && count($ipledge_data)>0){
                
    //     // }else{

    //     //     return new Ipledge([
    //     //     'patient_id'     => $row['patient_id'],
    //     //     'addon_date'    => isset($row['addon_date']) ? $row['addon_date'] : null,
    //     //     'addon_by' => isset($row['addon_by']) ? $row['addon_by'] : "",
    //     //     'patient_name' => isset($row['patient_name']) ? $row['patient_name'] : "",
    //     //     'patients_type' => $patientstype,
    //     //     'gender' => isset($row['gender']) ? $row['gender'] : "",
    //     //     'assigned_date' => isset($row['assigned_date']) ? $row['assigned_date'] : null,
    //     //     'assigned_by' => isset($row['assigned_by']) ? $row['assigned_by'] : "",
    //     //     'notes' => isset($row['notes']) ? $row['notes'] : "",
    //     // ]); 
    //     // }
       
        
    // }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        
        if($rowIndex > 4){
            $ipledge_data = Ipledge::where('patient_id',$row[0])->get(); 

            $patientstype = $this->patients_type;

            if(!empty($ipledge_data) && count($ipledge_data)>0){
                    
            }else{

                return new Ipledge([
                        'patient_id'     => $row[0],
                        'addon_date'    => isset($row[1]) ? date("Y-m-d",strtotime($row[1])) : null,
                        'addon_by' => isset($row[2]) ? $row[2] : "",
                        'patient_name' => isset($row[3]) ? $row[3] : "",
                        'patients_type' => $patientstype,
                        'gender' => isset($row[4]) ? $row[4] : "",
                        'assigned_date' => isset($row[5]) ? $row[5] : null,
                        //'assigned_by' => isset($row[]) ? $row['assigned_by'] : "",
                        'notes' => isset($row[6]) ? $row[6] : "",
                    ]); 
            }
        }

        // $group = Group::firstOrCreate([
        //     'name' => $row[1],
        // ]);
    
        // $group->users()->create([
        //     'name' => $row[0],
        // ]);
    }

    
}
