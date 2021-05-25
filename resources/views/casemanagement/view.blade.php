@extends('layouts.app')

@section('title', 'clearHealth | CaseManegement')
@section('content')

<div class="app-content content">
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif

	<style type="text/css">
		#casemanagement-tab-menu li a.active{
			background-color: #43bfc1;
			color: #ffffff;
		}

	</style>

	{{-- @if(session()->has('que_current_tab'))
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
	@endphp --}}


	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Case Management</h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12 d-flex">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
							<!-- <li class="breadcrumb-item active">List</li> -->
							<li class="breadcrumb-item active"><a href="{{route('casemanagement.index')}}">Case Management List</a></li>
						</ol>
					</div>
				</div>
			</div>
			{{-- <div class="content-header-right col-md-6 col-12 mb-2">
				<div class="pull-right">
					@can('quiz-create')					
					<a class="btn btn-secondry" href="{{ route('ipledgeimports.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Case Management </a>
					@endcan	
				</div>
			</div> --}}
		</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="card" >
					<ul class="nav nav-tabs" id="casemanagement-tab-menu">
						<li><a class="btn active " data-toggle="tab" href="#profile">Profile</a></li>
						<li><a class="btn" data-toggle="tab" href="#questions">Questions</a></li>
						<li><a class="btn" data-toggle="tab" href="#skincare_summary">Skincare Summary </a></li>
						<li><a class="btn" data-toggle="tab" href="#action_items">Action Items </a></li>
						<li><a class="btn" data-toggle="tab" href="#messages">Messages</a></li>
						<li><a class="btn" data-toggle="tab" href="#photos">Photos </a></li>
						<li><a class="btn" data-toggle="tab" href="#payments">Payments </a></li>
					</ul>
					<div class="tab-content">
						<!--start 1st tab-->
						<div id="profile" class="tab-pane fade in active show">					    
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Basic Information</span></h3>
												<div class="col-md-6  form-group">

													<strong>FirstName:</strong>
													{{$user_case_management_data['first_name']}}

												</div>

												<div class="col-md-6 form-group">
													<strong>LastName: </strong>
													{{$user_case_management_data['last_name']}}

												</div>

												<div class="col-md-6 form-group">
													<strong>Email: </strong>
													{{$user_case_management_data['email']}}

												</div>
												<div class="col-md-6 form-group">
													<strong>Mobile No: </strong>
													{{$user_case_management_data['email']}}

												</div>
												<div class="col-md-6 form-group">
													<strong>Gender : </strong>
													{{$user_case_management_data['email']}}

												</div>
												<div class="col-md-6 form-group">
													<strong>Physician Details : </strong>
													{{$user_case_management_data['email']}}

												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>  
						<!--End 1st tab-->

						<!--start 2nd tab-->

						<div id="questions" class="tab-pane fade in">					    
						
							<div class="row" style="padding: 10px;">
								<div class="col-md-12">
<div class="tab-content">
	<div class="row" style="padding: 10px;">
													<div class="col-md-12">


									@foreach($answers as $key => $ans)
									<?php

		$questions = $ans->question;
          if(isset($ans->answer)){
           $answer =  $ans->answer;
          }
?>


									<h4><strong>Que: <?php echo $questions;  ?></strong></h4>
									<p>Ans: <?php echo $answer; ?> </p>
									@endforeach
								</div>
							</div>
						</div>
								</div>
							</div>
							
						</div>  

						

						<!--end 2nd tab-->

						<!--start 3rd tab-->
						<div id="skincare_summary" class="tab-pane fade in">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Skincare Summary</span></h3>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div> 
						<!--end 3rd tab-->

						<!--start 4th tab-->
						<div id="action_items" class="tab-pane fade in ">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Action Items</span></h3>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div> 
						<!--end 4th tab-->

						<!--start 5th tab-->
						<div id="messages" class="tab-pane fade in ">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Messages goes here</span></h3>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
						<!--end 5th tab-->

						<!--start 6th tab-->
						<div id="photos" class="tab-pane fade in ">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Photos</span></h3>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
						<!--end 6th tab-->

						<!--start 7th tab-->
						<div id="payments" class="tab-pane fade in ">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Payments</span></h3>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
						<!--end 7th tab--> 
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
		$('.c_profile').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"oSearch": { "bSmart": false, "bRegex": true },
			"scrollX": true,
		});
	});

	$(document).on('click', '#i_pledge_agreement', function() {
		$('#i_pledge_agreement_form').submit();
	});
</script>


@if (count($errors) > 0)
<script type="text/javascript">
	$('html, body').animate({
		scrollTop: $("#testreoprtdiv").offset().top
	}, 2000);
</script>
@endif

@endsection
<style>
	.tab-content h4{
		font-size:16px;
	}
	.tab-content p{
		font-size:16px;
		margin-bottom:0;
	}
	.inner-section {
		width: 100%;
		
	}
</style>


