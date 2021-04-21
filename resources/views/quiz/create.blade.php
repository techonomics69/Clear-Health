@extends('layouts.app')
@section('title', 'clearHealth | Questions')
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
				<h3 class="content-header-title mb-0">Question</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active"> Create Question</li>
							</ol>
						</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
            <div class="pull-right">
                        <a class="btn btn-secondry" href="{{ route('quiz.index') }}"> Back</a>
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
                {!! Form::open(array('route' => 'quiz.store','method'=>'POST')) !!}
                    <div class="row">
                      
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Question</strong><span class="required">*</span>
                                {!! Form::text('question', null, array('placeholder' => 'Question','class' => 'form-control')) !!}
                            </div>                            
                        </div>
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Answer</strong>
                                {!! Form::text('answer', null, array('placeholder' => 'Answer','class' => 'form-control')) !!}
                            </div>                            
                        </div> --}}
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Option Type</strong>
                                {!! Form::select('options_type', ['0' => 'Please Select', 'radio' => 'Radio Button', 'checkbox' => 'Checkbox', 'text' => 'Text', 'textarea' => 'Textarea'], null, ['class' => 'form-control']); !!}
                            </div>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Options</strong>(to add the multiple choices (comma separated))
                                {!! Form::text('option', null, array('placeholder' => 'Option','class' => 'form-control')) !!}                                
                            </div>                            
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    <span class="required">*</span>
                                    {!! Form::select('status', ['0' => 'Please Select', '1' => 'On', '2' => 'Off'], null, ['class' => 'form-control']); !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Category:</strong>
                                    <span class="required">*</span>
                                    {!! Form::select('category_id', ['0'=>'Please Select'] + $category, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <a href="{{ route('quiz.index') }}">
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