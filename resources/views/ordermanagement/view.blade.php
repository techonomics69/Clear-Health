@extends('layouts.app')

@section('title', 'clearHealth | Ipledge')
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


	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Order Management</h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12 d-flex">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">List</li>
							<li class="breadcrumb-item active"><a href="{{route('ordermanagement.index')}}">Order Management List</a></li>
						</ol>
					</div>
				</div>
			</div>
				 <!-- <div class="content-header-right col-md-6 col-12 mb-2">
						<div class="pull-right">
						@can('quiz-create')					
							<a class="btn btn-secondry" href="{{ route('ipledgeimports.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Case Management </a>
						@endcan	
						</div>
					</div> --> 
				</div>
				
				<?php 
				/*foreach($order_non_prescribed as $key=>$val){
				echo "<br><br>$key=>$val<br><br>";
					echo $val['medication_type'];
				}
				echo "<pre>";
				print_r($order_non_prescribed);
				echo $order_non_prescribed->medication_type;
				echo "<pre>";
				die(); 
				 if($order_non_prescribed['medication_type'] == 2) {*/ ?>

@foreach ($order_non_prescribed as $key => $order_data)

<?php $medication_type=$order_data->medication_type; ?>

@endforeach

<?php 
if($medication_type == 2 ) { ?>
					<div class="row">
						<div class="col-lg-12">
							<section class="card" >
								<ul class="nav nav-tabs" id="casemanagement-tab-menu">
									<li><a class="btn active " data-toggle="tab" href="#profile">Profile</a></li>
									<li><a class="btn" data-toggle="tab" href="#order_summary">Order Summary</a></li>
									<li><a class="btn" data-toggle="tab" href="#shipments_shipping_details">Shipments & shipping details</a></li>
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
																<strong>FirstName : </strong>
																{{$order_data->first_name}}
															</div>

															<div class="col-md-6 form-group">
																<strong>LastName : </strong>
																{{$order_data->last_name}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Email : </strong>
																{{$order_data->email}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Phone no : </strong>
																{{$order_data->mobile}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Address : </strong>
																{{$order_data->addressline1.','}}
																{{$order_data->addressline2.','}}
																{{$order_data->city.','}}
																{{$order_data->state.','}}
																{{$order_data->zipcode}}
															</div>
															
														</div>
													</div>
												</section>
											</div>
										</div>
									</div> 
									<!--End 1st tab--> 
									<!--start 2nd tab-->
									<div id="order_summary" class="tab-pane fade in">
										<div class="row" style="padding: 20px;">
											<div class="col-md-12">
												<section class="card">
													<div class="card-body">
														<div class="box-block mtb32">
															<h3 class="font-weight-bold"><span class="text-underline">Order Summary</span></h3>
															
															<div class="col-md-6  form-group">
																<strong>Product Name : </strong>
																{{$order_data->product_name}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Product Type : </strong>
																<?php if($order_data->medication_type == 1){
																	echo "Prescribed";
																}else{
																	echo "Non Prescribed";
																} ?>
															</div>

															<div class="col-md-6 form-group">
																<strong>Quantity : </strong>
																{{$order_data->quantity}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Date : </strong>
																{{$order_data->created_at}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Shipping Fees : </strong>
																{{$order_data->shipping_fee}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Total Order Amount : </strong>
																{{$order_data->total_amount}}
															</div>
															
														</div>
													</div>
												</section>
											</div>
										</div>
									</div> 
									<!-- End 2nd tab-->
								</div>
							</section>
						</div>
					</div>

				<?php } else { ?> 
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
																<strong>FirstName : </strong>
																{{$user_case_management_data['first_name']}}
															</div>

															<div class="col-md-6 form-group">
																<strong>LastName : </strong>
																{{$user_case_management_data['last_name']}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Email : </strong>
																{{$user_case_management_data['email']}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Mobile : </strong>
																{{$user_case_management_data['mobile']}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Gender : </strong>
																{{$user_case_management_data['address']}}
															</div>

															<div class="col-md-6 form-group">
																<strong>Physician Details : </strong>
																{{$user_case_management_data['pharmacy']}}
															</div>

														</div>
													</div>
												</section>
											</div>
										</div>
									</div> 
									<!--End 1st tab-->

									  <!-- @if(session()->has('que_current_tab'))

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
 @endif -->

 @php
 Session::forget('que_current_tab');
 @endphp
 <!-- Start 2nd tab-->
 <div id="questionaire" class="tab-pane fade in">					    

 	<div class="row" style="padding: 10px;">
 		<div class="col-md-12">
 			<section class="card" >
 				<ul class="nav nav-tabs" id="question-tab-menu">

 					@foreach($category as $key => $data)
 					{{-- <li><a class="btn @if($activeTab == 0) active @elseif($current_tab_id == 'home'.$key) active @endif" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li> --}}

 					<li><a class="btn" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li>
 					<?php //$activeTab++ ?> 
 					@endforeach
 				</ul>
 				<div class="tab-content">
 					<?php $i=0 ?>
 					@foreach($category as $key => $data)
 					<div id="home{{$key}}" class="tab-pane fade in @if($i== 0) active show @endif">					    
 						@foreach($quiz as $key1 => $que)
 						<div class="row" style="padding: 10px;">
 							<div class="col-md-12">
 								<?php 
 								if($que['category_id']== $key){

 									echo "<h4><strong>Que:".$que['question']."</strong></h4>";
 									echo "<p>Ans:".$que['answer']."</p>";
 								}
 								?>

 							</div>
 						</div>
 						<?php $i++ ?>
 						@endforeach
 					</div> 
 					@endforeach 
 					

 				</div>
 			</section>
 		</div>
 	</div>
 </div>  
 

</div>
</section>
</div>
</div>
<?php } ?>
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


