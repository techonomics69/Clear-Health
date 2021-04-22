@extends('layouts.app')

@section('title', 'clearHealth | Questions')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div class="app-content content">
@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif

<style type="text/css">
	#question-tab-menu li a.active{
		background-color: #43bfc1;
		color: #ffffff;
	}	
</style>

@if(session()->has('que_current_tab'))
 @php
    $current_tab_id = 'home'.session()->get('que_current_tab') ;
    $activeTab = 1;
    $active = 1 ;
   
   // unset($products[$key]);
    @endphp
 @else
 @php
 $current_tab_id = "";
 $activeTab = 0 ;
 $active = 0 ;	
 @endphp
@endif

@php
 Session::forget('que_current_tab');
@endphp

<div class="content-wrapper">
	<div class="content-header row">
				<div class="content-header-left col-md-6 col-12 mb-2">
					<h3 class="content-header-title mb-0">Question</h3>
					<div class="row breadcrumbs-top">
							<div class="breadcrumb-wrapper col-12 d-flex">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item active">All</li>
								</ol>
							</div>
					</div>
				</div>
				<div class="content-header-right col-md-6 col-12 mb-2">
						<div class="pull-right">
						@can('quiz-create')					
							<a class="btn btn-secondry" href="{{ route('quiz.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Question</a>
						@endcan	
						</div>
				</div>
			</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="card" >
					<ul class="nav nav-tabs" id="question-tab-menu">
					
					@foreach($category as $key => $data)
					  {{-- <li><a class="btn @if($activeTab == 0) active @elseif($current_tab_id == 'home'.$key) active @endif" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li> --}}

					   <li><a class="btn @if($current_tab_id == 'home'.$key ) active @elseif($activeTab == 0) active @endif" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li>
					 <?php $activeTab++ ?> 
					 @endforeach
					</ul>
					<div class="tab-content">
						@foreach($quiz as $key => $que)
					  <div id="home{{$key}}" class="tab-pane fade in @if($current_tab_id == 'home'.$key) active show @elseif($active == 0) active show @endif">					    
						@foreach($que as $key => $loopdata)	
						<div class="row" style="padding: 20px;">
							<div class="col-md-12">
								<table class="table table-responsive-md table-striped table-bordered quizList" style="width:100%">
									<thead>
										<tr>
											<th width="60px">No</th>
											<th>Name</th>
											<th>Order</th>
											<th width="200px">Action</th>
										</tr>
										</thead>
										<tbody>		

											@foreach ($loopdata as $key => $data)
											<tr>
												<td>{{ ++$i }}</td>
												<td>{{ $data->question }}</td>

												<!-- <input type="hidden" id="{{ $data->id }}" value="{{ $data->order }}" class="orderval">  -->
												<td><input type="text" id="{{ $data->id }}" value="{{ $data->order}}" class="order"/></td>												
												<td>
												<div class="d-flex">
													<a class="icons edit-icon" href="{{ route('quiz.show',$data->id) }}">
														<i class="fa fa-eye"></i>
													</a>		
													@can('quiz-edit')					 
													<a class="icons edit-icon" href="{{ route('quiz.edit',$data->id) }}">
														<i class="fa fa-edit"></i>
													</a>
													@endcan
													<!-- @can('quiz-delete')							
													{!! Form::open(['method' => 'DELETE','route' => ['quiz.destroy', $data->id],'style'=>'display:inline']) !!}
														<a class="icons edit-icon quiz_delete" href="#" id="{{$data->id}}" onclick="deleteQuiz({{$data->id}})">
															<i class="fa fa-trash" aria-hidden="true"></i>
														</a>
														<button type="submit" class="btn btn-danger btn_delete{{$data->id}}" style="display:none;">Delete</button>
													{!! Form::close() !!}
													@endcan	 -->
					                            </div>						
												</td>
											</tr>

											@endforeach
										@endforeach

										</tbody>
									</table>
								</div>
								 <div class="col-md-6 col-sm-6 col-xs-12">
								<div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <a href="{{ route('quiz.index') }}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </a>
                    			<button type="button" class="btn btn-secondry" data-dismiss="modal" id="form{{$active+1}}">Submit</button>
                        </div>
							</div>
</div>
					  </div>  

					  	<?php $active++ ?>
					  	@endforeach

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
    	$('.quizList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"oSearch": { "bSmart": false, "bRegex": true }
		});
	});
	
	/*function deleteQuiz(e){
       swal({
        title: "Are you sure want to delete?",
        text: "If you delete this Quiz, it's not recoverable ",
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
	};*/


$(document).ready(function(){
	$('#form1').click(function(e){
		var ids = [];
		$(".order").each(function(){
		ids[$(this).attr('id')] = $(this).val();
  	});
	json = Object.assign({}, ids);
	//console.log(json);
	$.ajax({ 
        	type:"POST",         
        	url:"{{ route('orderUpdate.update') }}",
        	data:{
        	"_token": "{{ csrf_token() }}",
        	"id": json
        	}, 
        	success: function(response){
           	toastr.success('Order Updated');
      	}
    	});
		});
	});
</script>
@endsection


	