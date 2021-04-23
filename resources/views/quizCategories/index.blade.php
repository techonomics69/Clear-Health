@extends('layouts.app')

@section('title', 'clearHealth | QuestionCategories')
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
					<h3 class="content-header-title mb-0">Question Categories</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active">Question Categories List</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
						<div class="pull-right">
						@can('quizCategory-create')					
							<a class="btn btn-secondry" href="{{ route('quizCategory.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Question Category</a>
						@endcan	
						</div>
				</div>
			</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="card" >

					<!-- <div class="col-lg-12 margin-tb card-header ">
						<div class="pull-left">
							<h2 class="main-title-heading">Categories</h2>
						</div>
						<div class="pull-right">					
							<a class="btn btn-secondry" href="{{ route('categories.create') }}">&plus; Create New Category</a>
						</div>
					</div>  -->
					
					<!-- <div class="card-body progress-card">
						<div class="task-progress">
							<input class="form-control input-small" type="" name="search" />
						</div>
					</div> -->
					<div class="row" style="padding: 20px;">
						<div class="col-md-12">
					<table class="table table-responsive-md table-striped table-bordered " style="width:100%" id="quizCategoriesList">
						<thead>
						<tr>
							<th width="60px">No</th>
							<th>Name</th>
							<th width="200px">Action</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($categories as $key => $category)
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $category->name }}</td>
							<td>
							<div class="d-flex">
								<!-- <a class="icons edit-icon" href="{{ route('categories.show',$category->id) }}">
									<i class="fa fa-eye"></i>
								</a> -->		
								@can('quizCategory-edit')					 
								<a class="icons edit-icon" href="{{ route('quizCategory.edit',$category->id) }}">
									<i class="fa fa-edit"></i>
								</a>
								@endcan
								@can('quizCategory-delete')							
								{!! Form::open(['method' => 'DELETE','route' => ['quizCategory.destroy', $category->id],'style'=>'display:inline']) !!}
									<a class="icons edit-icon quizCategory_delete" href="#" id="{{$category->id}}" onclick="deleteQuizCategory({{$category->id}})">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</a>
									<button type="submit" class="btn btn-danger btn_delete{{$category->id}}" style="display:none;">Delete</button>
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
</div>
@endsection

@section('scriptsection')
  
<script>
	$.noConflict();
	jQuery( document ).ready(function( $ ) {
    	$('#quizCategoriesList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"oSearch": { "bSmart": false, "bRegex": true }
		});
	});
	
	function deleteQuizCategory(e){
       swal({
        title: "Are you sure want to delete?",
        text: "If you delete this Quiz Category, it's also delete all Quiz releated to this category ",
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


	