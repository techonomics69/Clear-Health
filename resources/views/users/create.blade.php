@extends('layouts.app')
@section('title', 'clearHealth | User')
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
                <h3 class="content-header-title mb-0">Users</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">User Create</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
            <div class="pull-right">
                            <a class="btn btn-secondry" href="{{ route('users.index') }}"> Back</a>
                        </div>
            </div>
        </div>
    <div class="content-body">
        <div class=" user-create">
            <div class="row" >
                <div class="col-lg-12">
                    <section class="card">
                        {{-- <header class="card-header top-heading">

                        <h3 class="main-title-heading">Create New User</h3> 
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                        </div>
                        </header> --}}

                        <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="storeUser">
                            @csrf
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Name</label><span class="required">*</span>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Assign Role</label><span class="required">*</span>
                                        <select name="roles" id="roles" class="form-control" required>
                                            <option value="0">Select Role</option>
                                            @foreach($roles as $key => $role)
                                            <option {{ old('roles') == $key ? "selected" : "" }} value="{{$key}}" >{{ $role }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>User Status</label>
                                        <div class="checkbox-wrapper">
                                            <label class="checkbox-block"><span class="check-box-text">Active</span>
                                                <input type="checkbox" name="is_active" checked="checked" value="1">
                                                <span class="checkmark"></span>
                                            </label>                         
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="required">*</span>
                                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Contact Number</label><span class="required">*</span>
                                        {!! Form::text('mobile', null, array('placeholder' => 'Mobile','class' => 'form-control', 'maxlength'=>"10", 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
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
                            </div>

                            <p class="sub-heading">Address</p>
                            <div class="row">
                                <div class="col-lg-8 ">
                                    <div class="form-group">
                                        <label>Address Line</label><span class="required">*</span>
                                        {!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>State</label><span class="required">*</span>
                                        {!! Form::text('state', null, array('placeholder' => 'State','class' => 'form-control')) !!}                                
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>City:</label><span class="required">*</span>
                                        {!! Form::text('city', null, array('placeholder' => 'City','class' => 'form-control')) !!}  
                                        
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Zipcode</label><span class="required">*</span>
                                        {!! Form::text('pincode', null, array('placeholder' => 'Zipcode','class' => 'form-control', 'maxlength' => "6", 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                    </div>
                                </div>
                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label><span class="required">*</span>
                                        {!! Form::text('passwords', null, array('placeholder' => 'Password','class' => 'form-control', 'maxlength' => "15")) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label><span class="required">*</span>
                                        {!! Form::text('confirm-password', null, array('placeholder' => 'Password','class' => 'form-control', 'maxlength' => "15")) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 submit-buton text-right">
                                    <a  href="{{ route('users.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
                                    <button type="submit" class="btn btn-secondry" data-dismiss="modal" id="userSubmit">Submit</button>
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
</script>
@endsection