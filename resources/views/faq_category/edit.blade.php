@extends('layouts.app')
@section('title', "clearHealth | FAQ's category")
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
                        <h3 class="content-header-title mb-0">FAQ's</h3>
                        <div class="row breadcrumbs-top">
                                <div class="breadcrumb-wrapper col-12 d-flex">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"> Edit FAQ category</li>
                                    </ol>
                                </div>
                        </div>
                    </div>
                    <div class="content-header-right col-md-6 col-12 mb-2">
                    <div class="pull-right">
                            <a class="btn btn-secondry" href="{{ route('faqcategory.index') }}"> Back</a>
                        </div>
                    </div> 
                </div>

                <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <section class="card">                
                    <div class="card-body">
                    {!! Form::model($faq, array('route' => ['faqcategory.update', $faq->id],'method'=>'PATCH')) !!}
                        <div class="row">                      
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <strong>Title:</strong>
                                            <span class="required">*</span>
                                            {!! Form::text('title', null, ['placeholder' => 'Title', 'class' => 'form-control']); !!}
                                        </div>
                                    </div>                                    
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <strong>Status:</strong>
                                                <span class="required">*</span>
                                                {!! Form::select('status', ['0' => 'Please Select', '1' => 'On', '2' => 'Off'], null, ['class' => 'form-control']); !!}
                                            </div>
                                        </div>
                                                              
                          
                            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                <a href="{{ route('faqcategory.index') }}">
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
 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>  
<script type="text/javascript">
        tinymce.init({
            selector: 'textarea.answer',
            height: 400,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            advlist_bullet_styles: "square",
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
@endsection
