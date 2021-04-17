@extends('layouts.app')
@section('title', 'clearHealth | Roles')
@section('content')
<div class="app-content content">
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<style type="text/css">
    #parentfaqCategory, #parentcustomer, #parentdashboard, #parentuser, #parentrole, #parentcategory, #parentproduct, #parentcms, #parentblog, #parentfaq, #parenttag{
        cursor: pointer;
    }
    #faqCategory input, #customer input, #dashboard input, #user input, #role input, #category input, #product input, #cms input, #blog input, #faq input, #tag input{
        cursor: pointer;
    }
    #faqCategory label, #customer label, #dashboard label, #user label, #role label, #category label, #product label, #cms label, #blog label, #faq label, #tag label{
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Role</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Role Create</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
                <!-- <div class="pull-right">
                    <a class="btn btn-secondry " href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New User</a>
                </div> -->
                <div class="pull-right">
                        <a class="btn btn-secondry" href="{{ route('roles.index') }}"> Back</a>
                    </div>
            </div>
        </div>

<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                 <!-- <header class="card-header">
                   <h3 class="main-title-heading">Create New Role</h3> 
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div>
                </header>  -->
                <div class="card-body">
                {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row">
                      
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name</strong><span class="required">*</span>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        
                        
                                <strong>Permission:</strong><span class="required">*</span>
                                <br/>
                            </div>
                                <div class="col-md-3">
                                        <input id="parentdashboard" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#dashboard" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Dashboard
                                        </b>
                                        <div id="dashboard" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'dashboard'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <input id="parentuser" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#user" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        User
                                        </b>
                                        <div id="user" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'user'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentrole" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#role" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Role
                                        </b>
                                        <div id="role" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'role'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentcategory" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#category" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Category
                                        </b>
                                        <div id="category" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'category'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentproduct" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#product" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Product
                                        </b>
                                        <div id="product" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'product'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentcustomer" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#customer" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Customer
                                        </b>
                                        <div id="customer" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'customer'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentcms" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#cms" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Cms
                                        </b>
                                        <div id="cms" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'cms'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentblog" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#blog" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Blog
                                        </b>
                                        <div id="blog" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'blog'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentfaq" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#faq" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Faq's
                                        </b>
                                        <div id="faq" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'faq'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parentfaqCategory" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#faqCategory" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Faq's Category
                                        </b>
                                        <div id="faqCategory" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'faqCategory'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parenttag" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#tag" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Tag
                                        </b>
                                        <div id="tag" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'tag'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="parenttestimonial" type="checkbox"/> 
                                        <b data-toggle="collapse" data-target="#testimonial" aria-expanded="false" class="col-md-12" aria-controls="collapseOne">
                                        Testimonial
                                        </b>
                                        <div id="testimonial" aria-expanded="false" class="collapse"> 
                                            @foreach($permission as $key => $value)
                                            <?php
                                            $arr = explode("-", $value->name, 2);
                                            $first = $arr[0]; 
                                            if($first == 'testimonial'): ?>
                                            <div class="col-md-12">                                        
                                                <label class="col-md-12">{{ Form::checkbox('permission[]', $value->id, null, array('class' => $first)) }}
                                                {{ ucfirst($value->name) }}</label>                                        
                                            </div> 
                                            <?php
                                            endif;                                        
                                            ?>
                                            @endforeach
                                        </div>
                                    </div> 
                            </div>
                        <div class="col-lg-12 submit-buton text-right">
                            <a href="{{ route('roles.index') }}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </a>
                            <button type="submit" class="btn btn-secondry" data-dismiss="modal">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>
</div>

@endsection
@section('scriptsection')
<script type="text/javascript">
    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });

	if($('.blog:checked').length > 0){
		$('#parentblog').prop('checked', true);
	}else{
		$('#parentblog').prop('checked', false);
	}

	$("#parentblog").change(function(){
	    $('.blog').not(this).prop('checked', this.checked);
	});

	$(".blog").change(function(){
	    if($('.blog:checked').length > 0){
			$('#parentblog').prop('checked', true);
		}else{
			$('#parentblog').prop('checked', false);
		}
	});
// category checkbox
	if($('.category:checked').length > 0){
		$('#parentcategory').prop('checked', true);
	}else{
		$('#parentcategory').prop('checked', false);
	}

	$("#parentcategory").change(function(){
	    $('.category').not(this).prop('checked', this.checked);
	});

	$(".category").change(function(){
	    if($('.category:checked').length > 0){
			$('#parentcategory').prop('checked', true);
		}else{
			$('#parentcategory').prop('checked', false);
		}
	});
// cms checkbox
	if($('.cms:checked').length > 0){
		$('#parentcms').prop('checked', true);
	}else{
		$('#parentcms').prop('checked', false);
	}

	$("#parentcms").change(function(){
	    $('.cms').not(this).prop('checked', this.checked);
	});

	$(".cms").change(function(){
	    if($('.cms:checked').length > 0){
			$('#parentcms').prop('checked', true);
		}else{
			$('#parentcms').prop('checked', false);
		}
	});
// faq checkbox
	if($('.faq:checked').length > 0){
		$('#parentfaq').prop('checked', true);
	}else{
		$('#parentfaq').prop('checked', false);
	}

	$("#parentfaq").change(function(){
	    $('.faq').not(this).prop('checked', this.checked);
	});

	$(".faq").change(function(){
	    if($('.faq:checked').length > 0){
			$('#parentfaq').prop('checked', true);
		}else{
			$('#parentfaq').prop('checked', false);
		}
	});
// faqCategory checkbox
    if($('.faqCategory:checked').length > 0){
        $('#parentfaqCategory').prop('checked', true);
    }else{
        $('#parentfaqCategory').prop('checked', false);
    }

    $("#parentfaqCategory").change(function(){
        $('.faqCategory').not(this).prop('checked', this.checked);
    });

    $(".faqCategory").change(function(){
        if($('.faqCategory:checked').length > 0){
            $('#parentfaqCategory').prop('checked', true);
        }else{
            $('#parentfaqCategory').prop('checked', false);
        }
    });    
// product checkbox
	if($('.product:checked').length > 0){
		$('#parentproduct').prop('checked', true);
	}else{
		$('#parentproduct').prop('checked', false);
	}

	$("#parentproduct").change(function(){
	    $('.product').not(this).prop('checked', this.checked);
	});

	$(".product").change(function(){
	    if($('.product:checked').length > 0){
			$('#parentproduct').prop('checked', true);
		}else{
			$('#parentproduct').prop('checked', false);
		}
	});
// role checkbox
	if($('.role:checked').length > 0){
		$('#parentrole').prop('checked', true);
	}else{
		$('#parentrole').prop('checked', false);
	}

	$("#parentrole").change(function(){
	    $('.role').not(this).prop('checked', this.checked);
	});

	$(".role").change(function(){
	    if($('.role:checked').length > 0){
			$('#parentrole').prop('checked', true);
		}else{
			$('#parentrole').prop('checked', false);
		}
	});
// tag chekbox
	if($('.tag:checked').length > 0){
		$('#parenttag').prop('checked', true);
	}else{
		$('#parenttag').prop('checked', false);
	}

	$("#parenttag").change(function(){
	    $('.tag').not(this).prop('checked', this.checked);
	});

	$(".tag").change(function(){
	    if($('.tag:checked').length > 0){
			$('#parenttag').prop('checked', true);
		}else{
			$('#parenttag').prop('checked', false);
		}
	});
// testimonial checkbox
	if($('.testimonial:checked').length > 0){
		$('#parenttestimonial').prop('checked', true);
	}else{
		$('#parenttestimonial').prop('checked', false);
	}

	$("#parenttestimonial").change(function(){
	    $('.testimonial').not(this).prop('checked', this.checked);
	});

	$(".testimonial").change(function(){
	    if($('.testimonial:checked').length > 0){
			$('#parenttestimonial').prop('checked', true);
		}else{
			$('#parenttestimonial').prop('checked', false);
		}
	});
//user checkbox
	if($('.user:checked').length > 0){
		$('#parentuser').prop('checked', true);
	}else{
		$('#parentuser').prop('checked', false);
	}

	$("#parentuser").change(function(){
	    $('.user').not(this).prop('checked', this.checked);
	});

	$(".user").change(function(){
	    if($('.user:checked').length > 0){
			$('#parentuser').prop('checked', true);
		}else{
			$('#parentuser').prop('checked', false);
		}
	});

//dashboard checkbox
	if($('.dashboard:checked').length > 0){
		$('#parentdashboard').prop('checked', true);
	}else{
		$('#parentdashboard').prop('checked', false);
	}

	$("#parentdashboard").change(function(){
	    $('.dashboard').not(this).prop('checked', this.checked);
	});

	$(".dashboard").change(function(){
	    if($('.dashboard:checked').length > 0){
			$('#parentdashboard').prop('checked', true);
		}else{
			$('#parentdashboard').prop('checked', false);
		}
	});	

</script>
@endsection