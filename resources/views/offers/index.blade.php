@extends('admin.layouts.app')


@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif

<div class="row" >
	<div class="col-lg-12">
		<section class="card">
			
			<div class="row"  style="padding: 20px;">
				<div class="col-md-12">
					<table class="table" id="offerList">
						<thead>
						<tr>
							<th>No</th>
							<th>Title</th>
							<th>description</th>
							<th>Start Date</th>
							<th>End Date</th>
							@canany(['offer_edit', 'offer_delete'])
							<th width="280px">Action</th>
							@endcanany
							
						</tr>
						</thead>
						<tbody>
						@php $i = 0; @endphp
						@foreach ($data as $key => $offer)
						
						<tr>
							<td>{{ ++$i }}</td>  
							<td>{{ $offer->title }}</td>
							<td>{{ $offer->description }}</td>
							<td>{{ $offer->from_date}}</td>
							<td>{{$offer ->to_date}}</td>
							<td>
								{{-- <a class="btn btn-info" href="{{ route('admin.show',$user->id) }}">Show</a> --}}
								<form action="{{ url('admin/offers/delete',$offer->id) }}" method="POST" enctype="multipart/form-data">
									
										@csrf
										
										<button type="submit" class="btn_submit{{$offer->id}}" style="display:none;"></button>

										@can('offer_edit')
										<a class="btn btn-light edit-icon" href="{{ route('offers.edit',$offer->id) }}"><i class="fa fa-edit"></i></a>
										@endcan
										
										@can('offer_delete')
										<a class="btn btn-light edit-icon user_delete" href="javascript:void(0)" id="{{$offer->id}}" onclick="deleteoffer({{$offer->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a>
										@endcan
										
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

	{{-- <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p> --}}
	@endsection

	@section('footerSection')
	<script src="{{asset('public/js/sweetalert.min.js')}}"></script>  
	<script>
	$.noConflict();
	jQuery( document ).ready(function( $ ) {
    	$('#offerList').DataTable();
	});
		function deleteoffer(e){
			swal({
				title: "Are you sure?",
				text: "",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
				if (willDelete) {
					$('.btn_submit'+e)[0].click();    
				} 
			});
		};
	</script>
	@endsection
