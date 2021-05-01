@extends('layouts.app')
@section('title', 'clearHealth | Questions')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
<div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Question</h3>
                <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active"> Create Question</li>
                            </ol>
                        </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-2">
            <div class="pull-right">
                        <a class="btn btn-secondry" href="{{ route('quiz.index') }}"> Back</a>
                    </div>
            </div>
        </div>
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                 <!-- <header class="card-header">
                   <h3 class="main-title-heading">Create New Category</h3> 
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
                    </div>
                </header>  -->
                <div class="card-body">
                {!! Form::open(array('route' => 'quiz.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Question</strong><span class="required">*</span>
                                {!! Form::text('question', null, array('placeholder' => 'Question','class' => 'form-control')) !!}
                            </div>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Sub Heading</strong>
                                {!! Form::text('sub_heading', null, array('placeholder' => 'Sub Heading','class' => 'form-control')) !!}
                            </div>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Option Type</strong>
                                {!! Form::select('options_type', ['0' => 'Please Select', 'radio' => 'Radio Button', 'checkbox' => 'Checkbox', 'text' => 'Text', 'textarea' => 'Textarea'], null, ['class' => 'form-control']); !!}
                            </div>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Options</strong>(to add the multiple choices (comma separated))
                                {!! Form::text('option', null, array('placeholder' => 'Option','class' => 'form-control')) !!}                                
                            </div>                            
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    <span class="required">*</span>
                                    {!! Form::select('status', ['0' => 'Please Select', '1' => 'On', '2' => 'Off'], null, ['class' => 'form-control']); !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Category:</strong>
                                    <span class="required">*</span>
                                    {!! Form::select('category_id', ['0'=>'Please Select'] + $category, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Is this Sub Question?</strong>
                                    <span class="required">*</span>
                            <strong>YES</strong> <input type="radio" name="sub_question" value="Yes" onclick="show1();" />
                            <strong>NO</strong> <input type="radio" name="sub_question"value="No" onclick="show2();" />
                                </div>
                            </div>
                       <!--  <div class="col-xs-12 col-sm-12 col-md-12"> -->
                        <div id="div1" class="hide" style="display: none">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group" >
                                    <strong>Select Parent Question</strong>
                                    <span class="required">*</span>
                                    <select class="form-control" name="parent_question" id="parent_question">
                                        <option value="" class="form-control">Select Question</option>
                                        @foreach ($question as $key => $questions)
                                        <option value="{{ $key }}" class="form-control">{{ $questions }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Options</strong>
                                    <span class="required">*</span>
                                    <select name="option_answer" id="option_answer" class="form-control"></select>
                                </div>
                            </div>
                        </div>
<!-- </div> -->
                            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Is this question used for Product Recommendation?</strong>
                                    <span class="required">*</span>
                                    <strong>YES</strong> <input type="radio" name="product_recommendation" value="Yes" onclick="show3();" />
                                    <strong>NO</strong> <input type="radio" name="product_recommendation" value="No" onclick="show4();" />
                                  </div>
                            </div> -->

                        <!-- <div class="col-md-6 col-sm-6 col-xs-12 hide" id="div2" style="display: none">
                                <div class="form-group">
                                    <strong>Product Recommendation</strong>
                                    <span class="required">*</span>
                                    <select class="form-control" name="recommendation_product">
                                    <option>Please Select</option>
                                    <option value="Accutane">Accutane</option>
                                    <option value="Topical Cream">Topical Cream</option>
                                </select>
                                </div>
                            </div> -->
                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <a href="{{ route('quiz.index') }}">
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


function show1(){
  document.getElementById('div1').style.display ='block';
}
function show2(){
  document.getElementById('div1').style.display = 'none';
}
/*function show3(){
  document.getElementById('div2').style.display ='block';
}
function show4(){
  document.getElementById('div2').style.display = 'none';
}*/


$(document).ready(function () { 

    $('#parent_question').change(function(){
    var parent_question = $(this).val();
 
    if(parent_question){
        $.ajax({
           type:"GET",
           url:"{{ route('quiz.option') }}?id="+parent_question,
           success:function(res){               
            if(res){
                $("#option_answer").empty();
                $("#option_answer").append('<option>Select Options</option>');
                $.each(res,function(key,value){
                    $("#option_answer").append('<option value="'+value+'">'+value+'</option>');
                }); 
            }else{
               $("#option_answer").empty();
            }
           }
        });
    }else{
        $("#option_answer").empty();
    }      
   });
});
</script>
@endsection