@extends('layouts.app')
@section('title', 'clearHealth | Customer')

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
        <div class="row" >
          <div class="col-lg-12">
            <section class="card">
              <!-- <header class="card-header top-heading">                
                <h3 class="main-title-heading">Users Management</h3> 
              </header> -->
              <div class="row"  style="padding: 20px;">
                <div class="col-md-12">
                <div class="">
                  <table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="CaseManagementList">
                    <thead>
                    <tr>
                      <th>SR No</th>             
                      <th>Date</th>
                      <th>MD Case ID</th>
                      <th>Case ID </th>
                      <th>MD Status</th>
                      <th>Order Status</th>
                      <th>Email</th>           
                      <th width="280px">Action</th>             
                    </tr>
                    </thead>
                    <tbody>
                      <?php $i=0;?>
                    @foreach ($user_case_management_data as $key => $case_data)
                    
                    <tr>
                      <td>{{ ++$i }}</td>           
                      <td>{{ $case_data['created_at'] }}</td> 
                      <td>{{ $case_data['md_case_id'] }}</td>
                      <td>{{ $case_data['ref_id']}}</td>
                      <td><?php if($case_data['md_status'] ==0){echo 'pending ';}else if($case_data['md_status'] ==1){echo 'support';}else{echo 'accepted';} ?></td>
                      <td>{{ $case_data['first_name'] }} </td>
                      <td>{{ $case_data['email'] }} </td>
                      <td>
                        <div class="d-flex">
                        <a class="icons edit-icon" href="{{ route('casemanagement.show',$case_data['id']) }}"><i class="fa fa-eye"></i></a>                  
                        </div>
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
  jQuery( document ).ready(function( $ ) {
      $('#CaseManagementList').DataTable({
      "dom": '<"top"if>rt<"bottom"lp><"clear">',
    });

    $.ajax({
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
        });
  });
</script>
@endsection
<!-- <style>
  .table-bordered{
    border: 0;
  }
</style> -->
