@extends('layouts.app')

@section('title', 'clearHealth | Offers & Promotions')
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
				<h3 class="content-header-title mb-0">Offers & Promotions</h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12 d-flex">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">Offers & Promotions List</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
				<div class="pull-right">

					<a class="btn btn-secondry" href="{{route('offers.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New Offer</a>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="card">
					<div class="row" style="padding: 20px;">
						<div class="col-md-12">
							<table class="table table-responsive-md table-striped table-bordered " style="width:100%" id="offerpromotion">
								<thead>
									<tr>
										<th width="60px">SR No</th>
										<th>No</th>
										<th>Promocode</th>
										<th>Description</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th width="200px">Action</th>
									</tr>
								</thead>
								<tbody>
									@php $i = 0; @endphp
									@foreach ($data as $key => $offer)
									<tr>
										<td>{{ ++$i }}</td>  
										<td>{{ $offer->promocode }}</td>
										<td>{{ $offer->description }}</td>
										<td>{{ $offer->from_date}}</td>
										<td>{{$offer ->to_date}}</td>
										<td>
											<form action="{{ url('offers/delete',$offer->id) }}" method="POST" enctype="multipart/form-data">

												@csrf

												<button type="submit" class="btn_submit{{$offer->id}}" style="display:none;"></button>

												
												<a class="btn btn-light edit-icon" href="{{ route('offers.edit',$offer->id) }}"><i class="fa fa-edit"></i></a>
											
											
												<a class="btn btn-light edit-icon user_delete" href="javascript:void(0)" id="{{$offer->id}}" onclick="deleteoffer({{$offer->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a>
												

											</form>
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
		$('#offerpromotion').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
			"oSearch": { "bSmart": false, "bRegex": true }
		});
	});
</script>
@endsection


