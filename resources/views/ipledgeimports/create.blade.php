@extends('layouts.app')
@section('title', 'clearHealth | Ipledge')
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
				<h3 class="content-header-title mb-0">Ipledge Imports</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active"> Imports Ipledge</li>
							</ol>
						</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
            <div class="pull-right">
                        <a class="btn btn-secondry" href="{{ route('ipledgeimports.index') }}"> Back</a>
                    </div>
			</div>
		</div>
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                 <!-- <header class="card-header">
                   <h3 class="main-title-heading">Create New Category</h3> 
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
                    </div>
                </header>  -->
                <div class="card-body">
                {!! Form::open(array('route' => 'import','method'=>'POST','enctype'=>"multipart/form-data")) !!}
                    <div class="row">
                      
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Import File</strong><span class="required">*</span><br>
                                {!! Form::file('files', null, array('class' => 'form-control')) !!}
                            </div>                          
                       
                        <div class="form-group">
                                <strong>Imported By</strong><span class="required">*</span>
                                {!! Form::text('imported_by', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                      
                            <div class="form-group">
                                <strong>Patients Type</strong>
                                {!! Form::select('patients_type', ['' => 'Please Select', '0' => 'Can Not Pregnant', '1' => 'Can Pregnant'], null, ['class' => 'form-control']); !!}
                            </div>                            
                        </div>
                      
                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <a href="{{ route('ipledgeimports.index') }}">
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