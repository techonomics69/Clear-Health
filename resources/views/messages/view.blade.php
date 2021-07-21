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
                                                <li><a class="btn nonmedicalmsg" data-toggle="tab" href="#nonmedical">Non-Medical Messgaes</a></li>
                                                <li><a class="btn support" data-toggle="tab" href="#supportMsg">Support</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="medical" class="tab-pane fade in active show">
                                                    <div class="row" style="padding: 10px;">
                                                        <div class="col-md-3">
                                                            <div class="right_chating">
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
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="right-cht ">
                                                                <div class="chating-section medicalmessages">
                                                                    <h3 id="usernameLabel"></h3>
                                                                    <ul id="messageData"></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="nonmedical" class="tab-pane fade in nonmedicalmsg">
                                                    <div class="row" style="padding: 10px;">
                                                        <div class="col-md-3">
                                                            <div class="right_chating">
                                                                <div class="right-cht">
                                                                    <div class="chating-section">
                                                                        <ul>
                                                                            @foreach($adminMsg as $key => $value)
                                                                            <li class="userAdminList" data-id="{{$value->user_id}}"><strong>{{$value->first_name}} {{$value->last_name}} - Admin</strong>
                                                                                @if($value->new_msg > 0)
                                                                                <span class="badge badge-danger msg_count">{{$value->new_msg}}</span>
                                                                                @endif
                                                                                <p>{{$value->last_msg}}</p>
                                                                                <small>{{ $value->msg_time }}</small>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">

                                                            <div class="right-cht ">
                                                                <div class="right_block">
                                                                    <div class="chating-section nonmedicalmessages" id="chating-section">
                                                                        <h3 id="usernameLabelAdmin"></h3>
                                                                        <ul id="messageDataAdmin"></ul>
                                                                    </div>

                                                                    <div class="">
                                                                        <div class="col-lg-12">
                                                                            <div class="imgDiv" id="imgDiv" style="display: none;">
                                                                                <div class="imgs"> <i class="fa fa-close" id="clearImg" style="font-size: 20px;"></i></div>
                                                                                <div class="imgs-picture">
                                                                                    <img id="blah" src="#" alt="image" />
                                                                                </div>


                                                                            </div>
                                                                        </div>



                                                                        <div id="last-typing-section" class="last-typing-section">
                                                                            <form method="post" id="upload-image-form" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="attachment lastimg pinclip">
                                                                                    <div class="variants">
                                                                                        <div class='file'>
                                                                                            <label for='file'>
                                                                                                <img src="{{asset('public/images/paperclip.png')}}" alt="">
                                                                                            </label>
                                                                                            <input id="file" type="file" name="file">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="search">
                                                                                    <input class="form-control" type="text" name="text" placeholder="Type a message..." id="text">
                                                                                    <input type="hidden" id="userId" name="user_id" value="">
                                                                                    <input type="hidden" id="case_id" name="case_id" value="{{$case_id}}">
                                                                                </div>
                                                                                <div class="sending lastimg">
                                                                                    <button type="button" id="sendAdminMsg"><img src="{{asset('public/images/telegram.png')}}" alt=""></button>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="supportMsg" class="tab-pane fane in support">
                                                    <div class="row" style="padding: 10px;">
                                                        <div class="col-md-3">
                                                            <div class="right_chating">
                                                                <div class="right-cht">
                                                                    <div class="chating-section">
                                                                        <ul>
                                                                            <li class="mdSupport"><strong>MD Support</strong>

                                                                                <span class="badge badge-danger support_msg_count">1</span>

                                                                                <p>last msg</p>
                                                                                <small>msg time</small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">

                                                            <div class="right-cht ">
                                                                <div class="right_block">
                                                                    <div class="chating-section supportmessages" id="chating-section">
                                                                        <h3>MD Support</h3>
                                                                        <ul id="messageDataSupport"></ul>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="imgDiv" id="supportImgDiv" style="display: block;">
                                                                                <div class="imgs"> <i class="fa fa-close" id="clearImg" style="font-size: 20px;"></i></div>
                                                                                <div class="imgs-picture">
                                                                                    <img id="supportBlah" src="#" alt="image" />
                                                                                </div>


                                                                            </div>
                                                                        </div>



                                                                        <div id="last-typing-section-support" class="last-typing-section">
                                                                            <form method="post" id="support-upload-image-form" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="attachment lastimg pinclip">
                                                                                    <div class="variants">
                                                                                        <div class='file'>
                                                                                            <label for='supportFile'>
                                                                                                <img src="{{asset('public/images/paperclip.png')}}" alt="">
                                                                                            </label>
                                                                                            <input id="supportFile" type="file" name="file">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="search">
                                                                                    <input class="form-control" type="text" name="text" placeholder="Type a message..." id="supportText">
                                                                                    <input type="hidden" id="supportUserId" name="user_id" value="{{$user_id}}">
                                                                                    <input type="hidden" id="supportCase_id" name="case_id" value="{{$case_id}}">
                                                                                    <input type="hidden" id="supportMd_case_id" name="md_case_id" value="{{$md_case_id}}">
                                                                                    <input type="hidden" name="prioritized" value="true">
                                                                                    <input type="hidden" name="prioritized_reason" value="He needs the prescription for tomorrow.">
                                                                                    <input type="hidden" name="from" value="support">
                                                                                </div>
                                                                                <div class="sending lastimg">
                                                                                    <button type="button" id="sendSupportMsg"><img src="{{asset('public/images/telegram.png')}}" alt=""></button>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
        });
        $('.userAdminList').on('click', function() {

            var user_id = $(this).attr('data-id');
            $(this).find(".msg_count").hide('slow');
            $.ajax({
                url: "{{route('getNonMedicalMessage')}}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id
                },
                success: function(result) {
                    $('#usernameLabelAdmin').html(result.username);
                    $('#messageDataAdmin').html(result.html);
                    $('#userId').val(result.userId);
                    $("#messageDataAdmin").animate({
                        scrollTop: $("#messageDataAdmin")[0].scrollHeight
                    }, 1000);
                }
            });
        });

        $('#sendAdminMsg').on('click', function() {
            $('#upload-image-form').submit();
        });
        $('#upload-image-form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{route('sendNonMedicalMessage')}}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    let result = JSON.parse(data)
                    console.log(result);
                    if (result != false) {
                        $('#text').val('');
                        if (result.text) {
                            $('#messageDataAdmin').append(
                                '<li class="right"><div class="time_messages"><p class="text_mesg">' + result.text + '</p><h5>' + result.time + '</h5></div></li>'
                            );
                        }
                        if (result.file) {
                            $('#messageDataAdmin').append(
                                '<li class="right"><div class="time_messages"><p class="text_mesg"><a href="' + result.url + result.file + '" target="_blank"><img src="' + result.url + result.file + '" style="width:50px; height:50px; object-fit: contain;"></p><h5>' + result.time + '</h5></div></li>'
                            )
                        }
                    }
                    $("#messageDataAdmin").animate({
                        scrollTop: $("#messageDataAdmin")[0].scrollHeight
                    }, 1000);
                }
            });
        });

        var input = document.getElementById("text");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("sendAdminMsg").click();
            }
        });

        $('#file').on('change', function(e) {
            $('#imgDiv').show();
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#clearImg').on('click', function() {
            $('#imgDiv').hide();
            $('#file').val('');
        });

        $('#sendSupportMsg').on('click', function() {
            $('#support-upload-image-form').submit();
        });

        $('#support-upload-image-form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{route('sendSupportMessage')}}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    let result = JSON.parse(data)
                    console.log(result);
                    if (result != false) {
                        $('#supportText').val('');
                        if (result.text) {
                            $('#messageDataSupport').append(
                                '<li class="right"><div class="time_messages"><p class="text_mesg">' + result.text + '</p><h5>' + result.time + '</h5></div></li>'
                            );
                        }
                        if (result.file) {
                            $('#messageDataSupport').append(
                                '<li class="right"><div class="time_messages"><p class="text_mesg"><a href="' + result.url + result.file + '" target="_blank"><img src="' + result.url + result.file + '" style="width:50px; height:50px; object-fit: contain;"></p><h5>' + result.time + '</h5></div></li>'
                            )
                        }
                    }
                    $("#messageDataSupport").animate({
                        scrollTop: $("#messageDataSupport")[0].scrollHeight
                    }, 1000);
                }
            });
        });
        $(document).on('change', '#supportFile', function(e) {
            alert();
            $('#supportImgDiv').show();
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#supportBlah').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endsection