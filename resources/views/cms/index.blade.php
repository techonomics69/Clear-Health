@extends('layouts.app')
@section('title', 'clearHealth | CMS')

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
				<h3 class="content-header-title mb-0">CMS</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active">CMS List</li>
							</ol>
						</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
			<div class="pull-right">	
			@can('cms-create')				
					<a class="btn btn-secondry" href="{{ route('cms.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New CMS</a>
			@endcan		
				</div>
			</div>
		</div>
		<section class="basic-elements">
		<div class="content-body">
			<div class="row">
				<div class="col-lg-12">
					<section class="card" >

						<!-- <div class="col-lg-12 margin-tb card-header ">
							<div class="pull-left">
								<h2 class="main-title-heading">Cms Management</h2>
							</div>
							<div class="pull-right">					
								<a class="btn btn-secondry" href="{{ route('cms.create') }}">&plus; Create New CMS</a>
							</div>
						</div>  -->
						
						<!-- <div class="card-body progress-card">
							<div class="task-progress">
								<input class="form-control input-small" type="" name="search" />
							</div>
						</div> -->
						<div class="row" style="padding: 20px;">
							<div class="col-md-12">
						<table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="cmsList">
							<thead>
							<tr>
								<th width="60px">No</th>
								<th>Title</th>
								<!-- <th>URL</th> -->
								<th>Status</th>					
								<th width="200px">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($cms as $key => $cms_value)
							<tr>
								<td>{{ ++$i }}</td>
								<td>{{ $cms_value->title }}</td>
								<!-- <td>{{ $cms_value->url }}</td> -->
								<td>
									@if($cms_value->status == 1)
										<span class="badge badge-success">On</span>
									@else
										<span class="badge badge-danger">Off</span>
									@endif
								</td>
								<td>
									<div class="d-flex">
									<a class="icons edit-icon" href="{{ route('cms.show',$cms_value->id) }}">
										<i class="fa fa-eye"></i>
									</a> 
									@can('cms-edit')	
									<a class="icons edit-icon" href="{{ route('cms.edit',$cms_value->id) }}">
										<i class="fa fa-edit"></i>
									</a>
									@endcan
									@can('cms-delete')							
									{!! Form::open(['method' => 'DELETE','route' => ['cms.destroy', $cms_value->id],'style'=>'display:inline']) !!}
										<a class="icons edit-icon cms_delete" href="#" id="{{$cms_value->id}}" onclick="deletecms({{$cms_value->id}})">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
										<button type="submit" class="btn btn-danger btn_delete{{$cms_value->id}}" style="display:none;">Delete</button>
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
    	$('#cmsList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
		});
	});
	
	function deletecms(e){
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


	