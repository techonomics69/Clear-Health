@extends('layouts.app')
@section('title', "clearHealth | Testimonials")

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
				<h3 class="content-header-title mb-0">Testimonials</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active">Testimonial List</li>
							</ol>
						</div> 
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
			<div class="pull-right">		
			@can('testimonial-create')			
					<a class="btn btn-secondry" href="{{ route('testimonials.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Testimonial</a>
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
						<table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="testimonialList">
							<thead>
							<tr>
								<th >No</th>
								<th width="100px">Name</th>
								<th >Content</th>													
								<th >Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($testimonials as $key => $testimonial)
							<tr>
								<td>{{ ++$i }}</td>
								<td>{{ $testimonial->name }}</td>
								<td>
									{{ $testimonial->content }}
										 
								</td>								
								<td>
									<div class="d-flex">
									<a class="icons edit-icon" href="{{ route('testimonials.show',$testimonial->id) }}">
										<i class="fa fa-eye"></i>
									</a> 
									@can('testimonial-edit')	
									<a class="icons edit-icon" href="{{ route('testimonials.edit',$testimonial->id) }}">
										<i class="fa fa-edit"></i>
									</a>
									@endcan
									@can('testimonial-delete')							
									{!! Form::open(['method' => 'DELETE','route' => ['testimonials.destroy', $testimonial->id],'style'=>'display:inline']) !!}
										<a class="icons edit-icon tag_delete" href="#" id="{{$testimonial->id}}" onclick="deleteTestimonial({{$testimonial->id}})">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
										<button type="submit" class="btn btn-danger btn_delete{{$testimonial->id}}" style="display:none;">Delete</button>
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
    	$('#testimonialList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',

			
		});
	});
	
	function deleteTestimonial(e){
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
<style>
table.table thead th, table.table tbody td {
    line-break: anywhere !important;
}
	</style>
@endsection


	