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
                <div class="">
                  <table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="customerList">
                    <thead>
                    <tr>
                      <th>No</th>             
                      <!-- <th>Name</th> -->
                      <th>Email</th>
                      <th>Roles</th> 
                                  
                      <th width="280px">Action</th>             
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $user)
                    
                    <tr>
                      <td>{{ ++$i }}</td>           
                      <!-- <td>{{ $user->name }}</td> -->
                      <td>{{ $user->email }}</td>
                      <td> 
                         <label class="badge badge-success">
                          @if(!empty($user->roles->first()->name))
                          {{ $user->roles->first()->name }}
                          @endif
                        </label>                                
                      </td>
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
      $('#customerList').DataTable({
      "dom": '<"top"if>rt<"bottom"lp><"clear">',
    });

    
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
