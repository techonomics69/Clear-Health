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
							<li class="breadcrumb-item active">All</li>/
							<li class="breadcrumb-item active"><a href="{{ route(ordermanagement.index)}}">Order Management List</a></li>
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
								<li><a class="btn" data-toggle="tab" href="#order_summary">Order Summary</a></li>
								<li><a class="btn" data-toggle="tab" href="#shipments_shipping_details">Shipments & shipping details</a></li>
							</ul>
							<div class="tab-content">

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
														<strong> I pledge ID: </strong>
														#111111
														
													</div>
													</div>


													<div class="box-block mtb32">
													<h3 class="font-weight-bold"><span class="text-underline"> Physician details</span></h3>
													<div class="col-md-6 form-group">
														<strong> MD Name: </strong>
														XYZ
														
													</div>
													<div class="col-md-6 form-group">
														<strong> MD Email: </strong>
														XYZ
														
													</div>
													<div class="col-md-6 form-group">
														<strong> MD Contact No: </strong>
														1234567891
														
													</div>

													</div>


													<div class="box-block mtb32">
													<h3 class="font-weight-bold"><span class="text-underline"> Pharmacy details</span></h3>
													<div class="col-md-6 form-group">
														<strong> Pharmacy: </strong>
														xyz
														
													</div>
				                                     </div>

				                                     <?php
				                                     if($user_case_management_data['product_type'] == "accutane"){
				                                     ?>
													 <div class="box-block mtb32">
													<h3 class="font-weight-bold"><span class="text-underline"> Action Items</span></h3>

													@if (count($errors) > 0)
													<div class="alert alert-danger">
														<strong>Whoops!</strong> There were some problems with your input.<br><br>
														<ul>
															@foreach ($errors->all() as $error)
															<li>{{ $error }}</li>
															@endforeach
														</ul>
													</div>
													@endif

													<div class="col-md-12 form-group" id="testreoprtdiv">
														<div class="inner-section">
															<div class="row">
																<div class="col-lg-2 col-xl-2 col-md-12">
																<strong> Pregnancy Test: </strong>
																</div>

																<div class="col-lg-6 col-xl-6 col-md-12">
																 {!! Form::open(array('route' => 'upload_pregnancy_test_report','method'=>'POST','enctype'=>"multipart/form-data",'id'=>'p_test_form')) !!}
																
																<span>

																	<input type="file" name="pregnancy_test" class="btn btn-secondry pregnecyrepot" value="Upload Report" >

																	<input type="hidden" name="case_id" value="{{$user_case_management_data['id']}}">
																
																<input type="submit" name="submit_test_report" class="btn btn-secondry" id="uploadBtn_pregnancy_test"></sapn>
																
																
																{!! Form::close() !!}
																</div>
															
															<div class="col-lg-4 col-xl-4 col-md-12">
																<div class="img-border">
															<?php 
				                                    			if($user_case_management_data['pregnancy_test'] != ''){ 
				                                    					$path_info = pathinfo($user_case_management_data['pregnancy_test']);

																		$file_type = $path_info['extension'];

																		if($file_type == 'pdf'){
																				echo "<span><strong>".$user_case_management_data['pregnancy_test']."</strong></span>";
																		}else{
																			?>
																				<img src="{{ asset('public//ipledgeimports/pregnancy_test/'.$user_case_management_data['pregnancy_test']) }}" alt="{{$user_case_management_data['pregnancy_test'] }}">
																		<?php }

				                                    					
				                                    			 }	
				                                    		?>
															</div>
															</div>
														</div>
														</div>
													</div>
														
													<div class="col-md-12 form-group mtb32">
													<div class="inner-section">
													<div class="row">
																<div class="col-lg-2 col-xl-2 col-md-12">
														<strong> Blood-work: </strong>
														</div>
														<div class="col-lg-6 col-xl-6 col-md-12">
														 {!! Form::open(array('route' => 'upload_blood_work_test_report','method'=>'POST','enctype'=>"multipart/form-data",'id'=>'p_test_form')) !!}
													
														<span>

															<input type="file" name="blood_work" class="btn btn-secondry pregnecyrepot" value="Upload Blood Work" >

																	
															<input type="hidden" name="case_id" value="{{$user_case_management_data['id']}}">

															<input type="submit" name="submit_blood_report" class="btn btn-secondry" id="uploadBtn_blood_test"></span>
															{!! Form::close() !!}
														</div>
														
														<div class="col-lg-4 col-xl-4 col-md-12">
																 <div class="pdfblock">

													<?php 
				                                    	if($user_case_management_data['blood_work'] != ''){ 
				                                    					$path_info1 = pathinfo($user_case_management_data['blood_work']);

																		$file_type1 = $path_info1['extension'];

																		if($file_type1 == 'pdf'){
																			echo "<span><strong>".$user_case_management_data['blood_work']."</strong></span>";

																		}else{
																			?>
																				<img src="{{ asset('public//ipledgeimports/blood_work/'.$user_case_management_data['blood_work']) }}" alt="{{$user_case_management_data['blood_work'] }}" width="500" height="600">
																		<?php }

																			

				                                    					
				                                    			 }

				                                    		?>
													</div>
																</div>
													</div>
													</div>
													<div class="row">
													<div class="col-md-12 form-group mtb32">
													<div class="inner-section">
														<div class="row">
																	<div class="col-lg-2 col-xl-2 col-md-12">
																		<strong> I Pledge Agreement: </strong>
																	</div>
																	<div class="col-lg-6 col-xl-6 col-md-12">
																<?php 
																	if($user_case_management_data['i_pledge_agreement'] == 'verified'){ ?>
																			<input type="text" name="i_pledge_agreement" class="btn btn-secondry" value="Verified" id="i_pledge_agreement" disabled="true">
																	<?php }else{	
																?>
																{!! Form::open(array('route' => 'i_pledge_agreement','method'=>'POST','enctype'=>"multipart/form-data",'id'=>'i_pledge_agreement_form')) !!}
																
																	<span>
																		<input type="text" name="i_pledge_agreement" class="btn btn-secondry" value="Verify" id="i_pledge_agreement" >

																			
																	<input type="hidden" name="case_id" value="{{$user_case_management_data['id']}}">

																	<input type="submit" name="submit_i_pledge_agreement" class="btn btn-secondry" id="submit_i_pledge_agreement" style="display: none;">
																	</span>
																	
																	{!! Form::close() !!}
																	<?php } ?>
																
																	</div>
														</div>
													</div>
													</div>
													</div>
													<?php } ?>


													<!-- <h3 class="font-weight-bold"><span class="text-underline"> Images Uploaded</span></h3> -->




												</div>
											</section>
											{{-- <table class="table table-responsive-md table-striped table-bordered c_profile" style="width:100%">
												<thead>
													<tr>
														<th>User First Name</th>
														<th>User Last Name</th>
														<th>User Email</th>
														<th>I pledge ID</th>
														<th>MD Name</th>
														<th>MD Email</th>
														<th>MD Contact No.</th>
														<th>Pharmacy details</th>
														<th>Action Items</th>
														<th>Images Uploaded</th>
													</tr>
												</thead>
												<tbody>					
													
													<tr>
														<td>{{$user_case_management_data['first_name']}}</td>
														<td>{{$user_case_management_data['last_name']}}</td>
														<td>{{$user_case_management_data['email']}}</td>
														<td> - </td>
														<td> - </td>
														<td> - </td>
														<td> - </td>
														<td> curexa </td>
														<td> Pregnancy-Test/Blood-work/I-Pledge-Agreement</td>
														<td> - </td>
													</tr>

												</tbody>
											</table> --}}
										</div>
									</div>
								</div>  


								<!--start code tab2-->


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
 @endif --}}

 @php
 Session::forget('que_current_tab');
 @endphp
 <div id="questionaire" class="tab-pane fade in">					    
 	{{-- 	@foreach($que as $key => $loopdata)	 --}}
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

 {{-- @endforeach --}}

 <!--end code tab2-->

 <!--tab3-->
 <div id="order_summary" class="tab-pane fade in">
 	<div class="row" style="padding: 10px;">
 		<div class="col-md-12">
 			order summary goes here
									{{-- <table class="table table-responsive-md table-striped table-bordered ipledgeList" style="width:100%">
										<thead>
											<tr>
												<th width="60px">No3</th>
												<th>Name</th>
												<th width="200px">Action</th>
											</tr>
										</thead>
										<tbody>					
											@foreach ($loopdata as $key => $data)
											<tr>
												<td>{{ ++$i }}</td>
												<td>{{ $data->question }}</td>
												<td> </td>
											</tr>
											@endforeach
											@endforeach
										</tbody>
									</table> --}}
								</div>
							</div>
						</div> 


						<!--end of tab3-->

						<!--tab4-->
						<div id="rx" class="tab-pane fade in ">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									rx details goes here
								</div>
							</div>
						</div> 


						<!--end of tab4-->
						<!--tab5-->
						<div id="messages" class="tab-pane fade in ">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">

									messages goes here
								{{-- <table class="table table-responsive-md table-striped table-bordered ipledgeList" style="width:100%">
									<thead>
										<tr>
											<th width="60px">Files</th>
											<th width="60px">Imported By</th>
											<th width="200px">Imported date</th>
										</tr>
									</thead>
									<tbody>					
										@foreach($ipledgehistory_data as $key1 => $data1)
										<tr>
											<td><a class="text-dark" href="{{route('IpledgefileDownload',$data1['id'])}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>  {{$data1['files']}}</a></td>
											<td>{{$data1['imported_by']}}</td>
											<td>{{$data1['crated_at']}}</td>
										</tr>
										@endforeach
									</tbody>
								</table> --}}
							</div>
						</div>
					</div> 
				</div>

				<!--end of tab5-->
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


