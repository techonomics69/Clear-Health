@extends('layouts.app')
@section('title', 'clearHealth | Offers & Promotions')
@section('content')
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
                                        <label>Title</label><span class="required">*</span>
                                        {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
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
                                        {!! Form::text('from_date', null, array('placeholder' => '','class' => 'form-control from_date')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>To</label><span class="required">*</span>
                                        {!! Form::text('to_date', null, array('placeholder' => '','class' => 'form-control to_date')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Offer Type</label><span class="required">*</span>
                                        {!! Form::select('offer_type', ['0'=>'Please Select','1'=>'Promocode'], null, ['class' => 'form-control'],['id' => 'offer_type']) !!}
                                    </div>
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
<script type="text/javascript">     
    $(document).on('click', '#userSubmit', function() {
        $(this).html('Loading..').attr('disabled','disabled');
        $('#storeUser').submit();
    });



</script>
@endsection
@section('scriptsection')
<script type="text/javascript">
    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });

    $(document).ready(function() {
        $(function () {
            $('.from_date').datepicker();
        });

        $(function () {
            $('.to_date').datepicker();
        });


        $('#offer_type').on('change', function (e) {
            //var optionSelected = $("option:selected", this);

            //$('.offer_percentage').hide();
            //$('.offer_amount').hide();
            //$('.offer_gift').hide();
            //$('.offer_addon').hide();
            $('.promocode_section').hide();

            var valueSelected = this.value;

            if(valueSelected == 1){
                $('.promocode_section').show();
            }
            
        });

    });
</script>
@endsection