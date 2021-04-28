@extends('layouts.app')
@section('title', 'clearHealth | Products')

@section('content')
<div class="app-content content">

<div class="content-wrapper">
    <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">Product</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> Show Product</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
            <a class="btn btn-secondry" href="{{ route('products.index') }}"> Back</a>
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
            <strong>Name:</strong>
            {{ $product->name }}
        </div>
        <div class="form-group">
            <strong>Status:</strong>
            @if($product->status =='1')   
                <span class="badge badge-success">In Stock</span>
            @else
                <span class="badge badge-danger">Out Of Stock</span>
            @endif
        </div>
        <div class="form-group">
            <strong>Available Date:</strong>

            {{ date('d/m/Y', strtotime($product->available_date))  }}
        </div>
        <div class="form-group">
            <strong>Category:</strong>
            @if(!empty($product->category))
                {{ $product->category->name }}
            @else
                <span style="color: red">Not Assigned or Category was deleted  </span>      
            @endif
        </div>
        <div class="form-group">
            <strong>Price (Retail):</strong>
            {{ $product->retails_price }}
        </div>
        <div class="form-group">
            <strong>Short Description:</strong>
            {!! $product->short_description !!}
        </div>
        <div class="form-group">
            <strong>Description:</strong>
            {!! $product->detail !!}
        </div>
        <div class="form-group">
            <strong>Quantity:</strong>
            {{ $product->quantity }}
        </div>
        <div class="form-group">
            <strong>Minimum Quantity Alert:</strong>
            {{ $product->min_quantity_alert }}
        </div>
        <div class="form-group">
            <strong>URL:</strong>
            <a href="{{ $product->url }}" target="_blank"> 
	            {{ $product->url }}
	        </a>
        </div>
        <div class="form-group">
            <strong>Price:</strong>            
            {{ number_format($product->price, 2, '.', ',') }}
        </div>
        <div class="form-group">
            <strong>Weight:</strong>
            {{ $product->weight }} {{ $product->weight_unit }}
        </div>
<div class="form-group">
            <strong>Product Status:</strong>
            @if($product->product_active =='1')   
                <span class="badge badge-success">Active</span>
            @elseif($product->product_active =='2')
                <span class="badge badge-danger">InActive</span>
            @else
                <span class="badge badge-danger">Do Not Show</span>
            @endif
        </div>
        <div class="form-group">
            <strong>Image:</strong>
            <img src="{{ asset('public/images/Products/'.$product->image) }}" alt="Product Image" title="Product Image" width="200px">            
        </div>
        
    </div>
</section>
</div>
</div>
</div>
</div>
</div>

@endsection