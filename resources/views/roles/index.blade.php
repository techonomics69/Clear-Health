@extends('layouts.app')

@section('title', 'clearHealth | Roles')
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
                <h3 class="content-header-title mb-0">Role</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Role</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">    
                @can('role-create')                
                    <a class="btn btn-secondry" href="{{ route('roles.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Role</a>
                @endcan    
                </div>
            </div>
        </div>

        <div class="content-body">
            <div class="row">
                <div class="col-lg-12">
                    <section class="card" >

                        <!-- <div class="col-lg-12 margin-tb card-header ">
                            <div class="pull-left">
                                <h2 class="main-title-heading">Role Management</h2>
                            </div>
                            <div class="pull-right">                    
                                <a class="btn btn-secondry" href="{{ route('roles.create') }}">&plus; Create New Role</a>
                            </div>
                        </div>  -->
                        
                        <!-- <div class="card-body progress-card">
                            <div class="task-progress">
                                <input class="form-control input-small" type="" name="search" />
                            </div>
                        </div> -->
                        <div class="row" style="padding: 20px;">
                            <div class="col-md-12">
                                <div class="">
                        <table class="table table-striped table-bordered  table-responsive-md " style="width:100%" id="roleList">
                            <thead>
                            <tr>
                                <th width="60px">No</th>
                                <th>Name</th>
                                <th width="200px">Action</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                <div class="d-flex">
                                    <a class="icons  edit-icon" href="{{ route('roles.show',$role->id) }}"><i class="fa fa-eye"></i></a> 
                                    @can('role-edit')
                                    <a class="icons  edit-icon" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('role-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                        <a class="icons  edit-icon role_delete" href="#" id="{{$role->id}}" onclick="deleterole({{$role->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <button type="submit" class="btn btn-danger btn_delete{{$role->id}}" style="display:none;">Delete</button>
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
        </div>
    </div>
                                        </div>
@endsection

@section('scriptsection')
  
<script>
    $.noConflict();
    jQuery( document ).ready(function( $ ) {
        $('#roleList').DataTable({
            "dom": '<"top"if>rt<"bottom"lp><"clear">',
            
        });
    });
    
    function deleterole(e){
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


    