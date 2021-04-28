@extends('layouts.app')
@section('title', 'clearHealth | Products')

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
                    <h3 class="content-header-title mb-0">Products</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> Product List</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                @can('product-create')                    
                    <a class="btn btn-secondry" href="{{ route('products.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Product</a>
                @endcan    
                </div>
                </div>
            </div>
<div class="row">
    <div class="col-lg-12">
        <section class="card">

            <!-- <div class="col-lg-12 margin-tb card-header ">
                <div class="pull-left">
                    <h2 class="main-title-heading">Products</h2>
                </div>
                <div class="pull-right">                    
                    <a class="btn btn-secondry" href="{{ route('products.create') }}">&plus; Create New Product</a>
                </div>
            </div> 
             -->
            <!-- <div class="card-body progress-card">
                <div class="task-progress">
                    <input class="form-control input-small" type="" name="search" />
                </div>
            </div> -->
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
                <tbody>
                @foreach ($products as $key => $product)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if(!empty($product->category))
                            {{ $product->category->name }}
                        @endif
                    </td>
                    <td>
                        @if($product->status =='1')   
                            <span class="badge badge-success">In Stock</span>
                        @else
                            <span class="badge badge-danger">Out Of Stock</span>
                        @endif
                    </td>
                   <td>
                    <?php if($product->upsell == 'Yes') { ?>
                       <input type="radio" name="yes" id="{{$product->id}}" value="YES" onchange="enableTxt(this)" checked="checked"></td>

                    <?php } else { ?>
                    <input type="radio" name="yes" id="{{$product->id}}" value="YES" onchange="enableTxt(this)"></td>
                    <?php }?>
                     
                    <td>{{ number_format($product->price, 2, '.', ',') }}</td>
                    <td>
                        <a class="icons edit-icon" href="{{ route('products.show',$product->id) }}">
                            <i class="fa fa-eye"></i>
                        </a>        
                        @can('product-edit')                     
                        <a class="icons edit-icon" href="{{ route('products.edit',$product->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>  
                        @endcan                                                                                                                                                                                    
                        @can('product-delete')                          
                        {!! Form::open(['method' => 'DELETE','route' => ['products.destroy', $product->id],'style'=>'display:inline']) !!}
                            <a class="icons edit-icon product_delete" href="#" id="{{$product->id}}" onclick="deleteProduct({{$product->id}})">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                            <button type="submit" class="btn btn-danger btn_delete{{$product->id}}" style="display:none;">Delete</button>
                        {!! Form::close() !!}    
                        @endcan                       
                    </td>
                </tr>
                @endforeach
                </tbody>
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

<script>
    function enableTxt(elem) {
    var id = $(elem).attr("id");
    //alert(id);
    $.ajax({ 
       type:"POST", 
        
        url:"{{ route('products.upsell') }}",
        data:{
        "_token": "{{ csrf_token() }}",
        "id": id
        }, 
        success: function(response){
        toastr.success('Upsell Upadated');
      }
    });
}
</script>
@endsection


    