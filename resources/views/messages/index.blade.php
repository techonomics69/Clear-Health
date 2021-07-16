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
                            <div id="messages" class="tab-pane">
                                <div class="row" style="padding: 20px;">
                                    <div class="col-md-12">
                                        <section class="card">
                                            <ul class="nav nav-tabs" id="messages-tab-menu">
                                                <li><a class="btn active" data-toggle="tab" href="#medical">Medical Messgaes</a></li>
                                                <li><a class="btn nonmedicalmsg" data-toggle="tab" href="#nonmedical" onclick="Gotobottom();">Non-Medical Messgaes</a></li>
                                                <li><a class="btn support" data-toggle="tab" href="#support">Support</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="medical" class="tab-pane fade in active show">
                                                    <div class="row" style="padding: 10px;">
                                                        <div class="col-md-3">
                                                            <div class="right-cht">
                                                                <div class="chating-section">
                                                                    <ul>
                                                                        @foreach($mdList as $key => $name)
                                                                        <li class="userMdList" data-id="{{$name->case_id}}"><strong>{{$name->first_name}} {{$name->last_name}} - MD</strong>
                                                                            <p>{{$name->last_msg}}</p>
                                                                            <small>{{ $name->msg_time }}</small>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="right-cht">
                                                                <div class="chating-section medicalmessages">
                                                                    <h3 id="usernameLabel"></h3>
                                                                    <ul id="messageData"></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="support" class="tab-pane fane in support"></div>
                                                <div id="nonmedical" class="tab-pane fade in nonmedicalmsg">
                                                    @if(isset($message_data))
                                                    @if(count($message_data)>0)
                                                    @php
                                                    $lastMsg = (count($message_data) - 1);
                                                    @endphp
                                                    <a href="#bottomDivMsg{{$message_data[$lastMsg]['id']}}" style="display: none;" id="gotobottomdivmsg">scroll down</a>
                                                    @else
                                                    <a style="display: none;" id="gotobottomdivmsg">scroll down</a>
                                                    @endif
                                                    @endif
                                                    <div class="row" style="padding: 10px;">
                                                        <div class="col-md-3">
                                                            <div class="right-cht">
                                                                <div class="chating-section">
                                                                    <ul>
                                                                        @foreach($adminMsg as $key => $value)
                                                                        <li class="userMdList" data-id="{{$value->case_id}}"><strong>{{$value->first_name}} {{$value->last_name}} - Admin</strong>
                                                                            <p>{{$value->last_msg}}</p>
                                                                            <small>{{ $value->msg_time }}</small>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="right-cht">
                                                                {!! Form::open(array('method'=>'POST', 'enctype'=>"multipart/form-data", 'id'=>"msgForm")) !!}
                                                                <div class="chating-section nonmedicalmessages" id="chating-section">
                                                                    <ul><?php
                                                                        if (isset($message_data)) { ?>
                                                                            @foreach ($message_data as $key => $message)

                                                                            <li id="<?php if ($key == count($message_data) - 1) echo 'bottomDivMsg' . $message['id'] ?>" class=<?php if ($message['sender'] == 'admin') { ?>"right"<?php } else { ?> "left" <?php } ?>>
                                                                                <div class="time_messages">
                                                                                    <p class="text_mesg">
                                                                                        <?php
                                                                                        echo $message['message'];
                                                                                        if (isset($message['file_name']) && $message['file_name'] != '') {
                                                                                            echo "<br>";
                                                                                            $fileExt = explode(".", $message['file_name']);

                                                                                            $fileextArr = ['jpg', 'jpeg', 'png'];
                                                                                            if (count($fileExt) > 0) {
                                                                                                if (in_array($fileExt[1], $fileextArr)) {
                                                                                        ?>
                                                                                                    <img src="{{ asset('public/Message_files/'.$message['file_name']) }}" type="media_type" width='100'>
                                                                                                    <a target="_blank" download="" href="{{ asset('public/Message_files/'.$message['file_name']) }}"> Download</a>
                                                                                                <?php
                                                                                                } else {
                                                                                                    switch ($fileExt[1]) {
                                                                                                        case "doc":
                                                                                                            $fileName = asset("public/images/msgs/doc.png");
                                                                                                            break;
                                                                                                        case "docx":
                                                                                                            $fileName = asset("public/images/msgs/doc.png");
                                                                                                            break;
                                                                                                        case "xls":
                                                                                                            $fileName = asset("public/images/msgs/xls.png");
                                                                                                            break;
                                                                                                        case "xlsx":
                                                                                                            $fileName = asset("public/images/msgs/xls.png");
                                                                                                            break;
                                                                                                        case "txt":
                                                                                                            $fileName = asset("public/images/msgs/txt.png");
                                                                                                            break;
                                                                                                        case "pdf":
                                                                                                            $fileName = asset("public/images/msgs/pdf.png");
                                                                                                            break;
                                                                                                        default:
                                                                                                            $fileName = asset("public/images/msgs/file.png");
                                                                                                            break;
                                                                                                    }
                                                                                                ?>
                                                                                                    <img src="{{ $fileName }}" type="media_type" width='100'>
                                                                                                    <a target="_blank" download="" href="{{ asset('public/Message_files/'.$message['file_name']) }}"> Download</a>
                                                                                        <?php
                                                                                                }
                                                                                            } else {
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </p>

                                                                                    <h5>
                                                                                        <?php
                                                                                        if (isset($message['date']) && $message['date'] != '') {
                                                                                            echo $message['date'];
                                                                                        } ?>
                                                                                    </h5>
                                                                                </div>
                                                                            </li>


                                                                            @endforeach

                                                                        <?php } ?>
                                                                    </ul>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="p-2 pl-4">
                                                                            <img id="blah" src="#" alt="your image" style="display: none; height: 120px;
									width: 250px;" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="last-typing-section" class="last-typing-section">
                                                                    <div class="attachment lastimg pinclip">
                                                                        <div class="variants">
                                                                            <div class='file'>
                                                                                <label for='file'>
                                                                                    <img src="{{asset('public/images/paperclip.png')}}" alt="">

                                                                                </label>
                                                                                <input id="file" type="file" name="file" onchange="loadFile(event)">

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="search">

                                                                        <input class="form-control" type="text" name="text" placeholder="Type a message..." id="text">
                                                                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                                                        <input type="hidden" name="user_id" value="{{$user_case_management_data['user_id']}}" id="user_id">
                                                                        <input type="hidden" name="case_id" value="{{$user_case_management_data['id']}}" id="case_id">

                                                                    </div>
                                                                    <div class="sending lastimg">
                                                                        <button type="submit" id="btnsubmit"><img src="{{asset('public/images/telegram.png')}}" alt=""></button>
                                                                        <button type="button" id="spinnerdiv" style="display:none">
                                                                            <span class="fa fa-spinner fa-spin"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="support" class="tab-pane fane in support">

                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@section('scriptsection')

<script>
    $.noConflict();
    jQuery(document).ready(function($) {
        $('.userMdList').on('click', function() {
            var case_id = $(this).attr('data-id');
            $.ajax({
                url: "{{route('getMedicalMessage')}}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    case_id: case_id
                },
                success: function(result) {
                    $('#usernameLabel').html(result.username);
                    $('#messageData').html(result.html);
                    $("#messageData").animate({
                        scrollTop: $("#messageData")[0].scrollHeight
                    }, 1000);
                }
            });
        })
    });
</script>
@endsection