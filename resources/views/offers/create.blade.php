@extends('layouts.app')
@section('title', 'clearHealth | Offers & Promotions')
@section('content')

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"
type="text/javascript"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
rel="Stylesheet"type="text/css"/> -->
<div class="app-content content"> 
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
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Offers & Promotions</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Create Offers</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                    <a class="btn btn-secondry" href="{{ route('offers.index') }}"> Back</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class=" user-create">
                <div class="row" >
                    <div class="col-lg-12">
                        <section class="card">
                        {{-- <header class="card-header top-heading">

                        <h3 class="main-title-heading">Create New Customer</h3> 
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('customers.index') }}"> Back</a>
                        </div>
                    </header> --}}

                    <div class="card-body">
                        <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data" id="offer_form">
                            @csrf
                            
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Promocode</label><span class="required">*</span>
                                        {!! Form::text('promocode', null, array('placeholder' => 'Promocode','class' => 'form-control', 'old' => 'promocode') )!!}
                                    </div>
                                </div>

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Promocode Type</label><span class="required">*</span>
                                        {!! Form::select('promocode_type', ['0'=>'Please Select','1'=>'Percentage','2'=>'Amount'], null, ['class' => 'form-control'],['id' => 'offer_type']) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Promocode Value</label><span class="required">*</span>
                                        {!! Form::text('promocode_value', null, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Description</label><span class="required">*</span>
                                        {!! Form::text('description', null, array('placeholder' => 'Description','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>From</label><span class="required">*</span>
                                        {!! Form::text('from_date', null, array('placeholder' => '','class' => 'form-control from_date', 'onblur' => 'checkdate()','id'=>'from_date','old' => 'from_date')) !!}
                                        <!-- <input type="text" name="from_date" class="form-control from_date" onblur="checkdate()" id="from_date" data-provide="datepicker"> -->

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>To</label><span class="required">*</span>
                                        {!! Form::text('to_date', null, array('placeholder' => '','class' => 'form-control to_date','onblur' => 'checkdate()','id'=>'to_date','old' => 'to_date')) !!}
                                        <!-- <input type="text" name="to_date" class="form-control  to_date" onblur="checkdate()" id="to_date" data-provide="datepicker"> -->
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12 submit-buton text-right">
                                    <a  href="{{ route('offers.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
                                    <button type="submit" class="btn btn-secondry" data-dismiss="modal" id="offer_submit_btn">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </section>
            </div>
        </div>
    </div>
</div>  
</div>
</div>
@endsection
@section('footerSection')   
@endsection
@section('scriptsection')
<script type="text/javascript">
    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });

    /*$(document).ready(function() {
        $(function () {
            $('.from_date').datepicker();
        });

        $(function () {
            $('.to_date').datepicker();
        });

    });*/

   $(document).ready(function ($) {
        
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

 $(document).ready(function checkdate(){
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

        });
</script>
@endsection