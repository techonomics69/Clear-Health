@extends('layouts.app')

@section('title', 'clearHealth | Ipledge')
@section('content')

<div class="app-content content">
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif

	<style type="text/css">
		#ipledge-tab-menu li a.active{
			background-color: #43bfc1;
			color: #ffffff;
		}

		thead input {
			width: 100%;
		}

		.text-download-file{
			color: #0732d0 
		}
	</style>

	@if(session()->has('que_current_tab'))
	@php
	$current_tab_id = 'home'.session()->get('que_current_tab') ;
	$activeTab = 1;
	$active = 1 ;

   // unset($products[$key]);
	@endphp
	@else
	@php
	$current_tab_id = "";
	$activeTab = 0 ;
	$active = 0 ;	
	@endphp
	@endif

	@php
	Session::forget('que_current_tab');
	@endphp


	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Ipledge Imports</h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12 d-flex">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">All</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
				<div class="pull-right">
					{{-- @can('quiz-create')		 --}}			
					<a class="btn btn-secondry" href="{{ route('ipledgeimports.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Upload Ipledge ID's </a>
					{{-- @endcan	 --}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="card" >
					<ul class="nav nav-tabs" id="ipledge-tab-menu">
						<li><a class="btn active" data-toggle="tab" href="#csv_import">CSV import</a></li>
						<li><a class="btn" data-toggle="tab" href="#all">All</a></li>

						{{-- <li><a class="btn" data-toggle="tab" href="#home2">Assigned</a></li>

						<li><a class="btn" data-toggle="tab" href="#home3">Unassigned</a></li> --}}

					</ul>
					<div class="tab-content">
						
						<div id="all" class="tab-pane fade in">					    
							
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<table class="table table-responsive-md table-striped table-bordered ipledgeListAll" style="width:100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Patient ID</th>
												<th>Assigned To</th>
												<th>Patient Name</th>
												<th>Gender</th>
												<th>Patient Type</th>
												{{-- <th>Patient Status</th> --}}
												<th>Date</th>
											</tr>
										</thead>
										<tbody>	
										<?php $i = 1; ?>			
										@foreach($ipledge_data as $key => $data)
										<tr>
											<td>{{$i++}}</td>
											<td>{{ $data->patient_id}}</td>
											<td>{{($data->user_case_id1 != '') ? $data->user_case_id : '-'}}</td>
											<td>{{ $data->patient_name}}</td>
											<td>{{ $data->gender}}</td>
											<td>{{ ($data->patients_type) ==0 ? "CanNotPregnant" :"CanPregnant"}}</td>
											{{-- <td>{{ ($data->assigned_by !='') ? "Assigned" : "Unassigned"}}</td> --}}
											<td><?php if($data->assigned_date !=''){echo date('d-m-Y', strtotime($data->assigned_date));}else{echo "-";}  ?></td>

										</tr>
										@endforeach
									</tbody>

									<tfoot>
										{{-- <tr>
											<th>ID</th>
											<th>Patient ID</th>
											<th>AssignedTo</th>
											<th>Patient Name</th>
											<th>Gender</th>
											<th>Patient Type</th>
											<th>Patient Status</th>
											<th>Date</th>
										</tr> --}}
									</tfoot>
								</table>
							</div>
						</div>
					</div>  
				


					<!--start code tab2-->
					{{-- <div id="home2" class="tab-pane fade in">					    
						<div class="row" style="padding: 20px;">
							<div class="col-md-12">
								<table class="table table-responsive-md table-striped table-bordered ipledgeList" style="width:100%">
									<thead>
										<tr>
											<th width="60px">No2</th>
											<th>Name</th>
											<th width="200px">Action</th>
										</tr>
									</thead>
									<tbody>					
										
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										
										</tbody>
									</table>
								</div>
							</div>
						</div>  
					 --}}
						<!--end code tab2-->

						<!--tab3-->
						{{-- <div id="home3" class="tab-pane fade in">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<table class="table table-responsive-md table-striped table-bordered ipledgeList" style="width:100%">
										<thead>
											<tr>
												<th width="60px">No3</th>
												<th>Name</th>
												<th width="200px">Action</th>
											</tr>
										</thead>
										<tbody>					
											
											<tr>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										
										</tbody>
									</table>
								</div>
							</div>
						</div>  --}}


						<!--end of tab3-->

						<!--tab4-->
						<div id="csv_import" class="tab-pane fade in active show">
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<table class="table table-responsive-md table-striped table-bordered ipledgeList" style="width:100%">
										<thead>
											<tr>
												<th width="60px">Files</th>
												<th width="60px">Patient Type</th>
												<th width="60px">Imported By</th>
												<th width="200px">Imported date</th>
											</tr>
										</thead>
										<tbody>					
											@foreach($ipledgehistory_data as $key1 => $data1)
											<tr>
												<td><a class="text-download-file" href="{{route('IpledgefileDownload',$data1['id'])}}" target="_blank">{{-- <i class="fa fa-download" aria-hidden="true"></i> --}} {{$data1['files']}}</a></td>
												<td>{{ ($data1['patients_type'] == 0) ? "CanNotPregnant" :"CanPregnant"}}</td>
												<td>{{$data1['imported_by']}}</td>
												<td>{{$data1['created_at']}}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div> 
					</div>

					<!--end of tab4-->
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


	$('.ipledgeListAll thead tr').clone(true).appendTo( '.ipledgeListAll thead' );
    $('.ipledgeListAll thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

	var table = $('.ipledgeListAll').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"oSearch": { "bSmart": false, "bRegex": true },
			orderCellsTop: true,
        	fixedHeader: true
		});

	 $('.ipledgeList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"oSearch": { "bSmart": false, "bRegex": true },
			orderCellsTop: true,
        	fixedHeader: true
		});
	});
	
	function deleteQuiz(e){
		swal({
			title: "Are you sure want to delete?",
			text: "If you delete this Quiz, it's not recoverable ",
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


