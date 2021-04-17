@extends('layouts.app')

@section('title', "clearHealth | FAQ's")
@section('content')
<div class="app-content content">

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">FAQ's</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active"> Show FAQ</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
               <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('faqs.index') }}"> Back</a>
        </div>
				</div> 
			</div>

	<div class="content-body">
		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
			    <section class="card">           
			        <div class="card-body">
				        <div class="form-group">
				            <strong>Question:</strong>
				            {{ $faq->question }}
				        </div>
				        <div class="form-group">
				            <strong>Answer:</strong>
				            {!! $faq->answer !!}
				        </div>
				        <div class="form-group">
				            <strong>Status:</strong>
				            @if($faq->status == 1)
                                <span class="badge badge-success">On</span>
                            @else
                                <span class="badge badge-danger">Off</span> 
                            @endif 
				        </div>        
			    	</div>       
				</section>
		    </div>   
		</div>
	</div>
</div>
@endsection