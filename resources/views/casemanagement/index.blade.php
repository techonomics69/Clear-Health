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
              <div class="table-responsive">
                <!-- <table class="table table-striped table-bordered nowrap" style=" width:100%" id="CaseManagementList"> -->
                <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
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
                      <th width="100px">Action</th>
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
                        {{ $case_data['follow_up'] }}
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
                      <td>{{ $case_data['email'] }} </td>
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
                          <span class="badge badge-info">Store & Send iPledge Credentials</span>
                        </a>
                        @elseif($case_data['case_status'] == 'verify_pregnancy')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=pregnancy_test">
                          <span class="badge badge-info">Verify Pregnancy Test</span>
                        </a>
                        @elseif($case_data['case_status'] == 'prior_auth')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=prior_auth">
                          <span class="badge badge-info">Confirm Prior Auth</span>
                        </a>
                        @elseif($case_data['case_status'] == 'check_off_ipledge')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=action_items">
                          <span class="badge badge-info">Check Off iPledge Item</span>
                        </a>
                        @elseif($case_data['case_status'] == 'trigger')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=triggers">
                          <span class="badge badge-info">Trigger ques + 7 Day window</span>
                        </a>
                        @elseif($case_data['case_status'] == 'blood_work')
                        <a href="{{ route('casemanagement.show',$case_data['id']) }}?active=blood_work">
                          <span class="badge badge-info">Upload bloodwork</span>
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
  // jQuery(document).ready(function($) {
  //   $('#CaseManagementList').DataTable({
  //     "dom": '<"top"if>rt<"bottom"lp><"clear">',

  //   });
  // });

  $(document).ready(function() {
    var table = $('#example').DataTable( {

      "dom": '<"top"if>rt<"bottom"lp><"clear">',

        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true
    } );
} );






</script>
@endsection
<!-- <style>
  .table-bordered{
    border: 0;
  }
</style> -->