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
                    <h3 class="content-header-title mb-0">Permissions</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> Create Permission</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                        <a class="btn btn-secondry" href="{{ route('permissions.index') }}"> Back</a>
                    </div>
                </div> 
            </div>

            <div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <section class="card">                
                <div class="card-body">
                {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                    <div class="row">                      
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <span class="required">*</span>
                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']); !!}
                                    </div>
                                </div>    
								<div class="col-md-12 col-sm-12 col-xs-12">
                                    <!-- <div class="form-group">
                                        <strong>Parent Name:</strong>
                                        <span class="required">*</span>
                                        {!! Form::text('parent_name', null, ['placeholder' => 'Parent Name', 'class' => 'form-control']); !!}                                        
                                    </div> -->
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
</script>
@endsection