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
            <div class="col-md-4">

                <select id="filter1" class="form-control">
                    <option value="">--SELECT ACTION--</option>
                    <option value="All">All</option>
                    <option value="Action by admin" selected>Action by admin</option>
                    <option value="Action by Patient">Action by Patient</option>
                    <option value="No action required">No action required</option>
                </select>
            </div>
          </div>    
          <div class="row" style="padding: 20px;">
            <div class="col-md-12">
              <div class="">
                <table class="table table-responsive table-striped table-bordered " style=" width:100%" id="CaseManagementList">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.1.219/js/kendo.all.min.js"></script>
<script>
  $.noConflict();
  // jQuery(document).ready(function($) {

    var token = "{{ csrf_token() }}";
		var url = "{{ route('casemanagement.showList') }}";

    // var Datatable = $('#CaseManagementList').DataTable({
    //   "dom": '<"top"if>rt<"bottom"lp><"clear">',
    //   "bLengthChange": false,
    //   "bInfo": false,
     
      

			// "paging": true,
			// "autoWidth": true,
			// "fixedHeader": true,
		  //  "aoColumnDefs": [
     
      //       {"sWidth": "7%", "aTargets": [0]},
      //       {"sWidth": "7%", "aTargets": [1]},
      //       {"sWidth": "7%", "aTargets": [2]},
      //       {"sWidth": "7%", "aTargets": [3]},
      //       {"sWidth": "7%", "aTargets": [4]},
      //       {"sWidth": "7%", "aTargets": [5]},
      //       {"sWidth": "7%", "aTargets": [6]},
      //       {"sWidth": "7%", "aTargets": [7]},
      //       {"sWidth": "7%", "aTargets": [8]},
      //       {"sWidth": "7%", "aTargets": [9]},
      //       {"sWidth": "7%", "aTargets": [10]},
      //       {"sWidth": "7%", "aTargets": [11]},
      //       {"sWidth": "7%", "aTargets": [12]},
      //       {"sWidth": "7%", "aTargets": [13]},
           
      //   ],
         
        // "bAutoWidth": true,
        
    //     "fixedHeader": {
    //     header: true,
    //     scrollY:        "300px",
     // scrollX:        true,
    //  scrollCollapse:true,
    // },
 
        // scrollCollapse: true,
 

    //  });

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

        
  //  });
  

  function InitilizeTable(searchValue){
    var Datatable = $('#CaseManagementList').DataTable({
      "dom": '<"top"if>rt<"bottom"lp><"clear">',
      "bLengthChange": false,
      "bInfo": false,
     
        language: {search: "", searchPlaceholder: "Search"},
      'searching': true,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "lengthChange": false,
      "filter": true,
        //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']],

      'ajax': {
          'url':url,
          'data': {_token:token, filterValue:searchValue},
      },
      'columns': [
		      	{ data: 'srno' },
            { data: 'date' },
            { data: 'caseid' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'gender' },
            { data: 'visitnumber' },
            { data: 'mdcaseid' },
            { data: 'mdstatus' },
            { data: 'visittype' },
            { data: 'treatmentplan' },
            { data: 'pharmacy' },
            { data: 'action1' },
            { data: 'action' },
            ],aoColumnDefs: [
              {
                bSortable: false,
                aTargets: [ 6,8,9,10,11,12 ]
              }
				],
				language: {
        			"processing": "Loading....."
    			},
    		"order": [[ 0, "desc" ]],  

    });
  }

  InitilizeTable('');
   
   $('#filter1').on('change', function(){
    var filter_value = $(this).val();
    $("#CaseManagementList").DataTable().destroy();
    
      var Datatable = $('#CaseManagementList').DataTable({
        "dom": '<"top"if>rt<"bottom"lp><"clear">',
        "bLengthChange": false,
        "bInfo": false,
          language: {search: "", searchPlaceholder: "Search"},
        'searching': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "lengthChange": false,
        "filter": true,
          //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']],

        'ajax': {
            'url':url,
            'data': {_token:token, filterValue:filter_value},
        },
        'columns': [
              { data: 'srno' },
              { data: 'date' },
              { data: 'caseid' },
              { data: 'firstname' },
              { data: 'lastname' },
              { data: 'gender' },
              { data: 'visitnumber' },
              { data: 'mdcaseid' },
              { data: 'mdstatus' },
              { data: 'visittype' },
              { data: 'treatmentplan' },
              { data: 'pharmacy' },
              { data: 'action1' },
              { data: 'action' },
              ],aoColumnDefs: [
                {
                  bSortable: false,
                  aTargets: [ 6,8,9,10,11,12 ]
                }
          ],
          language: {
                "processing": "Loading....."
            },
          "order": [[ 0, "desc" ]],  

      });
    
  });
   

</script>
@endsection
<style>
  th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>