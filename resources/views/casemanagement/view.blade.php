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
	<style type="text/css">
		#messages-tab-menu li a.active{
			background-color: #43bfc1;
			color: #ffffff;
		}

	</style>
	@php
	$msg_tab = 0;
	@endphp
	@if(Session()->has('message'))
	@php
	$message_data = json_decode(Session()->get('message'));
	$msg_tab=$message_data->show_non_medical_screen;
	//print_r($msg_tab);
	@endphp
	@endif

	@php
	Session::forget('message');
	@endphp




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
						<li><a class="btn @if($msg_tab != 1) active @endif " data-toggle="tab" href="#profile">Profile</a></li>
						<li><a class="btn" data-toggle="tab" href="#questions">Questions</a></li>
						<li><a class="btn" data-toggle="tab" href="#skincare_summary">Skincare Summary </a></li>
						<li><a class="btn" data-toggle="tab" href="#action_items">Action Items </a></li>
						<li><a class="btn @if($msg_tab == 1) active @endif" data-toggle="tab" href="#messages">Messages</a></li>

						<li><a class="btn" data-toggle="tab" href="#photos">Photos </a></li>
						<li><a class="btn" data-toggle="tab" href="#payments">Payments </a></li>
					</ul>
					<div class="tab-content">
						<!--start 1st tab-->
						<div id="profile" class="tab-pane fade in  @if($msg_tab != 1) active show @endif">					    
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<section class="card">
										<div class="card-body">
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Basic Information</span></h3>
												<div class="col-md-6  form-group">

													<strong>First Name:</strong>
													{{$user_case_management_data['first_name']}}

												</div>

												<div class="col-md-6 form-group">
													<strong>Last Name: </strong>
													{{$user_case_management_data['last_name']}}

												</div>

												<div class="col-md-6 form-group">
													<strong>Email: </strong>
													{{$user_case_management_data['email']}}

												</div>
												<div class="col-md-6 form-group">
													<strong>Mobile No: </strong>
													{{$user_case_management_data['mobile']}}

												</div>
												<div class="col-md-6 form-group">
													<strong>Gender : </strong>
													

												</div>
												<div class="col-md-6 form-group">
													<strong>Physician Details : </strong>
													

												</div>
											</div>

										</div>
									</section>
								</div>
							</div>
						</div>  
						<!--End 1st tab-->

						<!--start 2nd tab-->
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
						<div id="questions" class="tab-pane fade in">					    

							<div class="row" style="padding: 10px;">
								<div class="col-md-12">

									<section class="card" >
										<ul class="nav nav-tabs" id="questions-tab-menu">

											@foreach($category as $key => $data)
											{{-- <li><a class="btn @if($activeTab == 0) active @elseif($current_tab_id == 'home'.$key) active @endif" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li> --}}

											<li><a class="btn" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li>
											<?php //$activeTab++ ?> 
											@endforeach
										</ul>

										<div class="tab-content">
											<?php $i=0 ?>
											@foreach($category as $key => $data)

											<?php if($key == 7) { ?>
												<?php $j = 0; ?>
												<div id="home7" class="tab-pane fade in @if($i== 0) active show @endif">	
													@foreach($general_que as $key => $general)
													<div class="row" style="padding: 10px;">
														<div class="col-md-12">
															
															<?php 
															if(isset($general->question) && $general->question == 'Hey there! First, we need to know your legal name.')
															{ 
																?>
																<h4><strong>Que <?php echo ++$j; ?> : 
																	<?php 
																	echo $general->question; ?></strong></h4>

																	<p>Ans: <?php 
																	$first_name = $general->answer = $user_case_management_data->first_name;
																	$last_name =  $general->answer = $user_case_management_data->last_name;
																	echo $first_name. " " .$last_name;

																}else{ ?>
																	<h4><strong>Que <?php echo ++$j; ?> : <?php echo $general->question; ?></strong></h4>

																	<p>Ans: <?php if(isset($general->answer)){
																		$answer =  (array)$general->answer;
																		$getanswer= implode(" " ,$answer);
																		echo $getanswer;
																	} ?>
																	<?php 
																}
																?> 
															</div>
														</div>
														@endforeach
													</div>
												<?php } ?>

												<?php if($key == 8) { ?>
													<?php $j = 0; ?>
													<div id="home8" class="tab-pane fade in">	
														@foreach($accutane_que as $key => $accutane)
														<div class="row" style="padding: 10px;">
															<div class="col-md-12">
																<?php 
															/*$getquestions = $accutane->question;
															if(isset($accutane->answer)){
																$answer =  (array)$accutane->answer;
																$getanswer= implode(" " , $answer);
															}*/ 
															?>
															<h4><strong>Que  <?php echo ++$j;?> : <?php echo $accutane->question; ?></strong></h4>
															<p>Ans: 
																<?php if(isset($accutane->answer)){
																	$answer =  (array)$accutane->answer;
																	$getanswer= implode(" " ,$answer);
																	echo $getanswer;
																} ?> 
															</div>
														</div>
														@endforeach
													</div>
												<?php } ?>

												<?php if($key == 9) { ?>
													<?php $j = 0; ?>
													<div id="home9" class="tab-pane fade in">	
														@foreach($topical_que as $key => $topical)
														<div class="row" style="padding: 10px;">
															<div class="col-md-12">
																<?php 
															/*$getquestions = $topical->question;
															if(isset($topical->answer)){
																$answer =  (array)$topical->answer;
																$getanswer= implode(" " , $answer);
															}*/ 
															?>
															<h4><strong>Que  <?php echo ++$j;?> : <?php echo $topical->question; ?></strong></h4>
															<p>Ans: <?php if(isset($topical->answer)){
																$answer =  (array)$topical->answer;
																$getanswer= implode(" " ,$answer);
																echo $getanswer;
															} ?>
														</div>
													</div>
													@endforeach
												</div>
											<?php } ?>

											
											@endforeach
											<?php $i++ ?>
										</div>
									</section>
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
												<div class="col-md-6  form-group">
													<strong>Order ID :</strong>


													<?php if(isset($skincare_summary['order_id']) && $skincare_summary['order_id'] != '')    
													{ ?>
														{{$skincare_summary['order_id']}}
													<?php } ?>
												</div>
												
												<div class="col-md-6  form-group">
													<strong>Add-ons [Product Name] :</strong>
													
													{{$skincare_summary['addon_product']}}
													
												</div>

												<div class="col-md-6  form-group">
													<strong>Product Name :</strong>
													{{$skincare_summary['product_name']}}
													
												</div>
												
											</div>
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Shipments</span></h3>
												<div class="col-md-6  form-group">
													<strong>Address :</strong>
													<?php if(isset($skincare_summary['addressline1']) && $skincare_summary['addressline1'] != '')    
													{ ?>
														{{$skincare_summary['addressline1']}}
													<?php } ?>
													<?php if(isset($skincare_summary['addressline2']) && $skincare_summary['addressline2'] != '')    
													{ ?>
														{{$skincare_summary['addressline2']}}
													<?php } ?>
													<?php if(isset($skincare_summary['city']) && $skincare_summary['city'] != '')    
													{ ?>
														{{$skincare_summary['city']}}
													<?php } ?>
													<?php if(isset($skincare_summary['state']) && $skincare_summary['state'] != '')    
													{ ?>
														{{$skincare_summary['state']}}, 
													<?php } ?>
													<?php if(isset($skincare_summary['zipcode']) && $skincare_summary['zipcode'] != '')    
													{ ?>
														{{$skincare_summary['zipcode']}}
													<?php } ?>
												</div>
												<div class="col-md-6  form-group">
													<strong>TeleHealth Medicine Fee :</strong>
													<?php if(isset($skincare_summary['telemedicine_fee']) && $skincare_summary['telemedicine_fee'] != '')    
													{ ?>
														{{$skincare_summary['telemedicine_fee']}} $
													<?php } ?>
												</div>
												<div class="col-md-6  form-group">
													<strong>Addons Fee :</strong>
													<?php if(isset($skincare_summary['price']) && $skincare_summary['price'] != '')  { ?>
														{{$skincare_summary['price']}} $
													<?php } ?>
												</div>
												<div class="col-md-6  form-group">
													<strong>Shipping Fee :</strong> 0
												</div>
												<div class="col-md-6  form-group">
													<strong>Taxes :</strong>
													<?php if(isset($skincare_summary['tax']) && $skincare_summary['tax'] != '') {?>
														{{$skincare_summary['tax']}} $
													<?php } ?>
												</div> 
												<div class="col-md-6  form-group">
													<strong>Total Amount :</strong>
													<?php if(isset($skincare_summary['total_amount']) && $skincare_summary['total_amount'] != '')  { ?>
														{{$skincare_summary['total_amount']}} $
													<?php } ?>
												</div>
											</div>
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Physician Details</span></h3>
												<div class="col-md-6  form-group">
													<strong>Clinician ID :</strong>
												</div>
												<div class="col-md-6  form-group">
													<strong>Clinician Name :</strong>
												</div>
												<div class="col-md-6  form-group">
													<strong>Expertise :</strong>
												</div>
											</div>
											<div class="box-block mtb32">
												<h3 class="font-weight-bold"><span class="text-underline">Pharmacy Preference</span></h3>

												<div class="col-md-6  form-group">
													<?php if(isset($skincare_summary['pharmacy_pickup']) && $skincare_summary['pharmacy_pickup'] != '')  { ?>
														{{$skincare_summary['pharmacy_pickup']}}
													<?php } ?>

												</div>
												
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




										<!-- Action Item-->
										<?php
										if($user_case_management_data['product_type'] == "accutane"){?>
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

																		<!-- <input type="file" name="pregnancy_test" class="btn btn-secondry pregnecyrepot" value="Upload Report" >

																		<input type="hidden" name="case_id" value="{{$user_case_management_data['id']}}">

																		<input type="submit" name="submit_test_report" class="btn btn-secondry" id="uploadBtn_pregnancy_test"> -->
																	</sapn>


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


																		}?>
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

																		<input type="submit" name="submit_blood_report" class="btn btn-secondry" id="uploadBtn_blood_test">
																	</span>
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
													</div>
												</div>
											<?php } ?>

											<!-- close Action Item-->


										</section>
									</div>
								</div>
							</div> 
							<!--end 4th tab-->

							<!--start 5th tab-->
							<div id="messages" class="tab-pane fade in @if($msg_tab == 1) active show  @endif" >
								<div class="row" style="padding: 20px;">
									<div class="col-md-12">
										<section class="card">
											<ul class="nav nav-tabs" id="messages-tab-menu">
												<li><a class="btn @if($msg_tab != 1) active @endif" data-toggle="tab" href="#tab1">Medical Messgaes</a></li>
												<li><a class="btn @if($msg_tab == 1) active @endif" data-toggle="tab" href="#tab2">Non-Medical Messgaes</a></li>
											</ul>
											<div class="tab-content">
												<div id="tab1" class="tab-pane fade in @if($msg_tab != 1) active show @endif">	
													<div class="row" style="padding: 10px;">
														<div class="col-md-12">
															<!-- <div class="box-block mtb32" id="tab1"> -->
																<!-- <h3 class="font-weight-bold"><span class="text-underline">Medical Messgaes</span></h3> -->
																<div class="right-cht">

																	<div class="chating-section">
																		<ul>
																			<li>
																				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
																				<h5>Monday:10:20</h5>
																			</li>
																			<li>
																				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
																				<h5>Monday:10:20</h5>
																			</li>
																			<li>
																				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
																				<h5>Monday:10:20</h5>
																			</li>
																			<li>
																				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
																				<h5>Monday:10:20</h5>
																			</li>
																		</ul>
																	</div> 
																</div>

																<!-- </div> -->
															</div>
														</div>
													</div>

													<div id="tab2" class="tab-pane fade in  @if($msg_tab == 1) active show @endif">	
													<!-- <div class="row" style="padding: 10px;">
														<div class="col-md-12">
															<div class="box-block mtb32" id="tab1"> -->
																

																<div class="right-cht">
                    <!--     <div class="header-chat">
                            <p>Brandon Koh,MD</p>
                        </div> -->



                        {!! Form::open(array('route' => 'sendMessageNonMedical','method'=>'POST', 'enctype'=>"multipart/form-data")) !!}
                        <div class="chating-section">
                        	
                        	<ul><?php if(isset($message_data)) {?>
                        		@foreach ($message_data as $key => $message)
                        		@foreach ($message_details as $key => $user)
                        		<li>
                        		<?php if($user['sender'] == 'user'){ ?>
                        			
                        				<p>
                        					<?php 
                        					if(isset($message['message']) && $message['message']!=''){
                        						echo $message['message'];
                        					} ?>
                        				</p>
                        				<h5><?php 
                        				if(isset($message['date']) && $message['date']!=''){
                        					echo $message['date'];
                        				}

                        				?></h5>
                        			
                        		<?php }else{ ?>
                        		
                        		</li>
                        		<li>
                        			<p> 
                        				<?php 
                        				if(isset($message['message']) && $message['message']!=''){
                        					echo $message['message'];
                        				}

                        				?></p>
                        				<h5><?php 
                        				if(isset($message['date']) && $message['date']!=''){
                        					echo $message['date'];
                        				}

                        				?></h5>
                        			</li>
                        			<?php } ?>

                        			@endforeach
                        			@endforeach
                        		<?php }?>
                        	</ul>
                        </div>
                        <div class="last-typing-section">
                        	<!-- <div class="camera lastimg">
                        		<img src="{{asset('public/images/camera.png')}}" alt="">
                        	</div> -->
                        	<div class="attachment lastimg">
                        		<input class="form-control" type="file" name="file">
                        		<img src="{{asset('public/images/paperclip.png')}}" alt="">
                        	</div>
                        	<div class="search">
                        		<input class="form-control" type="text" name="text" placeholder="Readonly input here..." >
                        		<input class="form-control" type="hidden" name="user_id" value="{{$user_case_management_data['user_id']}}">
                        		<input class="form-control" type="hidden" name="case_id" value="{{$user_case_management_data['id']}}">

                        	</div>
                        	<div class="sending lastimg">
                        		<button type="submit"><img src="{{asset('public/images/telegram.png')}}" alt=""></button>
                        		<!-- <img src="{{asset('public/images/telegram.png')}}" alt=""> -->
                        	</div>
                        </div>
                        {!! Form::close() !!}
                    </div>														<!-- </div>


														</div>
													</div> -->
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

	$('form').submit(function(){
		$(this).find('button[type=submit]').prop('disabled', true);
	});

	function myFunction() {
		setTimeout(function(){ location.reload(true); }, 3000);
	}
</script>

<!-- <script>
function myFunction() {
  setTimeout(function(){ location.reload(true); }, 3000);
}
</script> -->
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


