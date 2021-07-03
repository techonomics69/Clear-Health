@extends('layouts.app')
@section('title', "clearHealth | Tags")

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
				<h3 class="content-header-title mb-0">Tags</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active">Tag List</li>
							</ol>
						</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
			<div class="pull-right">	
			@can('tag-create')				
					<a class="btn btn-secondry" href="{{ route('tags.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Tag</a>
			@endcan		
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
						<table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="tagList">
							<thead>
							<tr>
								<th width="60px">No</th>
								<th>Tag</th>
								<th>Status</th>													
								<th width="200px">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($tags as $key => $tag)
							<tr>
								<td>{{ ++$i }}</td>
								<td>{{ $tag->tag }}</td>
								<td>
									@if($tag->status == 1)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-danger">In-active</span>	
									@endif 
								</td>								
								<td>
									<div class="d-flex">
									<a class="icons edit-icon" href="{{ route('tags.show',$tag->id) }}">
										<i class="fa fa-eye"></i>
									</a> 
									@can('tag-edit')	
									<a class="icons edit-icon" href="{{ route('tags.edit',$tag->id) }}">
										<i class="fa fa-edit"></i>
									</a>
									@endcan
									@can('tag-delete')							
									{!! Form::open(['method' => 'DELETE','route' => ['tags.destroy', $tag->id],'style'=>'display:inline']) !!}
										<a class="icons edit-icon tag_delete" href="#" id="{{$tag->id}}" onclick="deleteTag({{$tag->id}})">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
										<button type="submit" class="btn btn-danger btn_delete{{$tag->id}}" style="display:none;">Delete</button>
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
    	$('#tagList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"bLengthChange": false,
        "bAutoWidth": true,
        "bInfo": false,
        language: {search: "", searchPlaceholder: "Search"},
		});
	});
	
	function deleteTag(e){
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


	