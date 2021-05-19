@extends('layouts.app')

@section('title', 'clearHealth | Ordermanagement')
@section('content')

<div class="app-content content">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Order Management</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Order Management List</li>
                        </ol>
                    </div>
                </div>
            </div>
                <!-- <div class="content-header-right col-md-6 col-12 mb-2">
                        <div class="pull-right">
                                     
                            <a class="btn btn-secondry" href="{{ route('mdmanagement.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Md Management</a>
                       
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card" >
                            <div class="row" style="padding: 20px;">
                                <div class="col-md-12">
                                   <table class="table table-responsive-md table-striped table-bordered " style="width:100%" id="ordermanagement">
                                    <thead>
                                        <tr>
                                            <th width="60px">SR No</th>
                                            <th>Order Id</th>
                                            <th>Case Id</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                            <th>Product Name</th>
                                            <th>Order Type</th>
                                            <!--  <th>Order Status</th> -->
                                            <th width="200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;?>
                                        @foreach ($order as $key => $order_data)
                                        <tr> 
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $order_data['order_id'] }} </td>
                                            <!-- <td>{{ $order_data->order_id }}</td> -->
                                            <td>{{ $order_data->case_id }}</td>

                                            <td>{{ $order_data->email }}</td>
                                            <td>{{ $order_data->created_at }}</td>
                                            <td>{{ $order_data->product_name }}</td>

                                            <!-- <td>{{ $order_data->product_price }}</td>  -->
                                            <!--  <td>{{ $order_data->total_amount }}</td> -->
                                            <td><?php if($order_data->medication_type == 1){
                                                echo "Prescribed";
                                            }else{
                                                echo "Non Prescribed";
                                            } ?></td>

                                            <td>
                                                <div class="d-flex">
            <a class="icons edit-icon" href="{{ route('ordermanagement.show',$order_data->case_id) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    

                                <!-- <a class="icons edit-icon" href="">
                                    <i class="fa fa-edit"></i>
                                </a> -->
                                <!-- <a class="icons edit-icon category_delete" href="#" id="" onclick="">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a> -->
                                <!-- <button type="submit" class="btn btn-danger btn_delete" style="display:none;">Delete</button>  -->                               
                            </div>                      
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
        $('#ordermanagement').DataTable({
            "dom": '<"top"if>rt<"bottom"lp><"clear">',
            "oSearch": { "bSmart": false, "bRegex": true }
        });
    });
</script>
@endsection


