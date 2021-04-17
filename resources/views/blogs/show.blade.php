@extends('layouts.app')

@section('title', 'clearHealth | Blogs')
@section('content')
<div class="app-content content">

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">Blogs</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active"> Show Blog</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
               <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('blog.index') }}"> Back</a>
        </div>
				</div> 
			</div>

	<div class="content-body">
		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
			    <section class="card">           
			        <div class="card-body">
				        <div class="form-group">
				            <strong>Title:</strong>
				            {{ $blog->title }}
				        </div>
				        <div class="form-group">
				            <strong>Body:</strong>
				            {!! $blog->body !!}
				        </div>
				        <div class="form-group">
				            <strong>Tags:</strong>
				            @foreach(explode(",",$blog->tags) as $tag)
				            	@foreach($tags as $key => $data)            	
				            		@if($tag == $key)
				            			<span class="badge badge-info">{{$data}}</span>
				            		@endif				            		
				            	@endforeach				            
				            @endforeach
				        </div>
				        <div class="form-group">
				            <strong>Created At:</strong>
				            {{ date('d/m/Y', strtotime($blog->created_at))  }}
				        </div> 
				        <div class="form-group">
				            <strong>Image:</strong>
				            <?php
				            	if(strrpos($blog->image,"," )!==false){
				            		$image = explode(",", $blog->image);
				            		if(count($image)>0){
				            			foreach ($image as $key => $value) {
				           	?>
				           	<img src="{{ asset('public/images/Blogs/'.$value) }}" alt="Blog Image" title="Product Image" width="200px">
				           	<?php
				            			}
				            		}
				            	}else{
				            ?>
				            <img src="{{ asset('public/images/Blogs/'.$blog->image) }}" alt="Blog Image" title="Product Image" width="200px">            
				            <?php		
				            	}
				            ?>
				            
				        </div>       
			    	</div>       
				</section>
		    </div>   
		</div>
	</div>
</div>
@endsection