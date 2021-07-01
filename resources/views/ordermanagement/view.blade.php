@extends('layouts.app')

@section('title', 'clearHealth | Order Management')
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
							<!-- <li class="breadcrumb-item active">List</li> -->
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
				

				@foreach ($order_non_prescribed as $key => $order_data)
				@endforeach 
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
															<strong>First Name : </strong>
															{{$order_data->first_name}}
														</div>

														<div class="col-md-6 form-group">
															<strong>Last Name : </strong>
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
															{{($order_data->created_at)->format('d/m/Y')}}
														</div>

														<div class="col-md-6 form-group">
															<strong>Shipping Fees : </strong>
															$ {{$order_data->shipping_fee}}
														</div>
														<?php
																if(isset($order_data['gift_code_discount']) && $order_data['gift_code_discount']!="" || $order_data['gift_code_discount']!=null){
															?>
															<div class="col-md-6  form-group">
																<strong>Discount :</strong>
																<?php if(isset($order_data['gift_code_discount']) && $order_data['gift_code_discount'] != '')  { ?>
																	$ {{$order_data['gift_code_discount']}} 
																<?php } ?>
															</div>
															<?php		
																}
															?>

														<div class="col-md-6 form-group">
															<strong>Total Order Amount : </strong>
															$ {{$order_data->total_amount}}
														</div>

													</div>
												</div>
											</section>
										</div>
									</div>
								</div> 
								<!-- End 2nd tab-->

								<!--start 3nd tab-->
		<div id="shipments_shipping_details" class="tab-pane fade in">
			<div class="row" style="padding: 20px;">
				<div class="col-md-12">
					<section class="card">
						<div class="card-body">
							<div class="box-block mtb32">
								<h3 class="font-weight-bold"><span class="text-underline">Shipments Shipping Details</span></h3>
								
								<?php
									if($order_data->shipstation!=''){
										$shipStationOrder = json_decode(json_encode($order_data->shipstation), true);
								?>
								<div class="col-md-6  form-group">
									<strong>Shipstation OrderId : </strong>
									<?php echo $shipStationOrder['orderId'] ?>
								</div>
								<div class="col-md-6  form-group">
									<strong>Order Number : </strong>
									<?php echo $shipStationOrder['orderNumber'] ?>
								</div>
								<div class="col-md-6  form-group">
									<strong>Order Date : </strong>
									<?php echo date("d-m-Y",strtotime($shipStationOrder['orderDate'])); ?>
								</div>
								<div class="col-md-6  form-group">
									<strong>Order Status : </strong>
									<?php echo $shipStationOrder['orderStatus']; ?>
								</div>
								<?php
									if($shipStationOrder['shipByDate']!=''){
								?>
								<div class="col-md-6  form-group">
									<strong>Estimated ship date : </strong>
									<?php echo date("d-m-Y",strtotime($shipStationOrder['shipByDate'])); ?>
								</div>	
								<?php			
									}
									if($shipStationOrder['orderStatus'] == 'shipped'){
										$tracking = json_decode(json_encode($order_data->shipments), true);
								?>
								<div class="col-md-6  form-group">
									<strong> Tracking No: </strong>
									<a href="https://tools.usps.com/go/TrackConfirmAction.action?tLabels=<?php echo $tracking['shipments'][0]['trackingNumber']; ?>" target="_blank"><?php echo $tracking['shipments'][0]['trackingNumber']; ?></a>
								</div>
								<?php
										}
									}
								?>
								

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

		</script>


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


