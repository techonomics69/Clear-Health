@extends('layouts.app')
@section('title', 'clearHealth | Treatment Guides')
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
                <h3 class="content-header-title mb-0">Treatment Guides</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Treatment Guides</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                    <a class="btn btn-secondry" href="{{ route('treatmentGuides.index') }}"> Back</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-lg-12">
                    <section class="card">
                 <!-- <header class="card-header">
                   <h3 class="main-title-heading">Create New Product</h3> 
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                    </div>
                </header>  -->
                <div class="card-body">
                    {!! Form::open(array('route' => 'treatmentGuides.store','method'=>'POST', 'enctype'=>"multipart/form-data")) !!}
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <strong>Title:</strong>
                                <span class="required">*</span>
                                {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <strong>Sub Title:</strong>
                                {!! Form::text('sub_title', null, array('placeholder' => 'Sub Title','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <strong>Status:</strong>
                                <span class="required">*</span>
                                {!! Form::select('status', ['0' => 'Please Select', '1' => 'Acive',  '2' => 'In Active'], null, ['class' => 'form-control']); !!}
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <strong>Guides Details:</strong>
                                <span class="required">*</span>
                                {!! Form::textarea('detail', null, array('placeholder' => 'Details','class' => 'details')) !!}
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <strong>Image:</strong>
                                <span class="required">*</span>
                                {!! Form::file('guides_image', null, array('class' => 'form-control')) !!}                                        
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                        <a href="{{ route('treatmentGuides.index') }}">
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
@endsection