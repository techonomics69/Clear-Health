@extends('layouts.app')


@section('content')

<div class="app-content content">
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="content-wrapper">
<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Categories</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active">Edit categories</li>
							</ol>
						</div>
				</div>
			</div>
			 <div class="content-header-right col-md-6 col-12 mb-2">
				<div class="pull-right">
					<a class="btn btn-secondry " href="{{ route('categories.index') }}"> Back</a>
				</div>
			</div> 
</div>



        <div class="content-body">
	<div class="row">
	    <div class="col-lg-12">
	        <section class="card">
				<div class="card-body">
					{!! Form::model($category, ['method' => 'PATCH','route' => ['categories.update', $category->id], 'enctype'=>"multipart/form-data"]) !!}
					<div class="row">
						 <div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<label>Name</label><span class="required">*</span>
								{!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
							</div>
							<div class="form-group">
								<label>Image</label><span class="required">*</span>
								{!! Form::file('image', null, array('class' => 'form-control')) !!}
							</div>
							<div class="form-group">
								<label>Order</label><span class="required">*</span>
								{!! Form::number('order', null, array('placeholder' => 'Order','class' => 'form-control')) !!}
							</div>
						</div> 
						<div class="col-xs-12 col-sm-12 col-md-12 text-right">
		                    <a href="{{ route('categories.index') }}">
		                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                    </a>
		                    <button type="submit" class="btn btn-secondry" data-dismiss="modal">Submit</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
	        </section>
	    </div>
	</div>
	</div>
	</div>
</div>

@endsection
