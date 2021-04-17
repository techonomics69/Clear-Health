@extends('layouts.app')

@section('title', 'clearHealth | Customer')
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
                <h3 class="content-header-title mb-0">Customers</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit customer</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                    <a class="btn btn-secondry " href="{{ route('customers.index') }}">Back</a>
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
                        <form action="{{ route('customers.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')                    



                            <div class="row">
                                
                                

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="required">*</span>
                                        {!! Form::text('email', $user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12 submit-buton text-right">
                                    <a  href="{{ route('customers.index') }}"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
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
