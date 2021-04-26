@extends('layouts.app')
@section('title', 'clearHealth | mdmanagement')
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
                <h3 class="content-header-title mb-0">Md Management</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                                <li class="breadcrumb-item active">Create Md </li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
            <div class="pull-right">
                        <a class="btn btn-secondry" href="{{route('mdmanagement.index')}}"> Back</a>
                    </div>
            </div>
        </div>
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                  

                <div class="card-body">
                {!! Form::open(array('route' => 'mdmanagement.store','method'=>'POST', 'enctype'=>"multipart/form-data")) !!}
                    <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    <span class="required">*</span>
{!! Form::select('status', ['0' => 'Please Select', '1' => 'Active', '2' => 'In-Active'], null, ['class' => 'form-control']); !!}
                                </div>
                            </div>
                                
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <span class="required">*</span>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Language:</strong>
                                    <span class="required">*</span> 
                {!! Form::select('language_id[]', $language,null, array('class' => 'form-control','id'=>'language_id', 'multiple'=>'multiple')) !!}
                                </div>
                            </div>
                                
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <strong>Image:</strong>
                                        <span class="required">*</span><br>
                                        {!! Form::file('image', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                                                                       
                   </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <a href="{{ route('mdmanagement.index') }}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </a>
                            <button type="submit" class="btn btn-secondry" data-dismiss="modal">Submit</button>
                        </div>
                        {!! Form::close() !!}
                </div>
                </div>
            </section>
        </div>
    </div>
 </div>
</div>
</div>

@endsection

@section('scriptsection')
<script type="text/javascript">
    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });

$(document).ready(function() {
    $('#language_id').select2({
         placeholder: "Select a Language",
            allowClear: true
    }); 
});

</script>
@endsection

<!-- @section('scriptsection')
<script type="text/javascript">
    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });
    $(document).ready(function() {
        $(function () {
            $('.available_date').datepicker();
        });
    });
</script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>  
<script type="text/javascript">
        tinymce.init({
            selector: 'textarea.details',
            height: 500,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css',
            branding: false,
            init_instance_callback : function(editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            }
        });    
    
</script>
@endsection -->