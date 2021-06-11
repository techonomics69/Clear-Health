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
										<td>{{ $offer->to_date}}</td>
										<td>
										

									

												 <a class="icons edit-icon" href="{{ route('offers.edit',$offer->id) }}"><i class="fa fa-edit"></i></a>


												{!! Form::open(['method' => 'DELETE','route' => ['offers.destroy', $offer->id],'style'=>'display:inline']) !!}
												<a class="icons edit-icon customer_delete" href="#" id="{{$offer->id}}" onclick="deleteCustomer({{$offer->id}})">
													<i class="fa fa-trash" aria-hidden="true"></i>
												</a>

												<button type="submit" class="btn_delete{{$offer->id}}" style="display:none;"></button>               
												{!! Form::close() !!}

												{{-- <a class="btn btn-light edit-icon user_delete" href="javascript:void(0)" id="{{$offer->id}}" onclick="deleteoffer({{$offer->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a> --}}
												

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

	function deleteCustomer(e){
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


