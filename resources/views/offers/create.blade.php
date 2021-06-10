@extends('admin.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />

{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  --}}

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
	<label>Whoops!</label> There were some problems with your input.<br><br>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<div class=" user-create">
	<div class="row" >
		<div class="col-lg-12">
			<section class="card">
			
			<div class="card-body">
				<form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data" id="offer_form">
					@csrf
				

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label>Title</label><span class="required">*</span>

								<input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">

							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label>Description</label><span class="required">*</span>
						<input type="text" name="description" class="form-control" value="{{old('description')}}">
							</div>
						</div>
					</div>
						
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label>From</label><span class="required">*</span>
								{{-- {!! Form::date('dd-mm-yyyy')('from_date', null, array('placeholder' => 'From','class' => 'form-control')) !!} --}}
								 <input class="form-control digits"  type="text" name="from_date" onblur="checkdate()" id="from_date" value="{{old('from_date')}}">

								
							</div>
						</div>


						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label>To</label><span class="required">*</span>
								{{-- {!! Form::date('dd-mm-yyyy')('to_date', null, array('placeholder' => 'To','class' => 'form-control')) !!} --}}

								<input type="text" name="to_date" class="form-control" onblur="checkdate()" id="to_date" value="{{old('to_date')}}" data-provide="datepicker">
							</div>
						</div>
						<div class="form-group date_error" style="color: red;display: none;">To Date must be grater then From Date</div>
					</div>

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label>Vehicle</label><span class="required">*</span>
										<select name="vehicle[]" id="vehicle" class="form-control js-select2" multiple="multiple">
											{{-- <option value="0">Select Vehicle</option> --}}
											@foreach($vehicle as $vehl)
											<?php
											$vehName = $vehl->year." ".$vehl->brand_name." ".$vehl->model_name; 
											?>
											
											<option value="{{$vehl->vehicle_id}}" data-brand="{{$vehl->brand_name}}" data-model="{{$vehl->model_name}}" data-trim="{{$vehl->trim}}" @if(old('vehicle') == $vehl->vehicle_id) selected @endif >{{ $vehName }} </option>
											@endforeach
										</select>
							</div>
						</div>
							<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label>Offer Type</label><span class="required">*</span>
								<select id="offer_type" name="offer_type" class="form-control">
									<option value="0">Select Offer</option>
									<option value="1" @if(old('offer_type') == 1) selected @endif>Percentage Base</option>
									<option value="2" @if(old('offer_type') == 2) selected @endif>Amount</option>
									<option value="3" @if(old('offer_type') == 3) selected @endif>Gifts</option>
									<option value="4" @if(old('offer_type') == 4) selected @endif>Addons</option>
									<option value="5" @if(old('offer_type') == 5) selected @endif>Promocode</option>
									
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 offer_percentage" style="display: none;">
							<div class="form-group">
								<label>Percentage</label><span class="required">*</span>
								<input type="text" name="percentage" id="percentage" class="form-control" onkeypress="return isNumber(event)" >
								<div class="form-group error_percentage" style="color: red;display: none;">Percentage field is required</div>

							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 offer_amount" style="display: none;">
							<div class="form-group">
								<label>Amount</label><span class="required">*</span>
								<input type="text" name="amount" id="amount" class="form-control" onkeypress="return isNumber(event)" >
								<div class="form-group error_amount" style="color: red;display: none;">Amount field is required</div>

							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 offer_gift" style="display: none;">
							<div class="form-group">
								<label>Gift</label><span class="required">*</span>
								<input type="text" name="gift" id="gift" class="form-control" >
								<div class="form-group error_gift" style="color: red;display: none;">Gift field is required</div>

							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 offer_addon" style="display: none">
							<div class="form-group">
								<label>Addon Products</label><span class="required">*</span>
								<select name="addon[]" id="addon" class="form-control js-select2"  multiple="multiple">
											{{-- <option value="0">Select Addon</option> --}}
											@foreach($addonProducts as $addon)
											<option value="{{$addon->id}}" >{{$addon->title}} </option>
											@endforeach
										</select>

							</div>

							<div class="form-group error_addon" style="color: red;display: none;">Please select addon product</div>
						</div>
						
					
					</div>

					<div class="row promocode_section" style="display: none;">
						<div class="col-lg-3 col-md-6 col-sm-6 " >
							<div class="form-group">
								<label>Promocode</label><span class="required">*</span>
								<input type="text" name="promocode" id="promocode" class="form-control" value="{{old('promocode')}}">
							</div>
							<div class="form-group error_promo" style="color: red;display: none;">Promocode field is required</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="form-group">
								<label>Promocode Type</label><span class="required">*</span>
								<select id="promocode_type" name="promocode_type" class="form-control">
									<option value="0">Select Type</option>
									<option value="1" @if(old('promocode_type') == 1) selected @endif>Percentage</option>
									<option value="2" @if(old('promocode_type') == 2) selected @endif>Amount</option>
								
									
								</select>
							</div>
							<div class="form-group error_promocode_type" style="color: red;display: none;">Please Select Promocode type.</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 " >
							<div class="form-group">
								<label>Promocode Value</label><span class="required">*</span>
								<input type="text" name="promocode_value" id="promocode_value" class="form-control" onkeypress="return isNumber(event)" value="{{old('promocode_value')}}">

							</div>
							<div class="form-group error_promo_value" style="color: red;display: none;">Promocode value field is required</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 " >
							<div class="form-group">
								<label>Description</label>
								<input type="text" name="promocode_description" id="promocode_description" class="form-control" value="{{old('promocode_description')}}">

							</div>
							<div class="form-group error_promo_description" style="color: red;display: none;">description field is required</div>
						</div>
					</div>
					

					<div class="row">
						<div class="col-lg-12 submit-buton">
							<a  href="{{ route('offers.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
							<button type="button" class="btn btn-secondry offer_submit_btn" data-dismiss="modal">Submit</button>
						</div>
					</div>

				</form>
			</div>

		</section>
	</div>
</div>
</div>
@endsection
@section('headerSection')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" /> --}}

<style>
	

</style>
	@endsection

	@section('footerSection')
{{-- 	@jquery --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script type="text/javascript">
    $(".js-select2").select2({
      closeOnSelect : false,
       placeholder : "Select",
      // allowHtml: true,
      allowClear: true,
      //tags: true // создает новые опции на лету
    });
</script>

  
	<script type="text/javascript">
		//$('#roles').select2();
		/*function getCity(stateID){
			$.ajax({
				type:"GET",
				url:"{{url('admin/franchise/get-city-list')}}?state_id="+stateID,
				success:function(res){ 
					if(res){
						$("#inputCity").empty();
						var html = "";
						html += '<option>Select City</option>';           
						$("#inputCity").append('<option>Select City</option>');
						$.each(res,function(key,value){
							html +='<option value="'+value.id+'">'+value.city_name+'</option>';
						});

						$("#inputCity").html(html).trigger('change');;

					}else{
						$("#inputCity").empty();
					}
				}
			});
		}*/
	/*	function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imagePreview').css('background-image', 'url('+e.target.result +')');
					$('#imagePreview').hide();
					$('#imagePreview').fadeIn(650);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}*/
		
		
		
		$('form').submit(function(){
		  $(this).find(':submit').attr('disabled','disabled');
		});

		function checkdate(){
			var d1 = $('#from_date').val();
			var d2 = $('#to_date').val();
			var date1 = Date.parse(d1);
			var date2 = Date.parse(d2);

			/*alert(date1+"---"+date2);*/
			if (date2 < date1) {

				$('.date_error').show();
				setTimeout(function(){$('.date_error').hide();}, 3000);
				return false;
				
			}
			else{

				$('.date_error').hide();
				return true;
			}

		}

		/*$(".offer_submit_btn").click(function(){
			alert("The paragraph was clicked.");
		});
*/		
		

		$('.offer_submit_btn').on('click', function (e) {
			//var optionSelected = $("option:selected", this);

			var d1 = $('#from_date').val();
				var d2 = $('#to_date').val();
				var date1 = Date.parse(d1);
				var date2 = Date.parse(d2);
			var valueSelected = $('#offer_type').val();

			if(valueSelected == 1 && $('#percentage').val() == ''){

				$('.error_percentage').show();
				setTimeout(function(){$('.error_percentage').hide();}, 3000);
				return false;

			}else if(valueSelected == 2 && $('#amount').val() == ''){
				$('.error_amount').show();
				setTimeout(function(){$('.error_amount').hide();}, 3000);
				return false;

			}else if(valueSelected == 3 && $('#gift').val() == ''){
				$('.error_gift').show();
				setTimeout(function(){$('.error_gift').hide();}, 3000);
				return false;
			}else if(valueSelected == 4 && $('#addon').val() == ''){
				$('.error_addon').show();
				setTimeout(function(){$('.error_addon').hide();}, 3000);
				return false;
			}else if(valueSelected == 5 && $('#promocode').val() == ''){
				$('.error_promo').show();
				setTimeout(function(){$('.error_promo').hide();}, 3000);
				return false;
			}else if(valueSelected == 5 && $('#promocode_type').val() == 0){
				$('.error_promocode_type').show();
				setTimeout(function(){$('.error_promo').hide();}, 3000);
				return false;
			}else if(valueSelected == 5 && $('#promocode_value').val() == ''){
				$('.error_promo_value').show();
				setTimeout(function(){$('.error_promo_value').hide();}, 3000);
				return false;
			}else if (date2 < date1)
				 {

					$('.date_error').show();
					setTimeout(function(){$('.date_error').hide();}, 3000);
					return false;

				}

			else{
				$('#offer_form').submit();
			}

			
			
		});

		$('#offer_type').on('change', function (e) {
			//var optionSelected = $("option:selected", this);

			$('.offer_percentage').hide();
			$('.offer_amount').hide();
			$('.offer_gift').hide();
			$('.offer_addon').hide();
			$('.promocode_section').hide();

			var valueSelected = this.value;

			if(valueSelected == 1){

				$('.offer_percentage').show();

			}else if(valueSelected == 2){
				$('.offer_amount').show();

			}else if(valueSelected == 3){
				$('.offer_gift').show();
			}else if(valueSelected == 4){
				$('.offer_addon').show();
			}else if(valueSelected == 5){
				$('.promocode_section').show();
				
			}
			
		});
		$(document).ready(function() {
			/*$('#vehicle').multiselect({
				buttonWidth : '160px',
				includeSelectAllOption : true,
				nonSelectedText: 'Select an Option'
			});*/

			var valueSelected = $('#offer_type').val();

			if(valueSelected == 1){

				$('.offer_percentage').show();

			}else if(valueSelected == 2){
				$('.offer_amount').show();

			}else if(valueSelected == 3){
				$('.offer_gift').show();
			}else if(valueSelected == 4){
				$('.offer_addon').show();
			}else if(valueSelected == 5){
				$('.promocode_section').show();
				
			}
		});

		function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
          }
          return true;
        }

		
	</script>

	<script type="text/javascript">
    $.noConflict();
jQuery(document).ready(function ($) {
        
            $("#from_date").datepicker({
                //numberOfMonths: 2,
                minDate: new Date(),
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate());
                    $("#to_date").datepicker("option", "minDate", dt);
                }
            });
            $("#to_date").datepicker({
                //numberOfMonths: 2,
                minDate: new Date(),
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate());
                    $("#from_date").datepicker("option", "maxDate", dt);
                }
            });
        });
    

jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();
    </script>
	@endsection