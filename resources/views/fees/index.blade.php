@extends('layouts.app')
@section('title', "clearHealth | Fees")

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
				<h3 class="content-header-title mb-0">Fees</h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12 d-flex">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">Fees List</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
				<div class="pull-right">	
					{{-- @can('fee-create')		 --}}		
					<a class="btn btn-secondry" href="{{ route('fees.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Fee</a>
					{{-- @endcan	 --}}	
				</div>
			</div>
		</div>
		<section class="basic-elements">
			<div class="content-body">
				<div class="row">
					<div class="col-lg-12">
						<section class="card" >						
							<div class="row" style="padding: 20px;">
								<div class="col-md-12">
									<table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="feeList">
										<thead>
											<tr>
												<th width="60px">No</th>
												<th>Title</th>
												<th>Amount</th>	
												<th>Type</th>												
												<th width="200px">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; ?>
											@foreach ($fees_data as $key => $fees)

											<?php
											$fee_type = $fees->fee_type;

											switch ($fee_type) {
												case "accutane":
												$type = "Accutane";
												break;
												case "topical_follow_up":
												$type = "Topical follow up";
												break;
												case "accutane_follow_up":
												$type ="Accutane Follow Up";
												break;
												case "accutane_refilled":
												$type = "Accutane Refilled";
												break;
												case "topical_refilled":
												$type ="Topical Refilled";
												break;
												default:
												$type = "Topical";
											}
											?>
											<tr>
												<td>{{ $i++ }}</td>
												<td>{{ $fees->title }}</td>
												<td>{{ $fees->amount }}</td>
												<td>{{ $type }}</td>								
												<td>
													<div class="d-flex">
									{{-- <a class="icons edit-icon" href="{{ route('fees.show',$fees->id) }}">
										<i class="fa fa-eye"></i>
									</a>  --}}
									{{-- @can('tag-edit')	 --}}
									<a class="icons edit-icon" href="{{ route('fees.edit',$fees->id) }}">
										<i class="fa fa-edit"></i>
									</a>
									{{-- @endcan
										@can('tag-delete')	 --}}						
										{!! Form::open(['method' => 'DELETE','route' => ['fees.destroy', $fees->id],'style'=>'display:inline']) !!}
										<a class="icons edit-icon fees_delete" href="#" id="{{$fees->id}}" onclick="deleteFees({{$fees->id}})">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
										<button type="submit" class="btn btn-danger btn_delete{{$fees->id}}" style="display:none;">Delete</button>
										{!! Form::close() !!}	
										{{-- @endcan --}}
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
</section>
</div>

</div>
@endsection

@section('scriptsection')

<script>
	$.noConflict();
	jQuery( document ).ready(function( $ ) {
		$('#feeList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
		});
	});
	
	function deleteFees(e){
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


