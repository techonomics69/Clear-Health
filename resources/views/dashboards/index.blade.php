@extends('layouts.app')

@section('title', 'clearHealth | Dashboard')

@section('sidebar')
@parent
@endsection

@section('content')
	<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <!-- Stats -->
      <div class="row">
        <!-- <div class="col-xl-3 col-lg-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="media align-items-stretch">
                <div class="p-2 text-center bg-primary bg-darken-2">
                  <i class="icon-camera font-large-2 white"></i>
                </div>
                <div class="p-2 bg-gradient-x-primary white media-body">
                  <h5>Products</h5>
                  <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> 28</h5>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <div class="col-xl-3 col-lg-6 col-12">
          <div class="card">
            <div class="card-content">
              <a href="{{ route('users.index') }}">
              <div class="media align-items-stretch">
                <div class="p-2 text-center bg-danger bg-darken-2" style="background-color: #323232 !important;">
                  <i class="icon-user font-large-2 white"></i>
                </div>
                <div class="p-2  white media-body" style="background-color: #323232 !important;">
                  <h5>Users</h5>
                  <h5>{{ $users }}</h5>
                </div>
              </div>
            </a>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12">
          <div class="card">
            <div class="card-content">
              <a href="{{ route('customers.index') }}">
              <div class="media align-items-stretch">
                <div class="p-2 text-center bg-danger bg-darken-2" style="background-color: #323232 !important;">
                  <i class="icon-user font-large-2 white"></i>
                </div>
                <div class="p-2  white media-body" style="background-color: #323232 !important;">
                  <h5>Customers</h5>
                  <h5>{{ $customer }}</h5>
                </div>
              </div>
            </a>
            </div>
          </div>
        </div>

        
       
      </div>
      <!--/ Stats -->
      
    </div>
    <!--/ Social & Weather -->
    <!-- Basic Horizontal Timeline -->
    
    <!--  New Widget should here -->

    <!--/ Basic Horizontal Timeline -->
  </div>
</div>

@endsection