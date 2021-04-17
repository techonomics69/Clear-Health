@extends('layouts.app')

@section('title', 'clearHealth | User')
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
                <h3 class="content-header-title mb-0">Users</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit user</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                    <a class="btn btn-secondry " href="{{ route('users.index') }}">Back</a>
                </div>
            </div>
        </div>
    <div class="content-body">
        <div class="row" >
            <div class="col-lg-12">
                <section class="card">
                    {{--     <header class="card-header top-heading">
                        <h3 class="main-title-heading">   Edit User</h3> 
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                        </div>
                    </header> --}}
                    <div class="card-body">
                        <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')                    



                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Name</label><span class="required">*</span>
                                        {!! Form::text('name', $user->name, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Assign Role</label><span class="required">*</span>
                                        <select name="roles" id="roles" class="form-control" required>
                                            <option value="0">Select Role</option>
                                            @foreach($roles as $key => $role)
                                            <option {{ old('roles') == $key ? "selected" : "" }} value="{{$key}}" @if($key == $user->role) selected @endif>{{ $role }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>User Status</label>
                                        <div class="checkbox-wrapper">
                                            <label class="checkbox-block"><span class="check-box-text">Active</span>
                                                <input type="checkbox" name="is_active" @if($user->status == 1) checked="checked" @endif value="1">
                                                <span class="checkmark"></span>
                                            </label>                         
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="required">*</span>
                                        {!! Form::text('email', $user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Contact Number</label><span class="required">*</span>
                                        {!! Form::text('mobile', $user->mobile, array('placeholder' => 'Mobile','class' => 'form-control', 'maxlength'=>"10", 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Gender</label><span class="required">*</span>
                                        <select id="inputState" name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option {{ old('gender') == 'male' ? "selected" : "" }} value="male" @if($user->gender == "male") selected @endif>Male</option>
                                            <option {{ old('gender') == 'female' ? "selected" : "" }} value="female" @if($user->gender == "female") selected @endif>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <p class="sub-heading">Address</p>
                            <div class="row">
                                <div class="col-lg-8 ">
                                    <div class="form-group">
                                        <label>Address Line</label><span class="required">*</span>
                                        {!! Form::text('address', $user->address, array('placeholder' => 'Address','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>State</label><span class="required">*</span>
                                         {!! Form::text('state', $user->state, array('placeholder' => 'State','class' => 'form-control')) !!}                                     
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>City</label><span class="required">*</span>
                                         {!! Form::text('city', $user->city, array('placeholder' => 'City','class' => 'form-control')) !!}                                     
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Zipcode</label><span class="required">*</span>
                                        {!! Form::text('pincode', $user->zip, array('placeholder' => 'Pincode','class' => 'form-control', 'maxlength' => "6", 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 submit-buton text-right">
                                    <a  href="{{ route('users.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
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
<script type="text/javascript">
    //$('#roles').select2();
    function getCity(stateID){
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
        }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    // $("#imageUpload").change(function () {
    //     readURL(this);
    // });

    $(document).on('click','.btnUpload',function(){
        $("#userImg").click();
    });

</script>
@endsection
