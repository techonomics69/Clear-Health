@extends('layouts.app')
@section('title', "clearHealth | QuestionCategory")
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

    <div class="content-wrapper">
        <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">Question's</h3>
                        <div class="row breadcrumbs-top">
                                <div class="breadcrumb-wrapper col-12 d-flex">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"> Edit Question</li>
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
                    <div class="card-body">
                    {!! Form::model($quiz, array('route' => ['quiz.update', $quiz->id],'method'=>'PATCH')) !!}
                        <div class="row">                      
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <strong>Question:</strong>
                                            <span class="required">*</span>
                                            {!! Form::text('question', null, ['placeholder' => 'Question', 'class' => 'form-control']); !!}
                                        </div>
                                    </div>     
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Sub Heading</strong>
                                {!! Form::text('sub_heading', null, array('placeholder' => 'sub_heading','class' => 'form-control')) !!}
                            </div>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Option Type</strong>
                                {!! Form::select('options_type', ['0' => 'Please Select', 'radio' => 'Radio Button', 'checkbox' => 'Checkbox', 'text' => 'Text', 'number' => 'Number','textarea' => 'Textarea'], null, ['class' => 'form-control', 'id' => 'optionType']); !!}
                            </div>                            
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6" id="minmaxnumber" style="@if($quiz['options_type'] != 'number') display: none @endif">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Min Number</strong>
                                        {!! Form::number('min_number', null, array('placeholder' => 'Min Number','class' => 'form-control', 'min' => '0')) !!}
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Max Number</strong>
                                        {!! Form::number('max_number', null, array('placeholder' => 'Max Number','class' => 'form-control', 'min' => '0')) !!}
                                    </div> 
                                </div>
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
                        <strong>YES</strong> <input type="radio" name="sub_question" class="sub_que" id="{{ $quiz->sub_question}}" value="{{ $quiz->sub_question}}"  <?php if($quiz->sub_question == 'Yes') { echo "checked = checked";}?> onclick="show1();" />
                            
                        <strong>NO</strong> <input type="radio" name="sub_question" id="{{ $quiz->sub_question}}" value="{{ $quiz->sub_question}}" <?php if($quiz->sub_question == 'No') { echo "checked = checked";}?>  onclick="show1();" />
                                </div>
                            </div>
                             <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                              
                        <div id="div1" class="hide" style="display: none">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group" >
                                    <strong>Display Parent Question</strong>
                                    <span class="required">*</span>
                                    <select class="form-control" name="parent_question" id="parent_question">
                                        <option value="" class="form-control">Select Question</option>
                                        @foreach ($question as $key => $questions)
                                        <option value="{{ $key }}" class="form-control" <?php if( $question_select[0]->parent_question_id == $key ) { echo "selected = selected"; }?> > {{ $questions }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <strong>Options</strong>
                                    <span class="required">*</span>
                                    <select name="option_answer" id="option_answer" class="form-control">
                                         @foreach ($question_select as $que)
                                    <option value="{{ $que->option_select }}" class="form-control"> {{ $que->option_select }} </option> 
                                      @endforeach 
                                    </select>
                                    
                                </div>
                            </div>
</div>                       
<!-- </div> -->
                            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Is this question used for Product Recommendation?</strong>
                                    <span class="required">*</span>
    <strong>YES</strong> <input type="radio" class="product_rec" id="{{ $quiz->use_for_recommendation}}" name="product_recommendation" value="{{ $quiz->use_for_recommendation}}"  <?php //if( $quiz->use_for_recommendation == 'Yes') { //echo "checked = checked";}?>   onclick="show2();" />
                                    
    <strong>NO</strong> <input type="radio" name="product_recommendation" id="{{ $quiz->use_for_recommendation}}" value="{{ $quiz->use_for_recommendation}}" <?php //if( $quiz->use_for_recommendation == 'No') { //echo "checked = checked";}?> onclick="show2();" />
                                  </div>
                            </div> -->

                        <!-- <div class="col-md-6 col-sm-6 col-xs-12 hide" id="div2" style="display: none">
                                <div class="form-group">
                                    <strong>Product Recommendation</strong>
                                    <span class="required">*</span>
                                    <select class="form-control" name="recommendation_product">
                                    <option value="{{ $quiz->recommendation_product }}" class="form-control"> {{ $quiz->recommendation_product }} </option> 
                                    <option value="Accutane">Accutane</option>
                                    <option value="Topical Cream">Topical Cream</option>
                                   
                                </select>
                                </div>
                            </div>  -->                              
                         
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
<div class="modal fade" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Option</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="addOption">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addOptionBtn">Add</button>
      </div>
    </div>
  </div>
</div>
@section('scriptsection') 
<script type="text/javascript"> 

//alert($(".sub_que").val());
var sub_que = $(".sub_que").val();

    if(sub_que == 'Yes'){
    document.getElementById('div1').style.display ='block';
    }else{
    document.getElementById('div1').style.display = 'none';
    }

    $('form').submit(function(){
        $(this).find('button[type=submit]').prop('disabled', true);
    });

//alert($(".product_rec").val());
/*var product_rec = $('.product_rec').val();

    if(product_rec == 'Yes'){
         document.getElementById('div2').style.display ='block';
     }else{
        document.getElementById('div2').style.display = 'none';
     }*/

    $(function() {
        $('#optionType').change(function(){
            if($(this).val() == 'number'){
                $('#minmaxnumber').show();
            }else{
                $('#minmaxnumber').hide();
            }
        });
    });

/*function show1()
{
    alert($(".sub_que").val());
    if($(this).val() == 'Yes'){
    document.getElementById('div1').style.display ='block';
    }else{
    document.getElementById('div1').style.display = 'none';
    }
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
