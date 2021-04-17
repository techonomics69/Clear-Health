@extends('layouts.app')

@section('title', "clearHealth | Tags")
@section('content')
<div class="app-content content">

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">Tags</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active"> Show Tag</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
               <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('tags.index') }}"> Back</a>
        </div>
				</div> 
			</div>

	<div class="content-body">
		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
			    <section class="card">           
			        <div class="card-body">
				        <div class="form-group">
				            <strong>Tag:</strong>
				            {{ $tag->tag }}
				        </div>				        
				        <div class="form-group">
				            <strong>Status:</strong>
				            @if($tag->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">In-active</span> 
                            @endif 
				        </div>        
			    	</div>       
				</section>
		    </div>   
		</div>
	</div>
</div>
@endsection