@extends('layouts.app')
@section('title', 'clearHealth | Permissions')

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
				<h3 class="content-header-title mb-0">Permissions</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active">Permission List</li>
							</ol>
						</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
			<div class="pull-right">					
					<a class="btn btn-secondry" href="{{ route('permissions.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Permission</a>
				</div>
			</div>
		</div>
		<section class="basic-elements">
		<div class="content-body">
			<div class="row">
				<div class="col-lg-12">
					<section class="card" >						
						<div class="row" style="padding: 20px;">
							<div class="col-md-12">
						<table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="permissionList">
							<thead>
							<tr>
								<th width="60px">No</th>
								<th>Name</th>
								<th>Parent Name</th>													
								<th>Guard Name</th>													
								<th width="200px">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($permissions as $key => $permission)
							<tr>
								<td>{{ ++$i }}</td>
								<td>{{ $permission->name }}</td>
								<td> {{ $permission->parent_name  }}</td>								
								<td> {{ $permission->guard_name  }}</td>								
								<td>
									<div class="d-flex">
									<!--<a class="icons edit-icon" href="{{ route('permissions.show',$permission->id) }}">
										<i class="fa fa-eye"></i>
									</a>  -->
										
									<a class="icons edit-icon" href="{{ route('permissions.edit',$permission->id) }}">
										<i class="fa fa-edit"></i>
									</a>							
									{!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
										<a class="icons edit-icon permission_delete" href="#" id="{{$permission->id}}" onclick="deletePermission({{$permission->id}})">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
										<button type="submit" class="btn btn-danger btn_delete{{$permission->id}}" style="display:none;">Delete</button>
									{!! Form::close() !!}	
								</div>						
								</td>
							</tr>
							@endforeach
							</tbody>
						</table>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
</section>
</div>

</div>
@endsection

@section('scriptsection')
  
<script>
	$.noConflict();
	jQuery( document ).ready(function( $ ) {
    	$('#permissionList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
		});
	});
	
	function deletePermission(e){
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


	