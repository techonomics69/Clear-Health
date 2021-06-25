@extends('layouts.app')

@section('title', 'clearHealth | CaseManegement')
@section('content')

<div class="app-content content">
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif

	@section('script')
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	@endsection


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

		#questions-tab-menu li a.active{
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
						<li><a class="btn removemsg @if($msg_tab != 1) active @endif " data-toggle="tab" href="#profile">Profile</a></li>
						<li><a class="btn" data-toggle="tab" href="#questions">Questions</a></li>
						<li><a class="btn" data-toggle="tab" href="#skincare_summary">Skincare Summary </a></li>
						<li><a class="btn" data-toggle="tab" href="#action_items">Action Items </a></li>
						<li><a class="btn nonmedicalmsg" data-toggle="tab" href="#messages">Messages</a></li>

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
						
						$activeTab = 0 ;
						$active = 0 ;	
						@endphp
						@endif --}}

						@php
						$current_tab_id = "" ;
						$activeTab = 1;
						Session::forget('que_current_tab');
						@endphp
						<div id="questions" class="tab-pane fade in">					    

							<div class="row" style="padding: 10px;">
								<div class="col-md-12">

									<section class="card" >
										<ul class="nav nav-tabs" id="questions-tab-menu">

											@foreach($category as $key => $data)
											{{-- <li><a class="btn @if($key == 0) active @elseif($current_tab_id == 'home'.$key) active @endif" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li> --}}

											<li><a class="btn firstquebutton @if($current_tab_id == 'home7') active @elseif($current_tab_id == 'home'.$key) active @endif" data-toggle="tab" href="#home{{$key}}">{{$data}}</a></li>
											<?php //$activeTab++ ?> 
											@endforeach
										</ul>

										<div class="tab-content">
											<?php 
											$i=0;
											echo $current_tab_id;
											// print_r($category);
											?>
											@foreach($category as $key => $data)

											<?php if($key == 7) { ?>
												<?php $j = 0; ?>
												<div id="home7" class="tab-pane fade in active show">	
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
													<div id="home8" class="tab-pane fade in @if($i== 1) active show @endif">	
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
			<div id="home9" class="tab-pane fade in @if($i== 2) active show @endif">	
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
	<?php }
	
	if($key == 10){
		if($user_case_management_data['gender'] == "female"){
			if(count($followup_que) > 0){
				
	?>
		<div id="home10" class="tab-pane fade in @if($i== 3) active show @endif">	
			<?php foreach($followup_que as $fkey => $fvalue){
				$fanswers = json_decode($fvalue->answer);
				if(count($fanswers)>0){
					$findex = 1;
					
					foreach($fanswers as $fk => $fans){
			?>		
			<div class="row" style="padding: 10px;">
				<div class="col-md-12">
				
				<h4><strong>Que  <?php echo $findex;?> : <?php echo (isset($fans->question)) ? $fans->question : '';?></strong></h4>
				<p>Ans: <?php 
					if(isset($fans->answer)){
						if (is_array($fans->answer) or ($fans->answer instanceof Traversable)){
							foreach($fans->answer as $fs){
								echo $fs."<br>";
							}
						}else{
							echo $fans->answer;
						}
					}
					
					// if(is_array($fans->answer)){
					
					// }else{
					// 	//echo $fans->answer;
					// }		
				?></p>
				</div>
			</div>	
			<?php	
					$findex++;
					}
				}
		 } ?>
		
		</div>
	<?php
				
			}
		}		
	}
	
	if($key == 11){
		if($user_case_management_data['gender'] == "male"){
			if(count($followup_que) > 0){
				
	?>
		<div id="home11" class="tab-pane fade in @if($i== 4) active show @endif">	
			<?php foreach($followup_que as $fkey => $fvalue){
				$fanswers = json_decode($fvalue->answer);
				if(count($fanswers)>0){
					$findex = 1;
					foreach($fanswers as $fk => $fans){
			?>		
			<div class="row" style="padding: 10px;">
				<div class="col-md-12">
				
				<h4><strong>Que  <?php echo $findex;?> : <?php echo (isset($fans->question)) ? $fans->question : '';?></strong></h4>
				<p>Ans: <?php 
					if(isset($fans->answer)){
						if (is_array($fans->answer) or ($fans->answer instanceof Traversable)){
							foreach($fans->answer as $fs){
								echo $fs."<br>";
							}
						}else{
							echo $fans->answer;
						}
					}
					
					// if(is_array($fans->answer)){
					
					// }else{
					// 	//echo $fans->answer;
					// }		
				?></p>
				</div>
			</div>
			<?php	
					$findex++;
					}
				}
		 } ?>
		
		</div>
	<?php
				
			}
		}
}
	?>

	
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
<div id="messages" class="tab-pane fade in nonmedicalmsg" >
	<div class="row" style="padding: 20px;">
		<div class="col-md-12">
			<section class="card">
				<ul class="nav nav-tabs" id="messages-tab-menu">
					<li><a class="btn @if($msg_tab != 1) active @endif" data-toggle="tab" href="#medical">Medical Messgaes</a></li>
					<li><a class="btn nonmedicalmsg" data-toggle="tab" href="#nonmedical" onclick="Gotobottom();">Non-Medical Messgaes</a></li>
				</ul>
				<div class="tab-content">
					<div id="medical" class="tab-pane fade in @if($msg_tab != 1) active show @endif">
						<div class="row" style="padding: 10px;">
							<div class="col-md-12">
								<!-- <div class="box-block mtb32" id="tab1"> -->
									<!-- <h3 class="font-weight-bold"><span class="text-underline">Medical Messgaes</span></h3> -->
									<div class="right-cht">
										<div class="chating-section medicalmessages">
											<ul>
												
												@foreach ($msg_history as $key => $md_message)
													<li class="left">
													<div  class="time_messages">
											<p class="text_mesg">
												<?php 
												if(isset($md_message['message']) &&  $md_message['message']!=''){
													echo $md_message['message'];
												}else{
													//echo $md_message['url'];
													?>
													<!-- <img src="$md_message['url']" type="media_type"width='100'>
													<a target="_blank" download="" href="$md_message['url']"> Download</a> -->	
													<?php
												}
												?>
											</p>

														<h5>{{ $md_message['msg_date'] }}</h5>
													</div>
													</li>
													@endforeach
											</ul>
										</div> 
									</div>

									<!-- </div> -->
								</div>
							</div>
						</div>

						<div id="nonmedical" class="tab-pane fade in nonmedicalmsg">
							@if(isset($message_data))
							@if(count($message_data)>0)
							@php
								$lastMsg = (count($message_data) - 1); 
							@endphp
							<a href="#bottomDivMsg{{$message_data[$lastMsg]['id']}}" style="display: none;" id="gotobottomdivmsg">scroll down</a>
							@else
							<a style="display: none;" id="gotobottomdivmsg">scroll down</a>
							@endif
							@endif
							<div class="right-cht">
								{!! Form::open(array('method'=>'POST', 'enctype'=>"multipart/form-data", 'id'=>"msgForm")) !!}
								<div class="chating-section nonmedicalmessages" id="chating-section" >
									<ul><?php
										if(isset($message_data)) {?>
										@foreach ($message_data as $key => $message)
										
		<li id="<?php if($key == count($message_data) - 1) echo 'bottomDivMsg'.$message['id'] ?>" class = <?php if($message['sender'] == 'admin') { ?>"right"<?php }else{ ?>
		"left" <?php } ?>>
											<div  class="time_messages">
											<p class="text_mesg">
												<?php 
												echo $message['message'];
												if(isset($message['file_name']) && $message['file_name']!=''){
													echo "<br>";
													$fileExt = explode(".",$message['file_name']);
													
													$fileextArr = ['jpg','jpeg','png'];
													if(count($fileExt)>0){
														if(in_array($fileExt[1],$fileextArr)){
													?>
													<img src="{{ asset('public/Message_files/'.$message['file_name']) }}" type="media_type"width='100'>
													<a target="_blank" download="" href="{{ asset('public/Message_files/'.$message['file_name']) }}"> Download</a>	
													<?php			
														}else{
															switch($fileExt[1]){
																case "doc":
																	$fileName = asset("public/images/msgs/doc.png");
																	break;
																case "docx":
																	$fileName = asset("public/images/msgs/doc.png");
																	break;
																case "xls":
																	$fileName = asset("public/images/msgs/xls.png");
																	break;
																case "xlsx":
																	$fileName = asset("public/images/msgs/xls.png");
																	break;
																case "txt":
																	$fileName = asset("public/images/msgs/txt.png");
																	break;
																case "pdf":
																	$fileName = asset("public/images/msgs/pdf.png");
																	break;			
																default:
																	$fileName = asset("public/images/msgs/file.png");
																	break;	
															}
													?>
													<img src="{{ $fileName }}" type="media_type"width='100'>
													<a target="_blank" download="" href="{{ asset('public/Message_files/'.$message['file_name']) }}"> Download</a>	
													<?php		
														}
													}else{

													}
												
												}
												?>
											</p>

											<h5>
												<?php 
												if(isset($message['date']) && $message['date']!=''){
													echo $message['date'];
												}?>
											</h5>
										</div>
										</li>
									

									@endforeach
									
									<?php } ?>
								</ul>

							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="p-2 pl-4">
									<img id="blah" src="#" alt="your image" style="display: none; height: 120px;
									width: 250px;" />
								</div>
							</div>
							</div>
							
							<div id="last-typing-section" class="last-typing-section">
<!-- <div class="camera lastimg">
<img src="{{asset('public/images/camera.png')}}" alt="">
</div> -->
<!-- <div class="row"> -->
	<!-- <div class="col-12"> -->
		
	<!-- </div> -->
<!-- </div> -->

<div class="attachment lastimg pinclip">
	<div class="variants">
		<div class='file'>
			<label for='file'>
				<img src="{{asset('public/images/paperclip.png')}}" alt="">
				
			</label>
			<input id="file" type="file" name="file" onchange="loadFile(event)">

		</div>
	</div>
</div>
<!-- <div class="attachment lastimg">
<input class="form-control" type="file" name="file" id="file">
<img src="{{asset('public/images/paperclip.png')}}" alt="">
</div> -->
<div class="search">
	
	<input class="form-control" type="text" name="text" placeholder="Type a message..." id="text">
	<input type="hidden" id ="_token" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="user_id" value="{{$user_case_management_data['user_id']}}" id="user_id">
	<input type="hidden" name="case_id" value="{{$user_case_management_data['id']}}" id="case_id">
	
</div>
<div class="sending lastimg">
	<button type="submit" id="btnsubmit"><img src="{{asset('public/images/telegram.png')}}" alt=""></button>
	<button type="button" id="spinnerdiv" style="display:none">
		<span class="fa fa-spinner fa-spin"></span>
	</button>
</div>
</div>
{!! Form::close() !!}
</div>														
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


<script>
	$(document).ready(function() {
		$('#btnsubmit').on('click', function(event) {
			$("#btnsubmit").attr('style','display:none');
			$("#spinnerdiv").attr('style','display:block');
			event.preventDefault();
			var submitFlag = false;	
			if($("#text").val() !== "" || $("#file").val() !==""){
				submitFlag = true;
			}else{
				submitFlag = false;
			}
			
			if(submitFlag){
					

					var file = $('#file').prop('files')[0];
					var text  = $('#text').val();
					var user_id = $('#user_id').val();
					var case_id = $('#case_id').val();

					var formData = new FormData();
					
					formData.append('file', file);
					formData.append('text', text);
					formData.append('user_id', user_id);
					formData.append('case_id', case_id);
					formData.append('_token', '{{csrf_token()}}');

					$.ajax({
						url: "{{URL('admin/casemanagement/sendMessageNonMedical')}}",
						type: "POST",
						data: formData,
						dataType:"json",
						async:false,
						processData: false,
						contentType: false,
						success: function(response){
							if(response.status){
								$("#btnsubmit").attr('style','display:block');
								$("#spinnerdiv").attr('style','display:none');
								var data = response.data;
								$('#text').val('');
								$('#file').val('');
								document.getElementById('gotobottomdivmsg').closest('a').removeAttribute('href');
								document.getElementById('gotobottomdivmsg').closest('a').setAttribute('href','#bottomDivMsg'+data.id);

								if(!data.text == "" || !data.text == null){
									$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+data.text+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");	
								}
								
								if(!data.file_path == "" || !data.file_path == null){							
									var exts2 = ['jpg','jpeg','png'];
									var ufile = data.file_name;
									var fileNameExt2 = ufile.substr(ufile.lastIndexOf('.') + 1);
									
									if ($.inArray(fileNameExt2, exts2) !== -1){
										$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+"<img width='100' src={{URL('/')}}/public/Message_files/" +data.file_name+ ">"+ "<a target='_blank' download='' href={{URL('/')}}/public/Message_files/"+data.file_name+">" + " Download" + "</a>"+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");
									}else if(fileNameExt2 == 'doc' || fileNameExt2 == 'docx'){
										$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+"<img width='100' src={{URL('/')}}/public/images/msgs/doc.png>"+ "<a target='_blank' download='' href={{URL('/')}}/public/Message_files/"+data.file_name+">" + " Download" + "</a>"+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");
									}else if(fileNameExt2 == 'pdf'){
										$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+"<img width='100' src={{URL('/')}}/public/images/msgs/pdf.png>"+ "<a target='_blank' download='' href={{URL('/')}}/public/Message_files/"+data.file_name+">" + " Download" + "</a>"+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");
									}else if(fileNameExt2 == 'txt'){
										$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+"<img width='100' src={{URL('/')}}/public/images/msgs/txt.png>"+ "<a target='_blank' download='' href={{URL('/')}}/public/Message_files/"+data.file_name+">" + " Download" + "</a>"+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");
									}else if(fileNameExt2 == 'xls' || fileNameExt2 == 'xlsx'){
										$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+"<img width='100' src={{URL('/')}}/public/images/msgs/xls.png>"+ "<a target='_blank' download='' href={{URL('/')}}/public/Message_files/"+data.file_name+">" + " Download" + "</a>"+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");
									}else{
										$(".nonmedicalmessages ul").append("<li class='right' id='bottomDivMsg"+data.id+"'>"+"<p >"+"<img width='100' src={{URL('/')}}/public/images/msgs/file.png>"+ "<a target='_blank' download='' href={{URL('/')}}/public/Message_files/"+data.file_name+">" + " Download" + "</a>"+"</p>"+"<h5>"+data.msg_date+"<h5>"+"</li>");
									}	 
									
								}
								
								$("#blah").hide();
								setTimeout(function(){
									$("#gotobottomdivmsg")[0].click();
								},200);
							}else{
								$("#btnsubmit").attr('style','display:block');
								$("#spinnerdiv").attr('style','display:none');
								toastr["error"](response.message)
								// toastr.error();
							}
							
						}

				});
			}else{
				$("#btnsubmit").attr('style','display:block');
				$("#spinnerdiv").attr('style','display:none');
				toastr["error"]("Please add message or attachment");
			}
		});
	});

	function Gotobottom(){
		setTimeout(function(){	
			$("#gotobottomdivmsg")[0].click();
		},1000);
	}

	$(document).on('click','#gotobottomdivmsg',function(){
		// alert($(this).attr("href"));
		// $($(this).attr("data-target"));
		setTimeout(function(){
			var uri = window.location.toString();
			if (uri.indexOf("#") > 0) {
				var clean_uri = uri.substring(0, uri.indexOf("#"));
				window.history.replaceState({}, document.title, clean_uri);
			}
		},1000);
	});

	function bytesToSize(bytes) {
		const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB']
		if (bytes === 0) return 'n/a'
		const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10)
		if (i === 0) return `${bytes} ${sizes[i]})`
		var sizeArr = {
			size : (bytes / (1024 ** i)).toFixed(1),
			sizeIn :  sizes[i]
		};
		return sizeArr;
		// return `${(bytes / (1024 ** i)).toFixed(1)} ${sizes[i]}`
	}

	var loadFile = function(event) {
	var exts = ['jpg','jpeg','png'];
	
	var fname = event.target.files[0].name;
	var fileNameExt = fname.substr(fname.lastIndexOf('.') + 1);
	var filesize = bytesToSize(event.target.files[0].size);
	
	// if(filesize.length > 0){
	// 	alert('here');
		if(filesize.sizeIn == "" || filesize.sizeIn == "KB"){
		}else if(filesize.sizeIn == "GB" || filesize.sizeIn == "TB"){
			toastr["error"]("Please upload file less than 5MB");
			$('#file').val('');
			$("#blah").hide();
			return false;
		}else if(filesize.sizeIn == "MB"){
			
			if(parseFloat(filesize.size) > 5){
				
				toastr["error"]("Please upload file less than 5MB");
				$('#file').val('');
				$("#blah").hide();
				return false;
			}
		}
	// }
	var reader = new FileReader();
	if ($.inArray(fileNameExt, exts) !== -1){
		reader.onload = function(){
      	var output = document.getElementById('blah');
      	output.src = reader.result;
    	};
		reader.readAsDataURL(event.target.files[0]);
	}else if(fileNameExt == 'doc' || fileNameExt == 'docx'){
		reader.onload = function(){
      	var output = document.getElementById('blah');
      	output.src = "{{ asset('public/images/msgs/doc.png') }}";
    	};
		reader.readAsDataURL(event.target.files[0]);
	}else if(fileNameExt == 'pdf'){
		reader.onload = function(){
      	var output = document.getElementById('blah');
      	output.src = "{{ asset('public/images/msgs/pdf.png') }}";
    	};
		reader.readAsDataURL(event.target.files[0]);
	}else if(fileNameExt == 'txt'){
		reader.onload = function(){
      	var output = document.getElementById('blah');
      	output.src = "{{ asset('public/images/msgs/txt.png') }}";
    	};
		reader.readAsDataURL(event.target.files[0]);
	}else if(fileNameExt == 'xls' || fileNameExt == 'xlsx'){
		reader.onload = function(){
      	var output = document.getElementById('blah');
      	output.src = "{{ asset('public/images/msgs/xls.png') }}";
    	};
		reader.readAsDataURL(event.target.files[0]);
	}else{
		reader.onload = function(){
      	var output = document.getElementById('blah');
      	output.src = "{{ asset('public/images/msgs/file.png') }}";
    	};
		reader.readAsDataURL(event.target.files[0]);
	}	
	
	$("#blah").show();
  };

  $(".firstquebutton").each(function(i){
	console.log(i);  
	// if(i == 0){
	// 	$(this).addClass('active');
	// }
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

<script>
	

	
	
</script>
