@extends('layouts.app')
@section('title', 'clearHealth | Quiz')

@section('content')
<div class="app-content content">

<div class="content-wrapper">
    <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">Quiz</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> Show Quiz</li>
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
<!-- <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Show Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div>
</div> -->

<div class="content-body">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
    <section class="card">
           
           <div class="card-body">
        <div class="form-group">
            <strong>Question:</strong>
            {{ $quiz->question }}
        </div>
        <div class="form-group">
            <strong>Sub Heading:</strong>
            {{ $quiz->sub_heading }}
        </div>
        <div class="form-group">
            <strong>Option Type:</strong>
            {{ ucfirst($quiz->options_type) }}
        </div>
        <div class="form-group">
            <strong>Option:</strong>
            {{ $quiz->option}}
        </div>
        <div class="form-group">
            <strong>Sub Question:</strong>
            @foreach ($question_select as $question)
            {{ $question->question}}
            @endforeach
        </div>
        <div class="form-group">
            <strong>Sub Question Option:</strong>
            @foreach ($question_select as $options)
            {{ $options->option_select }}
            @endforeach
        </div>
        <div class="form-group">
            <strong>Status:</strong>
            @if($quiz->status =='1')   
                <span class="badge badge-success">On</span>
            @else
                <span class="badge badge-danger">Off</span>
            @endif
        </div>
        <div class="form-group">
            <strong>Category:</strong>
            @if(!empty($quiz->category))
                {{ $quiz->category->name }}
            @else
                <span style="color: red">Not Assigned or Category was deleted  </span>      
            @endif
        </div>        
    </div>
</section>
</div>
</div>
</div>
</div>
</div>

@endsection