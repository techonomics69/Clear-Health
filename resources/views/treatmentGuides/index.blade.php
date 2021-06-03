@extends('layouts.app')
@section('title', 'clearHealth | Treatment Guides')

@section('content')

<div class="app-content content">
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

</body>
</html>

<div class="content-wrapper">
    <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">Treatment Guides</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> Treatment Guides List</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                @can('product-create')                    
                    <a class="btn btn-secondry" href="{{ route('treatmentGuides.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create Treatment Guides</a>
                @endcan    
                </div>
                </div>
            </div>
<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <div class="row" style="padding: 20px;">
                <div class="col-md-12">
            <table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="productsList">
                <thead>
                <tr>
                    <th width="60px">No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Upsell</th>
                    <th>Price</th>
                    <th width="200px">Action</th>
                </tr>
                </thead>
            </table>
                </div>
            </div>
        </section>
    </div>
</div>
</div>
</div>
@endsection

@section('scriptsection')
  
<script>
    $.noConflict();
    jQuery( document ).ready(function( $ ) {
        $('#productsList').DataTable({
            "dom": '<"top"if>rt<"bottom"lp><"clear">',
        });
    });
    
    function deleteProduct(e){
       swal({
        title: "Are you sure want to delete?",
        text: "You will not be able to recover this !",
        icon: "../public/icon/delete.png",
        imageSize: '60x60',          
        buttons: true,
        dangerMode: false,
        buttons: ["No, cancel Please!",'Yes, delete it!']
      }).then((willDelete) => {
            if (willDelete) {
                 $('.btn_delete'+e)[0].click();    
            } 
        });
    };
</script> 

@endsection


    