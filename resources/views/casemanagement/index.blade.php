@extends('layouts.app')
@section('title', 'clearHealth | Case Management')

@section('content')
<div class="app-content content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success">
    <p>{{ $message }}</p>
  </div>
  @endif

  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Case Management</h3>
        <div class="row breadcrumbs-top">
          <div class="breadcrumb-wrapper col-12 d-flex">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Case Management List</li>
            </ol>
          </div>
        </div>
      </div>
      {{-- <div class="content-header-right col-md-6 col-12 mb-2">
        <div class="pull-right">
          @can('customer-create')
          <a class="btn btn-secondry " href="{{ route('customers.create') }}"><i class="fa fa-plus"></i> Create New Customer</a>
      @endcan
    </div>
  </div> --}}
</div>
<div class="content-body">
  <section class="basic-elements">
    <div class="row">
      <div class="col-lg-12">
        <section class="card">
          <!-- <header class="card-header top-heading">                
                <h3 class="main-title-heading">Users Management</h3> 
              </header> -->
          <div class="row" style="padding: 20px;">
            <div class="col-md-12">
              <div class="">
                <table class="table table-responsive table-striped table-bordered nowrap" style=" width:100%" id="CaseManagementList">
                  <thead>
                    <tr>
                      <th>SR</th>
                      <th>Date</th>
                      <th>CaseID</th>
                      <th>FirstName</th>
                      <th>LastName</th>
                      <th>Gender</th>
                      <th>VisitNumber</th>
                      <th>MDCaseID</th>
                      <th>MDStatus</th>
                      <th>VisitType</th>
                      <th>TreatmentPlan</th>
                      <th>Pharmacy</th>
                      <th>Action</th>
                      <th>Actions Needed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($user_case_management_data as $key => $case_data)

                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{ $case_data['created_at']->format('d/m/Y') }}</td>
                      <td>{{ $case_data['ref_id']}}</td>
                      <td>{{ $case_data['first_name'] }}</td>
                      <td>{{ $case_data['last_name'] }}</td>
                      <td>{{ strtoupper($case_data['gender'][0]) }}</td>
                      <td>
                        @if(empty($case_data['follow_up']))
                        1
                        @else
                        {{ $case_data['follow_up'] + 1 }}
                        @endif
                      </td>
                      <td>{{ $case_data['md_case_id'] }}</td>
                      <td><?php if ($case_data['md_status'] == 0) {
                            echo 'pending ';
                          } else if ($case_data['md_status'] == 1) {
                            echo 'support';
                          } else {
                            echo 'accepted';
                          } ?></td>
                      <td>
                        @if(empty($case_data['follow_up']))
                        Initial
                        @else
                        FollowUp
                        @endif
                      </td>
                      <td></td>
                      <td></td>
                      <td>
                        <div class="d-flex">
                          <a class="icons edit-icon" href="{{ route('casemanagement.show',$case_data['id']) }}"><i class="fa fa-eye"></i></a>
                        </div>
                      </td>
                      <td>
                        @if($case_data['case_status'] == 'generate_ipledge')
                        <a href="https://www.ipledgeprogram.com/iPledgeUI/home.u" target="_blank">
                          <span class="badge badge-info">Generate iPledge Credentials</span>
                        </a>
                        @elseif($case_data['case_status'] == 'store_ipledge')

                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=action_items">
                          <span class="badge badge-info">Register Ipledge</span>
                        </a>
                        
                        @elseif($case_data['case_status'] == 'verify_pregnancy')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=pregnancy_test">
                          <span class="badge badge-info">Review Pregnancy Test & send case to MD</span>
                        </a>
                        
                        @elseif($case_data['case_status'] == 'prior_auth')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=prior_auth">
                          <span class="badge badge-info">Complete Prior Authorization</span>
                        </a>
                        @elseif($case_data['case_status'] == 'check_off_ipledge')
                        <a href="https://www.ipledgeprogram.com/iPledgeUI/home.u" target="_blank">
                          <span class="badge badge-info">Check Off Admin iPledge.com Items</span>
                        </a>
                        @elseif($case_data['case_status'] == 'trigger')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=triggers">
                          <span class="badge badge-info">Send Prescription Pickup Notification</span>
                        </a>
                        @elseif($case_data['case_status'] == 'blood_work')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=blood_work">
                          <span class="badge badge-info">Upload Bloodwork Results</span>
                        </a>
                        @elseif($case_data['case_status'] == 'low_income_program')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=blood_work">
                          <span class="badge badge-info">Enroll Absorica Patient Assistance Program</span>
                        </a>
                        @elseif($case_data['case_status'] == 'finish')
                        <span class="badge badge-info">Finish</span>
                        @else
                        <span class="badge badge-secondary">Action pending from patient</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div>

        </section>
      </div>
    </div>
  </section>
</div>
</div>

</div>

@endsection

@section('scriptsection')
<script>
  $.noConflict();
  jQuery(document).ready(function($) {
    var table = $('#CaseManagementList').dataTable();
        new $.fn.dataTable.FixedHeader( table );

    $('#CaseManagementList').DataTable({
      "dom": '<"top"if>rt<"bottom"lp><"clear">',

			// "paging": true,
			// "autoWidth": true,
			// "fixedHeader": true,
		  "aoColumnDefs": [
     
            {"sWidth": "300px", "aTargets": [0]},
            {"sWidth": "500px", "aTargets": [1]},
            {"sWidth": "500px", "aTargets": [2]},
            {"sWidth": "500px", "aTargets": [3]},
            {"sWidth": "500px", "aTargets": [4]},
            {"sWidth": "500px", "aTargets": [5]},
            {"sWidth": "500px", "aTargets": [6]},
            {"sWidth": "500px", "aTargets": [7]},
            {"sWidth": "500px", "aTargets": [8]},
            {"sWidth": "500px", "aTargets": [9]},
            {"sWidth": "500px", "aTargets": [10]},
            {"sWidth": "500px", "aTargets": [11]},
            {"sWidth": "500px", "aTargets": [12]},
            {"sWidth": "500px", "aTargets": [13]},
           
        ],
        "bLengthChange": false,
        "bAutoWidth": true,
       

 

     });

    /*$.ajax({
            method:"post",
            url:"{{url('/CaseStatus')}}",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            beforeSend: function(){
          //$(".outer-loader").show();
        },
            success:function(res){ 
                
                 alert(res);  
            }
        });*/
   });



</script>
@endsection
<!-- <style>
  .table-bordered{
    border: 0;
  }
</style> -->