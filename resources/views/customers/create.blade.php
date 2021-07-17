@extends('layouts.app')
@section('title', 'clearHealth | Customer')
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
                <h3 class="content-header-title mb-0">Customers</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Customer Create</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
            <div class="pull-right">
                            <a class="btn btn-secondry" href="{{ route('customers.index') }}"> Back</a>
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
                        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" id="storeCustomer">
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
                                        <label>First Name</label><span class="required">*</span>
                                        {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
                                    </div>
                                </div>

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name</label><span class="required">*</span>
                                        {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                  <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Gender</label><span class="required">*</span>
                                        <select id="inputState" name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option {{ old('gender') == 'male' ? "selected" : "" }} value="male">Male</option>
                                            <option {{ old('gender') == 'female' ? "selected" : "" }} value="female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Birth Date:</label><span class="required">*</span>
                                        {!! Form::text('dob', null, array('placeholder' => '','class' => 'form-control','id'=>'dob')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="required">*</span>
                                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id'=>'email')) !!}
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Address Line</label><span class="required">*</span>
                                        {!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control')) !!}
                                    </div>
                                </div>
                          

                                
                               
                                {{--  <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label><span class="required">*</span>
                                        {!! Form::password('passwords', array('placeholder' => 'Password','class' => 'form-control', 'maxlength' => "15","id"=>"password")) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label><span class="required">*</span>
                                        {!! Form::password('confirm-password', array('placeholder' => 'Password','class' => 'form-control', 'maxlength' => "15","id"=>"confirm_password")) !!}
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 submit-buton text-right">
                                    <a  href="{{ route('customers.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
                                    <button type="button" class="btn btn-secondry" id="userSubmit">Submit</button>
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
        

</script>
@endsection
@section('scriptsection')
<script type="text/javascript">
   $(document).ready(function ($) {
    $("#dob").datepicker({
                //numberOfMonths: 2,
                minDate: new Date(),
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate());
                },
                dateFormat : 'yy-mm-dd'
            });
     });

    $(document).on('click', '#userSubmit', function() {
            var passflag = false;
            var passregex = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&].{7,30}/;
            var emailregex = /[^\s@]+@[^\s@]+\.[^\s@]+/;
            var email = $("#email").val();
           // var password = $("#password").val();
            //var c_password = $("#confirm_password").val();
            if(email == '' || email == null){
                toastr["error"]("Please enter email address");
                passflag = false;
            }else if(!emailregex.test(email)){
                toastr["error"]("Please enter valid email address");
                passflag = false;
            }/*else if(password == '' || password == null){
                toastr["error"]("Please enter password");
                passflag = false;
            }else if(!passregex.test(password)){
                toastr["error"]("Password must contain at least 8 characters [ one uppercase, lowercase, number & special character");
                passflag = false;
            }else if(c_password == '' || c_password == null){
                toastr["error"]("Please enter confirm password");
                passflag = false;
            }else if(!passregex.test(c_password)){
                toastr["error"]("Password must contain at least 8 characters [ one uppercase, lowercase, number & special character");
                passflag = false;
            }else if(c_password !== password){
                toastr["error"]("confirm password not matched password");
                passflag = false;    
            }*/else{
                passflag = true;
            }
            
            if(passflag){
                $(this).html('Loading..').attr('disabled','disabled');
                $('#storeCustomer').submit();
            }
            
        });

    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });
</script>
@endsection