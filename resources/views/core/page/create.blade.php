@extends('layouts.system')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/lib/codemirror.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/dialog/dialog.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/show-hint.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/scroll/simplescrollbars.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/display/fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/theme/monokai.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .CodeMirror {
        height: 100% !important;
        min-height: 600px !important;
    }
</style>
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <form action="{{$action}}" class="form-vertical" method="post" id="page" data-parsley-validate enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{@$row->id}}">
                <div class="portlet light portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-grid font-red"></i>
                            <span class="caption-subject font-red bold">New Page</span>
                        </div>
                        <div class="actions">
                            <button type="button" class="btn btn-success" id="apply" name="apply" value="1"> Apply </button>
                            <button type="submit" class="btn btn-info " id="submit"> Submit </button>
                            <a href="{{ url('core/page')}}" class="btn red"> Cancel </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        @if (session('message'))
                            <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="row">
                            
                            <div class="col-sm-12 ">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#info" data-toggle="tab"> Page Info </a></li>
                                    <li><a href="#code" data-toggle="tab">Edit Code</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active m-t" id="info">
                                        <div class="portlet light bordered">

                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="ipt"> Name *</label>

                                                            {!! Form::text('title', @$row->title,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' )) !!}

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ipt"> Alias *</label>

                                                            {!! Form::text('alias', @$row->alias,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' )) !!}

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <label for="ipt"> URL *</label>
                                                                    <div class="input-group input-icon right">
                                                                        <span class="input-group-addon blue">
                                                                        {{env('APP_URL')}}/
                                                                        </span>
                                                                        {!! Form::text('url', @$row->url,array('class'=>'form-control group', 'placeholder'=>'', 'required'=>'true' )) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="ipt"> Method *</label>
                                                                    <select class="form-control" name="method">
                                                                        <option value="get">GET</option>
                                                                        <option value="post">POST</option>
                                                                        <option value="put">PUT</option>
                                                                        <option value="delete">DELETE</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group  ">
                                                            <label for="ipt">Meta Title</label>
                                                            <input type="text" class="form-control" name="meta_title" value="{{ @$row->meta_title }}">
                                                        </div>
                                                        <div class="form-group  ">
                                                            <label class=""> Meta Keywords </label>
                                                            <div class="" style="background:#fff;">
                                                                <textarea name='meta_keywords' rows='5' id='metakey' class='form-control markItUp'>{{ @$row->meta_keywords }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group  ">
                                                            <label class=""> Meta Description </label>
                                                            <div class="" style="background:#fff;">
                                                                <textarea name='meta_description' rows='10' id='metadesc' class='form-control markItUp'>{{ @$row->meta_description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="ipt"> Asset files</label>
                                                            <div class="fileinput fileinput-new " data-provides="fileinput">
                                                                <div class="input-group input-large">
                                                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                        <span class="fileinput-filename"> </span>
                                                                    </div>
                                                                    <span class="input-group-addon btn default btn-file">
                                                                        <span class="fileinput-new"> Select file </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <input type="file" name="asset_files"> </span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                            <span class="help-block text-danger">
                                                                <strong>NOTE: ZIP file of images, css and javascript.</strong>
                                                            </span>
                                                        </div>
                                                        <div class="form-group icheck">
                                                            <label> Check for Guest ? </label>
                                                            <label class="checkbox">
                                                                <input type='checkbox' name='auth' @if(@$row->auth==1 ) checked @endif value="1" /> Authenticate Require</lable>
                                                        </div>

                                                        <div class="form-group icheck">
                                                            <label> Status </label>
                                                            <label class="radio">
                                                                <input type='radio' name='status' value="1" @if( @$row->status==1 ) checked @endif /> Enable
                                                            </label>
                                                            <label class="radio">
                                                                <input type='radio' name='status' value="0" @if( @$row->status==0 ) checked @endif /> Disabled
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Template type</label>
                                                            <select name="type" class="form-control" style="width: 250px;" required>
                                                                <option value="">--- Choose ---</option>
                                                                <option value="master" @if(@$row->type == 'master') selected @endif>Master</option>
                                                                <option value="page" @if(@$row->type == 'page') selected @endif>Page</option>
                                                                <option value="route" @if(@$row->type == 'router') selected @endif>Router</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane m-t" id="code">
                                        <div class="portlet light bordered" id="code-editor">
                                            <div class="portlet-title tabbable-line">
                                                <ul class="nav nav-tabs pull-left" id="tabs">
                                                    <li class="active">
                                                        <a href="#tab-view" data-toggle="tab"> View Code </a>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn add-more" onclick="openFileManager();"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content" id="mTab">
                                                    <div class="tab-pane active" id="tab-view">
                                                        <textarea name='view' rows='35' id='edt_view' class='form-control'>{{ @$view }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END VALIDATION STATES-->
            </form>
        </div>
    </div>
</div>
<div id="filemanager" class="modal fade bs-modal-lg " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">File Manager</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="display: none;" id="upload-progress">
                        <h4>Uploading...</h4>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="portlet">
                            <div class="portlet-body">
                                <div id="fileview"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection
@section('plugin')
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/lib/codemirror.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/show-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/xml-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/html-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/anyword-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/css-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/javascript-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/sql-hint.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/search/searchcursor.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/search/search.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/dialog/dialog.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/edit/matchbrackets.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/edit/closebrackets.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/comment/comment.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/wrap/hardwrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldcode.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/brace-fold.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldcode.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/brace-fold.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/xml-fold.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/markdown-fold.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/comment-fold.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/mode/loadmode.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/scroll/simplescrollbars.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/selection/active-line.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/display/fullscreen.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/meta.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/xml/xml.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/javascript/javascript.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/css/css.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/clike/clike.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/php/php.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/keymap/sublime.js') }}" type="text/javascript"></script>
@endsection
@section('script')
<script type="text/javascript">
    var submited = false;
    var $codemirror = {};
    createCodeMirror("edt_view", "php");
    function createCodeMirror($el, ext){
        var $mode = "application/x-httpd-php";
        if(ext == 'css') {
            $mode = "text/css";
        }else if(ext == 'js'){
            $mode = "text/javascript";
        }
        var edt_view = CodeMirror.fromTextArea(document.getElementById($el), {
            lineNumbers: true,
            matchBrackets: true,
            styleActiveLine: true,
            mode: $mode,
            extraKeys: {
                            "Ctrl-Space": "autocomplete", 
                            "F11": function(cm) {
                                $('.page-header').css({'z-index':0});
                                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                            },
                            "Esc": function(cm) {
                                $('.page-header').css({'z-index':9995});
                                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                            }
                        },
            keyMap: "sublime",
            autoCloseBrackets: true,
            showCursorWhenSelecting: true,
            assets: "monokai",
            tabSize: 6,
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            scrollbarStyle: "simple",
        });
        $codemirror[$el] = edt_view;
        $('.nav-tabs a').on('shown.bs.tab', function() {
            edt_view.refresh();
        });
        edt_view.on('keydown', function(editor, event) {
             if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                    event.preventDefault();
                    $.each($codemirror, function($key, $obj){
                        $('#'+$key).val($obj.getValue());
                    });
                    $('form#page').submit();
                    break;
                }
            }
        });
        
    }

    $('#apply').click(function(){
        $('form#page').submit();
    });

    $('#submit').click(function(){
        submited = true;
    });

    $('form#page').submit(function(e) {
        $('#loader').show();
        var formData =  new FormData( this );
        console.log(formData);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data:formData,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',function(evt){
                        if(evt.lengthComputable){
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progress').show();
                            $('#progress').html(percentComplete+"%");
                        }
                    }, false);
                }
                return myXhr;
            },
            success: function($response){
                if(submited ){
                    window.location.href = "{{url('core/page')}}";
                }
                $('input[name="id"]').val($response.id);
                $('#loader').hide();
                $('#progress').hide();
                $('#progress').html('0%');
            },
            error: function($error){
                $('#loader').hide();
                $.each($error.responseJSON, function(key, value){
                    displayNoti('Required', value, 'error');
                });
            },
            processData: false,
            contentType: false
        });
        e.preventDefault();
    });

    function addTabs(id, text, path, ext) {
        var tab_existed = false;
        $("#code-editor ul.nav-tabs li, #code-editor div.tab-content .tab-pane").each(function(){$(this).removeClass('active')});
        $("#code-editor ul.nav-tabs li").each(function(){
            if($(this).find('a').attr('href') == '#tab_'+id) {
                tab_existed = true;
                $(this).addClass('active');
                $('#code-editor div.tab-content').find('#tab_'+id).addClass('active');
                $('#filemanager').modal('hide');
                return true;
            }
        });
        if(!tab_existed) {
            $('#loader').show();
            $.get('{{url("core/storage/file")}}?_file='+path, function(data){
                $('#loader').hide();
                $("#code-editor ul.nav-tabs").append( "<li class='active'><a href='#tab_" + id + "' data-toggle='tab'>" + text + "<i class='fa fa-close' onclick='removeTab(this,\"#tab_" + id + "\")'></i></a></li>" );
                $("#code-editor div.tab-content").append( "<div class='tab-pane active' id='tab_" + id + "'><input type='hidden' name='path[]' value='"+data.path+"'><textarea name='assets[]' rows='35' id='edt_"+id+"' class='form-control'>"+data.content+"</textarea></div>" );
                createCodeMirror("edt_"+id, ext);
            });
            $('#filemanager').modal('hide'); 
        }
    }

    function removeTab($this, $el){
        if($($this).parent('a').parent('li').hasClass('active')) {
            $($this).parent('a').parent('li').remove();
            $('#mTab').find($el).remove();
            $("#code-editor ul.nav-tabs li:first, #code-editor div.tab-content .tab-pane:first").addClass('active');
        }else{
            $($this).parent('a').parent('li').remove();
            $('#mTab').find($el).remove();
        }
        delete $codemirror['edt_'+$el.substring(5)];
    }

    function openFileManager(){
        $('#fileview').html('');
        $('#fileview').load('{{url("core/page/filemanager")}}',function(){});
        $('#filemanager').modal('show');  
    }

    function displayNoti(title, message,status){
        if(status == 'error'){
            toastr.error(message);
        }else{
            toastr.success(message);
        }
        toastr.options = {
              "closeButton": true,
              "debug": false,
              "positionClass": "toast-bottom-right",
              "onclick": null,
              "showDuration": "1000",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"

            };
    }

</script>
@endsection
