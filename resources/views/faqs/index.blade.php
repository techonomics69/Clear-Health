@extends('layouts.app')
@section('title', "clearHealth | FAQ's")

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
				<h3 class="content-header-title mb-0">FAQ's</h3>
				<div class="row breadcrumbs-top">
						<div class="breadcrumb-wrapper col-12 d-flex">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active">FAQ's List</li>
							</ol>
						</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
			<div class="pull-right">	
			@can('faq-create')				
					<a class="btn btn-secondry" href="{{ route('faqs.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Create New FAQ</a>
			@endcan		
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
						<table class="table  table-responsive-md table-striped table-bordered" style="width:100%" id="faqList">
							<thead>
							<tr>
								<th width="60px">No</th>
								<th>Question</th>
								<th>Status</th>													
								<th width="200px">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($faqs as $key => $faq)
							<tr>
								<td>{{ ++$i }}</td>
								<td>{{ $faq->question }}</td>
								<td>
									@if($faq->status == 1)
										<span class="badge badge-success">On</span>
									@else
										<span class="badge badge-danger">Off</span>	
									@endif 
								</td>								
								<td>
									<div class="d-flex">
									<a class="icons edit-icon" href="{{ route('faqs.show',$faq->id) }}">
										<i class="fa fa-eye"></i>
									</a> 
									@can('faq-edit')	
									<a class="icons edit-icon" href="{{ route('faqs.edit',$faq->id) }}">
										<i class="fa fa-edit"></i>
									</a>
									@endcan
									@can('faq-delete')							
									{!! Form::open(['method' => 'DELETE','route' => ['faqs.destroy', $faq->id],'style'=>'display:inline']) !!}
										<a class="icons edit-icon faq_delete" href="#" id="{{$faq->id}}" onclick="deletefaq({{$faq->id}})">
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
										<button type="submit" class="btn btn-danger btn_delete{{$faq->id}}" style="display:none;">Delete</button>
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
</section>
</div>

</div>
@endsection

@section('scriptsection')
  
<script>
	$.noConflict();
	jQuery( document ).ready(function( $ ) {
    	$('#faqList').DataTable({
			"dom": '<"top"if>rt<"bottom"lp><"clear">',
		});
	});
	
	function deletefaq(e){
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


	