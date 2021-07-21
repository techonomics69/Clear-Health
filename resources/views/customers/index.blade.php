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
        <h3 class="content-header-title mb-0">Customers</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12 d-flex">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Customer List</li>
              </ol>
            </div>
        </div>
      </div>
      <div class="content-header-right col-md-6 col-12 mb-2">
        <div class="pull-right">
          @can('customer-create')
          <a class="btn btn-secondry " href="{{ route('customers.create') }}"><i class="fa fa-plus"></i> Create New Customer</a>
          @endcan
        </div>
      </div>
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
{{-- 
                  <select id="filter1" class="form-control">
                    <option value="">--SELECT--</option>
                    <option value="Current Month">Current Month</option>
                    <option value="Last 3 Months">Last 3 Months</option>
                    <option value="Last 6 Months">Last 6 Months</option>
                    <option value="Custome Dates">Custome Dates</option>
                </select> --}}
                <div class="">
                  <table class="table  table-responsive table-striped table-bordered" style="width:100%" id="customerList">
                    <thead>
                    <tr>
                      <th>No</th>             
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Gender</th>
                      <th>Email</th>
                      <th>DOB</th>
                      <th>Address</th>           
                      <th width="280px">Action</th>             
                    </tr>
                    </thead>
                    <tbody>
                  {{--   @foreach ($data as $key => $user)
                    
                    <tr>
                      <td>{{ ++$i }}</td>           
                      <td>{{ $user->first_name }}</td>
                      <td>{{ $user->last_name }}</td> 
                      <td>{{ $user->gender }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->dob }}</td>
                      <td>{{ $user->address }}</td>
                      <td>
                        <div class="d-flex">
                        <a class="icons edit-icon" href="{{ route('customers.show',$user->id) }}"><i class="fa fa-eye"></i></a>                  
                        @can('customer-edit')
                        <a class="icons edit-icon" href="{{ route('customers.edit',$user->id) }}"><i class="fa fa-edit"></i></a>
                        @endcan
                        @can('customer-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['customers.destroy', $user->id],'style'=>'display:inline']) !!}
                        <a class="icons edit-icon customer_delete" href="#" id="{{$user->id}}" onclick="deleteCustomer({{$user->id}})">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                                            
                          <button type="submit" class="btn_delete{{$user->id}}" style="display:none;"></button>               
                        {!! Form::close() !!}
                        @endcan
                        </div>
                      </td>
                    </tr>
                    @endforeach --}}
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
  var token = "{{ csrf_token() }}";
    var url = "{{ route('customer.showList') }}";
/*  jQuery( document ).ready(function( $ ) {
      $('#customerList').DataTable({
      "dom": '<"top"if>rt<"bottom"lp><"clear">',
      "aoColumnDefs": [
     
     {"sWidth": "300px", "aTargets": [0]},
     {"sWidth": "500px", "aTargets": [1]},
     {"sWidth": "500px", "aTargets": [2]},
     {"sWidth": "500px", "aTargets": [3]},
    
    
 ],
 "bLengthChange": false,
        "bAutoWidth": true,
        "bInfo": false,
        language: {search: "", searchPlaceholder: "Search"},
    });

    
  });*/

   function InitilizeTable(searchValue){
    var Datatable = $('#customerList').DataTable({
      // "dom": '<"top"if>rt<"bottom"lp><"clear">',
      "dom" : "<'row mb-2'<'col-sm-12 col-md-4 pl-4 actinc'l><'col-sm-12 col-md-8'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      "bLengthChange": false,
      "bInfo": false,

      initComplete: function () {
      var Select = '<select id="filter1" class="form-control" style="cursor:pointer;">';
          Select +='<option value="">--SELECT--</option>';
          Select +='<option value="Current Month" selected>Current Month</option>'
          Select +='<option value="Last 3 Months">Last 3 Months</option>'
          Select +='<option value="Last 6 Months">Last 6 Months</option>'
          Select +='<option value="Custome Dates">Custome Dates</option>'
          Select += '</select>';   
      $(".actinc").append(Select);
      },
     
      

      //scrollX:  true,
       
      'searching': true,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      // "lengthChange": false,
      "filter": true,
        //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']],

      'ajax': {
          'url':url,
          'data': {_token:token, filterValue:searchValue},
      },
        //     "aoColumnDefs": [
     
        //     {"sWidth": "7%", "aTargets": [0]},
        //     {"sWidth": "7%", "aTargets": [1]},
        //     {"sWidth": "7%", "aTargets": [2]},
        //     {"sWidth": "7%", "aTargets": [3]},
        //     {"sWidth": "7%", "aTargets": [4]},
        //     {"sWidth": "7%", "aTargets": [5]},
        //     {"sWidth": "7%", "aTargets": [6]},
        //     {"sWidth": "7%", "aTargets": [7]},
        //     {"sWidth": "7%", "aTargets": [8]},
        //     {"sWidth": "7%", "aTargets": [9]},
        //     {"sWidth": "7%", "aTargets": [10]},
        //     {"sWidth": "7%", "aTargets": [11]},
        //     {"sWidth": "7%", "aTargets": [12]},
        //     {"sWidth": "7%", "aTargets": [13]},
           
        // ],
      'columns': [
            { data: 'no', "sWidth": "15%","aTargets": [0] },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'gender' },
            { data: 'email' },
            { data: 'dob' },
            { data: 'address' },
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

        // language: {search: "", searchPlaceholder: "Search"},

    });
  }

    InitilizeTable('Action by admin');
   
   $(document).on('change','#filter1', function(){
    
    var filter_value = $(this).val();
    $("#customerList").DataTable().destroy();

    var Datatable = $('#customerList').DataTable({
      "dom" : "<'row mb-2'<'col-sm-12 col-md-4 pl-4 actinc'l><'col-sm-12 col-md-8'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      "bLengthChange": false,
      "bInfo": false,

      initComplete: function () {
      var Select = '<select id="filter1" class="form-control" style="cursor:pointer;">';
           Select +='<option value="">--SELECT--</option>';
          Select +='<option value="Current Month" selected>Current Month</option>'
          Select +='<option value="Last 3 Months">Last 3 Months</option>'
          Select +='<option value="Last 6 Months">Last 6 Months</option>'
          Select +='<option value="Custome Dates">Custome Dates</option>'
          Select += '</select>';   
      $(".actinc").append(Select);
      },
      'searching': true,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "filter": true,
      'ajax': {
          'url':url,
          'data': {_token:token, filterValue:filter_value},
      },
      'columns': [
             { data: 'no', "sWidth": "15%","aTargets": [0] },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'gender' },
            { data: 'email' },
            { data: 'dob' },
            { data: 'address' },
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
    
      // var Datatable = $('#CaseManagementList').DataTable({
      //   "dom": '<"top"if>rt<"bottom"lp><"clear">',
      //   "bLengthChange": false,
      //   "bInfo": false,
      //     language: {search: "", searchPlaceholder: "Search"},
      //   'searching': true,
      //   'processing': true,
      //   'serverSide': true,
      //   'serverMethod': 'post',
      //   "lengthChange": false,
      //   "filter": true,
      //     //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']],

      //   'ajax': {
      //       'url':url,
      //       'data': {_token:token, filterValue:filter_value},
      //   },
      //   'columns': [
      //         { data: 'srno' },
      //         { data: 'date' },
      //         { data: 'caseid' },
      //         { data: 'firstname' },
      //         { data: 'lastname' },
      //         { data: 'gender' },
      //         { data: 'visitnumber' },
      //         { data: 'mdcaseid' },
      //         { data: 'mdstatus' },
      //         { data: 'visittype' },
      //         { data: 'treatmentplan' },
      //         { data: 'pharmacy' },
      //         { data: 'action1' },
      //         { data: 'action' },
      //         ],aoColumnDefs: [
      //           {
      //             bSortable: false,
      //             aTargets: [ 6,8,9,10,11,12 ]
      //           }
      //     ],
      //     language: {
      //           "processing": "Loading....."
      //       },
      //     "order": [[ 0, "desc" ]],  

      // });
    
  });
  
  function deleteCustomer(e){
     swal({
        title: "Are you sure want to delete?",
        text: "You will not be able to recover this !",
        icon: "../public/icon/delete.png",
        imageSize: '60x60',          
        buttons: true,
        dangerMode: false,
        buttons: ["No, cancel Please!",'Yes, delete it!']
      }).then((willDelete) => {
            if (willDelete) {
         $('.btn_delete'+e)[0].click();    
            } 
        });
  };
</script>
@endsection
<!-- <style>
  .table-bordered{
    border: 0;
  }
</style> -->
