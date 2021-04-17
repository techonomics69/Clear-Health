@extends('layouts.app')

@section('title', 'clearHealth | Mdmanagement')
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
                    <h3 class="content-header-title mb-0">Md Management</h3>
                    <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12 d-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Md Management List</li>
                                </ol>
                            </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-2">
                        <div class="pull-right">
                                     
                            <a class="btn btn-secondry" href="{{ route('mdmanagement.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Md Management</a>
                       
                        </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <section class="card" >

                    
                    <div class="row" style="padding: 20px;">
                        <div class="col-md-12">
                    <table class="table table-responsive-md table-striped table-bordered " style="width:100%" id="Mdmanagement">
                        <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Language</th>
                            <th width="200px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>
                        @foreach ($mdmanagement as $key => $mdmanagement_data)
                        <tr> 
                            
                            <td>{{ $i++ }}</td>
                            <td>{{ $mdmanagement_data->name }}</td>
                            <td>
                                <img src="{{ asset('public/images/Mdmanagement/'.$mdmanagement_data->image) }}" alt="Md Management Image" title="Md Management Image" width="100px">
                            </td>
                            <td>
                        @if($mdmanagement_data->status =='1')   
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">InActive</span>
                        @endif
                    </td>
                            <td>

                        @if(!empty($mdmanagement_data->languages))
                            {{ $mdmanagement_data->languages}}
                        @endif
                    </td>
                            <td>

                            <div class="d-flex">
                                
                                <a class="icons edit-icon" href="{{ route('mdmanagement.show',$mdmanagement_data->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>        
                                
                                @can('category-edit')                    
                                <a class="icons edit-icon" href="{{route('mdmanagement.edit',$mdmanagement_data->id) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endcan
                                {!! Form::open(['method' => 'DELETE','route' => ['mdmanagement.destroy', $mdmanagement_data->id],'style'=>'display:inline']) !!}
                                   
                                    <a class="icons edit-icon category_delete" href="#" id="{{$mdmanagement_data->id}}" onclick="deleteMdmanagement({{$mdmanagement_data->id}})">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn_delete{{$mdmanagement_data->id}}" style="display:none;">Delete</button>
                                {!! Form::close() !!}
                                
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
        $('#Mdmanagement').DataTable({
            "dom": '<"top"if>rt<"bottom"lp><"clear">',
            "oSearch": { "bSmart": false, "bRegex": true }
        });
    });
    
    function deleteMdmanagement(e){
       swal({
        title: "Are you sure want to delete?",
        text: "If you delete this category, it's also delete all products releated to this category ",
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


    