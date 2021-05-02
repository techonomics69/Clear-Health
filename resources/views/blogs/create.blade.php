@extends('layouts.app')

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
                    <h3 class="content-header-title mb-0">Blogs</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> Create Blog</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                        <a class="btn btn-secondry" href="{{ route('blog.index') }}"> Back</a>
                    </div>
                </div> 
            </div>

            <div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <section class="card">                
                <div class="card-body">
                {!! Form::open(array('route' => 'blog.store','method'=>'POST', 'enctype'=>"multipart/form-data")) !!}
                    <div class="row">                      
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <strong>Title:</strong>
                                        <span class="required">*</span>
                                        {!! Form::text('title', null, ['placeholder' => 'Title', 'class' => 'form-control']); !!}
                                    </div>
                                </div> 
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <strong>Author Name:</strong>
                                        <span class="required">*</span>
                                        {!! Form::text('author', null, ['placeholder' => 'Author name', 'class' => 'form-control']); !!}
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <!-- <strong>Most Popular</strong> -->
                                        <br>
                                        <span>&nbsp;</span>
                                        <input type="checkbox" name="most_popular" id="most_popular" value="1">&nbsp;<b>Most Popular&nbsp;</b>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <strong>Read time</strong>
                                        <span class="required">*</span>
                                        <div class="row">
                                            <div class="col-md-4">
                                                Hour
                                                <input type="number" name="hour" id="minute" class="form-control" min="1">
                                            </div>
                                            <div class="col-md-4">
                                                Minute
                                                <input type="number" name="minute" id="minute" class="form-control" min="1" max="59">
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <strong>Body:</strong>
                                        <span class="required">*</span>
                                        {!! Form::textarea('body', null, array('placeholder' => 'Body','class' => '')) !!}
                                    </div>
                                    
                                    <div class="form-group myfrom">
                                        <strong>Tag:</strong>
                                        <sp    an class="required">*</span>
                                        {!! Form::select('tags[]', $tags, null,['class' => 'form-control ', 'multiple'=>"true", 'id' => 'tags']) !!}
                                        
                                    </div>                                    

                                    <div class="form-group">
                                        <strong>Image</strong><span class="required">*</span><br>
                                        <input type="file" name="image[]" class="form-control" multiple="">
                                    </div>

                                    <div class="form-group">
                                        <strong>Author Image</strong><span class="required">*</span><br>
                                        {!! Form::file('author_image', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                                          
                      
                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <a href="{{ route('blog.index') }}">
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
    $("#tags").select2({
        placeholder: "Select a Tag",
        allowClear: true,        
      });
</script>
<style>
    .myfrom .select2-container {
    width: 100% !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li:after {
    content: "\f107 ";
    position: absolute;
    top: 10px;
    right: 16px;
    font-family: 'FontAwesome';
    }
     .select2-container--default.select2-container--open .select2-selection--multiple .select2-selection__rendered li:after{
        transform: rotate(180deg);
    }
    .select2-container--default .select2-selection--multiple .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-top: 0px;
    margin-right: 28px;
    font-size: 26px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    background-color: transparent;
    border: none;
    border-right: 1px solid #aaa;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    color: #999;
    cursor: pointer;
    font-size: 1em;
    font-weight: bold;
    padding: 0 4px;
    position: absolute;
    left: 0;
    top: 0;
    display: none;
}
    </style>

 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>  
<script type="text/javascript">
        tinymce.init({
            selector: 'textarea',
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
   
    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });
</script>
<style>
    .select2-selection.select2-selection--multiple{
        display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    }
    li.select2-search.select2-search--inline{
        display: flex;

    }
    <style>
@endsection