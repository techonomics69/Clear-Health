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
                                                             

                                <!-- <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>User Status</label>
                                        <div class="checkbox-wrapper">
                                            <label class="checkbox-block"><span class="check-box-text">Active</span>
                                                <input type="checkbox" name="is_active" checked="checked" value="1">
                                                <span class="checkmark"></span>
                                            </label>                         
                                        </div>
                                    </div>
                                </div> -->

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

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <strong>Available Date:</strong>
                                        <span class="required">*</span>
                                        {!! Form::text('available_date', null, array('placeholder' => 'Available Date','class' => 'form-control available_date', 'readonly' => 'readonly')) !!}
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

    });
</script>
@endsection