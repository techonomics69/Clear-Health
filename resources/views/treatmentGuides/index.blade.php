@extends('layouts.app')

@section('title', 'clearHealth | Treatement Guides')
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
                            <table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="treatmentguidesList">
                                <thead>
                                    <tr>
                                        <th width="60px">No</th>
                                        <th>Title</th>
                                        <th>Sub title</th>
                                        <th>Status</th>
                                        <th width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($treatmentguides as $key => $guides)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $guides->title }}</td>
                                        <td>{{ $guides->sub_title }}</td>

                                        <td>
                                            @if($guides->status =='1')   
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">In Active</span>
                                            @endif
                                        </td>
                                       <td>
                                    <div class="d-flex">
                                    <a class="icons edit-icon" href="{{ route('treatmentGuides.show',$guides->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a> 
                                    @can('cms-edit')    
                                    <a class="icons edit-icon" href="{{ route('treatmentGuides.edit',$guides->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('cms-delete')                          
                                    {!! Form::open(['method' => 'DELETE','route' => ['treatmentGuides.destroy', $guides->id],'style'=>'display:inline']) !!}
                                        <a class="icons edit-icon cms_delete" href="#" id="{{$guides->id}}" onclick="deleteguides({{$guides->id}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn_delete{{$guides->id}}" style="display:none;">Delete</button>
                                    {!! Form::close() !!}
                                    @endcan 
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
        $('#treatmentguidesList').DataTable({
            "dom": '<"top"if>rt<"bottom"lp><"clear">',
        });
    });
    
    function deleteguides(e){
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


