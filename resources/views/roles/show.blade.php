@extends('layouts.app')

@section('title', 'clearHealth | Roles')
@section('content')


<div class="app-content content">
<div class="content-wrapper">
<div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Role</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">show role list</li>
                            </ol>
                        </div>
                </div>
            </div>
             <div class="content-header-right col-md-6 col-12 mb-2">
                <div class="pull-right">
                    <a class="btn btn-secondry " href="{{ route('roles.index') }}"> Back</a>
                </div>
            </div> 
</div>



        <div class="content-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2> Show Role</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                            </div>
                        </div>
                    </div> -->


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <section class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $role->name }}
                            </div>
                            <div class="form-group">
                                <strong>Permissions:</strong>
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $v)
                                        <span class="badge badge-success">{{ ucfirst($v->name) }}</span>,                                       
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </section>
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-12">
                    
                </div>
            </div>

        </div>
</div>
</div>


@endsection