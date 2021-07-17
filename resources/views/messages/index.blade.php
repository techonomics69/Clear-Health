@extends('layouts.app')

@section('title', 'clearHealth | Messages')
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
                <h3 class="content-header-title mb-0">Messages</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Messages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <section class="card">
                    <div class="row" style="padding: 20px;">
                        <div class="col-md-12">
                        <table class="table table-responsive table-striped table-bordered" style=" width:100%" id="CaseManagementList">
                  <thead>
                    <tr>
                      <th>SR</th>
                      <th>Date</th>
                      <th>CaseID</th>
                      <th>FirstName</th>
                      <th>LastName</th>                      
                      <th>VisitNumber</th>
                      <th>MDCaseID</th>
                      <th>CaseStatus</th>
                      <th>MDStatus</th>
                      <th>VisitType</th>
                      <th>TreatmentPlan</th>                      
                      <th>Action</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        @foreach($user_case_management_data as $key => $value):                        
                        <td>{{$key+1}}</td>
                        <td>{{$value->created_at}}</td>
                        <td>{{$value->ref_id}}</td>
                        <td>{{$value->first_name}}</td>
                        <td>{{$value->last}}</td>                        
                        <td>
                            @if(empty($value->follow_up):
                            1
                            @else
                            {{$value->follow_up + 1}}
                            @endif
                        </td>
                        <td>{{$value->md_case_id}}</td>
                        <td>{{$value->system_status}}</td>
                        <td>{{$value->md_case_status}}</td>
                        <td>@if(empty($value->follow_up):
                            Initial
                            @else
                            Follow up {{$value->follow_up}}
                            @endif</td>
                        <td>{{$value->product_type}}</td>
                        <td></td>
                        @endforeach
                    </tr>
                  </tbody>
                </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>