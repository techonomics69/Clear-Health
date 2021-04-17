@extends('layouts.app')

@section('title', 'clearHealth | CMS')
@section('content')
<div class="app-content content">

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">CMS</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active"> Show CMS Page</li>
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
            {{ $cms->title }}
        </div>
        <div class="form-group">
            <strong>URL:</strong>
            <a href="{{ $cms->url }}" target="_blank">
            {{ $cms->url }}
            </a> 
        </div>
        <div class="form-group">
            <strong>Meta Title:</strong>
            {{ $cms->meta_title }}
        </div>
        <div class="form-group">
            <strong>Meta Description:</strong>
            {{ $cms->meta_description }}
        </div>
        <div class="form-group">
            <strong>Meta Keywords:</strong>
            {{ $cms->meta_keyword }}
        </div>
        <div class="form-group">
            <strong>Status:</strong>
            @if($cms->status == 1)
                <span class="badge badge-success">On</span>
            @else
                <span class="badge badge-danger">Off</span>
            @endif
        </div>  
        <div class="form-group">
            <strong>Description:</strong>
			<div class="col-lg-12" style="border: 1px solid #43bfc1;">
			{!! $cms->description !!}
			</div>
        </div>      
    </div>  
    </div> 
</section>
    </div>   
</div>
</div>
</div>
@endsection