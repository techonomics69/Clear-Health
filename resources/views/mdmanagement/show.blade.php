@extends('layouts.app')
@section('title', 'clearHealth | mdmanagement')

@section('content')



<div class="app-content content">

<div class="content-wrapper">
    <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">Md Management</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Show Md</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('mdmanagement.index') }}"> Back</a>
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
            <strong>First Name:</strong>
            {{ $mdmanagement->first_name }}
        </div>

        <div class="form-group">
            <strong>Last Name:</strong>
            {{ $mdmanagement->last_name }}
        </div>

        <div class="form-group">
            <strong>Expertise:</strong>
            {{ $mdmanagement->expertise }}
        </div>

        <div class="form-group">
            <strong>Title:</strong>
            {{ $mdmanagement->title }}
        </div>

         <div class="form-group">
            <strong>Education:</strong>
            {{ $mdmanagement->education }}
        </div>

         <div class="form-group">
            <strong>License Number:</strong>
            {{ $mdmanagement->license_number }}
        </div>

        <div class="form-group">
            <strong>States Licensed to Practice In:</strong>
            {{ $mdmanagement->states_licensed_to_practice }}
        </div>

         <div class="form-group">
            <strong>Credentials:</strong>
            {{ $mdmanagement->credentials}}
        </div>

        <div class="form-group">
            <strong>Status:</strong>
            @if($mdmanagement->status =='1')   
                <span class="badge badge-success">Active</span>
            @else
                <span class="badge badge-danger">InActive</span>
            @endif
        </div>                     

        <div class="form-group">
            <strong>Image:</strong>
            <img src="{{ asset('public/images/Mdmanagement/'.$mdmanagement->image) }}" alt="Mdmanagement Image" title="Mdmanagement Image" width="200px">            
        </div>
        
    </div>
</section>
</div>
</div>
</div>
</div>
</div>

@endsection