@extends('layouts.app')

@section('title', "clearHealth | Testimonials")
@section('content')
<div class="app-content content">

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">Testimonials</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active"> Show Testimonial</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
               <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('testimonials.index') }}"> Back</a>
        </div>
				</div> 
			</div>

	<div class="content-body">
		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
			    <section class="card">           
			        <div class="card-body">
				        <div class="form-group">
				            <strong>Name:</strong>
				            {{ $testimonial->name }}
				        </div>				        
				        <div class="form-group">
				            <strong>Content:</strong>
				            {{ $testimonial->content }}
				        </div> 
				        <div class="form-group">
				            <strong>Image:</strong>
				            @if(!empty($testimonial->image))
				            <img src="{{ asset('public/images/Testimonials/'.$testimonial->image) }}" alt="Testimonial Image" title="Testimonial Image" width="200px">
				            @else
				            No Image
				            @endif
				        </div>          
			    	</div>       
				</section>
		    </div>   
		</div>
	</div>
</div>
@endsection