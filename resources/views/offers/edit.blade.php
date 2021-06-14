@extends('layouts.app')

@section('title', 'clearHealth | Offers & Promotions')
@section('content')

<div class="app-content content">
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
    <div class="content-wrapper">
    <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Offers & Promotions</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Offers</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                    <a class="btn btn-secondry " href="{{ route('offers.index') }}">Back</a>
                </div>
            </div>
        </div>
    <div class="content-body">
        <div class="row" >
            <div class="col-lg-12">
                <section class="card">
                    {{--     <header class="card-header top-heading">
                        <h3 class="main-title-heading">   Edit Customer</h3> 
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('customers.index') }}"> Back</a>
                        </div>
                    </header> --}}
                    <div class="card-body">
                        <form action="{{ route('offers.update',$offer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')                    



                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Promocode</label><span class="required">*</span>
                                        {!! Form::text('promocode', $offer->promocode, array('placeholder' => 'Promocode','class' => 'form-control')) !!}
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
                                        {!! Form::text('promocode_value', $offer->promocode_value, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Description</label><span class="required">*</span>
                                        {!! Form::text('description', $offer->description , array('placeholder' => 'Description','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>From</label><span class="required">*</span>
                                        {!! Form::text('from_date',date('d-m-Y', strtotime($offer->from_date)), array('placeholder' => '','class' => 'form-control from_date', 'onblur' => 'checkdate()','id'=>'from_date')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>To</label><span class="required">*</span>
                                        {!! Form::text('to_date', date('d-m-Y', strtotime($offer->to_date)), array('placeholder' => '','class' => 'form-control to_date', 'onblur' => 'checkdate()','id'=>'to_date')) !!}
                                    </div>
                                </div>
                                
                            </div>


                            <div class="row">
                                <div class="col-lg-12 submit-buton text-right">
                                    <a  href="{{ route('offers.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
                                    <button type="submit" class="btn btn-secondry" data-dismiss="modal">Submit</button>
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
    <!-- </div> -->
    @endsection

    @section('headerSection')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <style>
      #imagePreview{
        width: auto;
        height: auto;
    } 
    .avatar-upload {
        position: relative;
        display: flex;
        align-items: center;
    }

    .avatar-upload .avatar-edit {
        position: absolute;
        right: 12px;
        z-index: 1;
        bottom: 30px;
        border: 3px solid #41cac0;
        border-radius: 50px;
    }

    .avatar-upload .avatar-edit input {
        display: none;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .avatar-upload .avatar-preview {
        position: relative;

    }

    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .select2-container {
        width: 100% !important;
    }

</style>
@endsection

@section('footerSection')
@jquery
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endsection

@section('scriptsection')
<script type="text/javascript">
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
