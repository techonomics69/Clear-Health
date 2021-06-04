@extends('layouts.app')

@section('title', 'clearHealth | CMS')
@section('content')
<div class="app-content content">

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">Treatment Guides</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active"> Show Treatment Guides</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
               <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('cms.index') }}"> Back</a>
        </div>
				</div> 
			</div>

<!-- <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Show CMS Page</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div>
</div> -->


<div class="content-body">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
    <section class="card">
           
                <div class="card-body">
        <div class="form-group">
            <strong>Title:</strong>
            {{ $treatmentGuides->title }}
        </div>
        <div class="form-group">
            <strong>Sub Title:</strong>
            {{ $treatmentGuides->sub_title }}
        </div>
       <div class="form-group">
            <strong>Status:</strong>
            @if($treatmentGuides->status == 1)
                <span class="badge badge-success">Active</span>
            @else
                <span class="badge badge-danger">In Active</span>
            @endif
        </div> 
        <div class="form-group">
            <strong>Description:</strong>
            {!! $treatmentGuides->detail !!}
        </div>
    
        <div class="form-group">
            <strong>Image:</strong>
            <img src="{{ asset('public/images/TreatmentGuides/'.$treatmentGuides->guides_image) }}" alt="Guides Image" title="Guides Image" width="200px">            
        </div>     
    </div>  
    </div> 
</section>
    </div>   
</div>
</div>
</div>
@endsection