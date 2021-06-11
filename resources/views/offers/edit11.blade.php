@extends('admin.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
@section('content')


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
<!-- <div class="content-wrapper" style="
    margin: 0px auto;
    padding: 80px 15px 15px 15px;
    max-width: 1200;
    "> -->
    <div class="row" >
        <div class="col-lg-12">
            <section class="card">
                {{--     <header class="card-header top-heading">
                    <h3 class="main-title-heading">   Edit New User</h3> 
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                    </div>
                </header> --}}
                <div class="card-body">
                    <form action="{{ route('offers.update',$offer->id) }}" method="POST" enctype="multipart/form-data" id="offer_form">
                        @csrf
                        @method('PUT')
                       <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Title</label><span class="required">*</span>

                                <input type="text" name="title" id="title" class="form-control" value="{{$offer->title}}">

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Description</label><span class="required">*</span>
                                <input type="text" name="description" class="form-control" value="{{$offer->description}}">
                            </div>
                        </div>
                    </div>
                        
                        <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>From</label><span class="required">*</span>
                                {{-- {!! Form::date('dd-mm-yyyy')('from_date', null, array('placeholder' => 'From','class' => 'form-control')) !!} --}}

                                <input type="text" name="from_date" class="form-control" onblur="checkdate()" id="from_date" value="<?php echo date('d-m-Y', strtotime($offer->from_date)) ?>">

                                
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>To</label><span class="required">*</span>
                                {{-- {!! Form::date('dd-mm-yyyy')('to_date', null, array('placeholder' => 'To','class' => 'form-control')) !!} --}}

                                <input type="text" name="to_date" class="form-control" onblur="checkdate()" id="to_date" value="<?php echo date('d-m-Y', strtotime($offer->to_date)) ?>">
                            </div>
                        </div>
                        <div class="form-group date_error" style="color: red;display: none;">To Date must be grater then From Date</div>
                    </div>
                    <?php
                    $selected_vehicle  = explode(',',$offer->vehicle)
                    ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Vehicle</label><span class="required">*</span>
                                        <select name="vehicle[]" id="vehicle" class="form-control js-select2" multiple="multiple">
                                            <!-- <option value="0">Select Vehicle</option> -->
                                            @foreach($vehicle as $vehl)
                                            <?php
                                            $vehName = $vehl->year." ".$vehl->brand_name." ".$vehl->model_name; 
                                            ?>
                                            
                                            <option value="{{$vehl->vehicle_id}}" data-brand="{{$vehl->brand_name}}" data-model="{{$vehl->model_name}}" data-trim="{{$vehl->trim}}" @if(in_array($vehl->vehicle_id,$selected_vehicle)) selected @endif >{{ $vehName }} </option>
                                            @endforeach
                                        </select>
                            </div>
                        </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Offer Type</label><span class="required">*</span>
                                <select id="offer_type" name="offer_type" class="form-control">
                                    <option value="0">Select Offer</option>
                                    <option value="1" @if($offer->offer_type == 1) selected @endif>Percentage Base</option>
                                    <option value="2" @if($offer->offer_type == 2) selected @endif>Amount</option>
                                    <option value="3" @if($offer->offer_type == 3) selected @endif>Gifts</option>
                                    <option value="4" @if($offer->offer_type == 4) selected @endif>Addons</option>
                                    <option value="5" @if($offer->offer_type == 5) selected @endif>Promocode</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 offer_percentage" style="display: none;">
                            <div class="form-group">
                                <label>Percentage</label><span class="required">*</span>
                                <input type="text" name="percentage" id="percentage" class="form-control" value="@if($offer->percentage != ''){{$offer->percentage}} @endif" >
                                <div class="form-group error_percentage" style="color: red;display: none;">Percentage field is required</div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 offer_amount" style="display: none;">
                            <div class="form-group">
                                <label>Amount</label><span class="required">*</span>
                                <input type="text" name="amount" id="amount" class="form-control" value="@if($offer->amount != ''){{$offer->amount}} @endif">
                                <div class="form-group error_amount" style="color: red;display: none;">Amount field is required</div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 offer_gift" style="display: none;">
                            <div class="form-group">
                                <label>Gift</label><span class="required">*</span>
                                <input type="text" name="gift" id="gift" class="form-control" value="@if($offer->gift != ''){{$offer->gift}} @endif">
                                <div class="form-group error_gift" style="color: red;display: none;">Gift field is required</div>

                            </div>
                        </div>
                         <?php
                    $selected_addon  = explode(',',$offer->addon)
                    ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 offer_addon" style="display: none">
                            <div class="form-group">
                                <label>Addon Products</label><span class="required">*</span>
                                <select name="addon[]" id="addon" class="form-control js-select2"  multiple="multiple">
                                            <!-- <option value="0">Select Addon</option> -->
                                            @foreach($addonProducts as $addon)
                                            <option value="{{$addon->id}}" @if(in_array($addon->id,$selected_addon)) selected @endif  >{{$addon->title}} </option>
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
                                <input type="text" name="promocode" id="promocode" class="form-control" value="@if($offer->promocode != ''){{$offer->promocode}} @endif">
                            </div>
                            <div class="form-group error_promo" style="color: red;display: none;">Promocode field is required</div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Promocode Type</label><span class="required">*</span>
                                <select id="promocode_type" name="promocode_type" class="form-control">
                                    <option value="0">Select Type</option>
                                    <option value="1" @if($offer->promocode_type == 1) selected @endif>Percentage</option>
                                    <option value="2" @if($offer->promocode_type == 2) selected @endif>Amount</option>
                                
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 " >
                            <div class="form-group">
                                <label>Promocode Value</label><span class="required">*</span>
                                <input type="text" name="promocode_value" id="promocode_value" class="form-control" value="@if($offer->promocode_value != ''){{$offer->promocode_value}} @endif">

                            </div>
                            <div class="form-group error_promo_value" style="color: red;display: none;">Promocode value field is required</div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 " >
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="promocode_description" id="promocode_description" class="form-control" value="@if($offer->promocode_description != ''){{$offer->promocode_description}} @endif">

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
    <!-- </div> -->
    @endsection

    @section('headerSection')

@endsection

@section('footerSection')
{{-- @jquery --}}
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
            }else if(valueSelected == 5 && $('#promocode_value').val() == ''){
                $('.error_promo_value').show();
                setTimeout(function(){$('.error_promo_value').hide();}, 3000);
                return false;
            }else if (date2 < date1) {

                    $('.date_error').show();
                    setTimeout(function(){$('.date_error').hide();}, 3000);
                    return false;

            }else{
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
                
                  $('#percentage').attr('disabled',false);
                  $('#gift,#addon,#promocode,#promocode_type,#promocode_value,#promocode_description').attr('disabled','disabled');

                $('.offer_percentage').show();

            }else if(valueSelected == 2){
                   $('#amount').attr('disabled',false);
                  $('#percentage,#gift,#addon,#promocode,#promocode_type,#promocode_value,#promocode_description').attr('disabled','disabled'); 

                $('.offer_amount').show();

            }else if(valueSelected == 3){
                   $('#gift').attr('disabled',false);
                  $('#percentage,#amount,#addon,#promocode,#promocode_type,#promocode_value,#promocode_description').attr('disabled','disabled'); 

                $('.offer_gift').show();
            }else if(valueSelected == 4){
                  $("#addon").attr('disabled',false);
                  $('#percentage,#amount,#gift,#promocode,#promocode_type,#promocode_value,#promocode_description').attr('disabled','disabled'); 

                $('.offer_addon').show();
            }else if(valueSelected == 5){
                 $(".addon").attr('disabled','disabled');
                  $("#promocode,#promocode_type,#promocode_value,#promocode_description").attr('disabled',false);
                 $('#percentage,#amount,#gift,#addon').attr('disabled','disabled'); 
                 
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
