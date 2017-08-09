@extends('layouts.system')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet" type="text/css" />
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
            <div class="portlet light portlet-form bordered">
                <div class="portlet-body">
                	@if (session('message'))
                        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ session('message') }}
                        </div>
                    @endif
	                <form action="{{url('core/storage/file')}}" id="frm_editor" method="POST">
	                	{{csrf_field()}}
	                    <div class="row">
                            <div class="col-md-12">
                                <div class="row tab-pane m-t" id="code" style="min-height: 600px;">
                                    <div class="portlet light" id="code-editor">
                                        <div class="portlet-title tabbable-line">
                                            <ul class="nav nav-tabs pull-left" id="tabs">
                                                @if($path)
                                                <li class="active">
                                                    <a href="#tab-view" data-toggle="tab"> {{$file}} <i class='fa fa-close' onclick='removeTab(this,"#tab-view")'></i></a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content" id="mTab">
                                                @if($path)
                                                <div class="tab-pane active" id="tab-view">
                                                    <input type="hidden" name="_file[]" value="{{$path}}">
                                                    <textarea name='content[]' rows='35' id='edt_view' class='form-control'>{{$content}}</textarea>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
	                    	</div>
	                    </div>
	                </form>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<form enctype="multipart/form-data" id="frm-filetree">
    {{ csrf_field() }}
    <input name="file" id="filetree" type="file" style="display: none;" />
    <input type="hidden" name="path" id="upload_path">
</form>
@endsection
@section('plugin')
<script src="{{ asset('apitoolz-assets/global/plugins/jstree/dist/jstree.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/jstree/dist/jstreetable.js') }}" type="text/javascript"></script>
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
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/Javascript/javascript.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/css/css.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/clike/clike.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/php/php.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/keymap/sublime.js') }}" type="text/javascript"></script>
@endsection
@section('script')
<script type="text/javascript">
    var $codemirror = {};
    @if($path)
    createCodeMirror("edt_view", "php");
    @endif
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
                    $('form#frm_editor').submit();
                    break;
                }
            }
        });
        
    }

    var jstree = $('#divtree').jstree({
        'core' : {
            'data' : {
                'url' : '{{url("core/storage/jstree")}}?operation=get_node',
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            },
            'check_callback' : function(o, n, p, i, m) {
                if(m && m.dnd && m.pos !== 'i') { return false; }
                if(o === "move_node" || o === "copy_node") {
                    if(this.get_node(n).parent === this.get_node(p).id) { return false; }
                }
                return true;
            },
            'force_text' : true,
            'themes' : {
                'responsive' : true,
                //'stripes' : true
            }
        },
        'sort' : function(a, b) {
            return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
        },
        'contextmenu' : {
            'items' : function(node) {
                var tmp = $.jstree.defaults.contextmenu.items();
                delete tmp.create.action;
                tmp.create.label = "New";
                tmp.create.icon = "fa fa-plus";
                tmp.create.submenu = {
                    "create_folder" : {
                        "separator_after"   : true,
                        "label"             : "Folder",
                        "action"            : function (data) {
                            var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);
                            inst.create_node(obj, { type : "default", icon: "fa fa-folder icon-state-warning icon-lg" }, "last", function (new_node) {
                                setTimeout(function () { inst.edit(new_node); },0);
                            });
                        }
                    },
                    "create_file" : {
                        "label"             : "File",
                        "action"            : function (data) {
                            var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);
                            inst.create_node(obj, { type : "file", icon: "fa fa-file icon-lg" }, "last", function (new_node) {
                                setTimeout(function () { inst.edit(new_node); },0);
                            });
                        }
                    }
                };
                if(this.get_type(node) === "file") {
                    delete tmp.create;
                }
                tmp.rename.icon = "fa fa-edit";
                tmp.remove.icon = "fa fa-trash-o";
                tmp.ccp.icon = "fa fa-files-o";
                tmp.upload = {
                                "icon": "fa fa-upload",
                                "label": "Upload File",
                                "action": function (obj) {
                                        fileUpload();
                                }
                            }
                tmp.permission = {
                            "icon": "fa fa-key",
                            "label": "Permission",
                            "action": function (obj) {
                                changePerms();
                            }
                        }
                console.log(tmp);
                return tmp;
            }
        },
        'types' : {
            'default' : { 'icon' : 'folder' },
            'file' : { 'valid_children' : [], 'icon' : 'file' }
        },
        'unique' : {
            'duplicate' : function (name, counter) {
                return name + ' ' + counter;
            }
        },
        'plugins' : ['state','dnd','sort','types','contextmenu','unique'],
    })
    .on('delete_node.jstree', function (e, data) {
        if(confirm('Are you sure you want to delete?')){
            $.get('{{url("core/storage/jstree")}}?operation=delete_node', { 'id' : data.node.id })
                .fail(function () {
                    data.instance.refresh();
                });
            
        }else{
            data.instance.refresh();
        }
    })
    .on('create_node.jstree', function (e, data) {
        $.get('{{url("core/storage/jstree")}}?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
            .done(function (d) {
                data.instance.set_id(data.node, d.id);
            })
            .fail(function () {
                data.instance.refresh();
            });
    })
    .on('rename_node.jstree', function (e, data) {
        $.get('{{url("core/storage/jstree")}}?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
            .done(function (d) {
                data.instance.set_id(data.node, d.id);
            })
            .fail(function () {
                data.instance.refresh();
            });
    })
    .on('move_node.jstree', function (e, data) {
        $.get('{{url("core/storage/jstree")}}?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
            .done(function (d) {
                //data.instance.load_node(data.parent);
                data.instance.refresh();
            })
            .fail(function () {
                data.instance.refresh();
            });
    })
    .on('copy_node.jstree', function (e, data) {
        $.get('{{url("core/storage/jstree")}}?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
            .done(function (d) {
                //data.instance.load_node(data.parent);
                data.instance.refresh();
            })
            .fail(function () {
                data.instance.refresh();
            });
    })
    .on('changed.jstree', function (e, data) {
        if(data && data.selected && data.selected.length) {
            $.get('{{url("core/storage/jstree")}}?operation=get_content&id=' + data.selected.join(':'), function (d) {
                if(d && typeof d.type !== 'undefined') {
                    $('#data .content').hide();
                    switch(d.type) {
                        case 'text':
                        case 'txt':
                        case 'md':
                        case 'htaccess':
                        case 'log':
                        case 'sql':
                        case 'php':
                        case 'js':
                        case 'json':
                        case 'css':
                        case 'html':
                            $('#data .code').show();
                            $('#code').val(d.content);
                            break;
                        case 'png':
                        case 'jpg':
                        case 'jpeg':
                        case 'bmp':
                        case 'gif':
                            $('#data .image img').one('load', function () { $(this).css({'marginTop':'-' + $(this).height()/2 + 'px','marginLeft':'-' + $(this).width()/2 + 'px'}); }).attr('src',d.content);
                            $('#data .image').show();
                            break;
                        default:
                            $('#data .default').html(d.content).show();
                            break;
                    }
                }
            });
        }
        else {
            $('#data .content').hide();
            $('#data .default').html('Select a file from the tree.').show();
        }
    });

    jstree.bind("dblclick.jstree", function (e) {
        fileOpen();
    });

    var changePerms = function() {
        var tree = $("#divtree").jstree(true), node = tree.get_selected(true);
        var $file_path = node[0].id;
        _Modal('{{url("core/storage/perms")}}?_file='+$file_path,'Permission for '+node[0].text);
    }

    var fileOpen = function(){
        var tree = $("#divtree").jstree(true), node = tree.get_selected(true);
        if(node[0].type == 'file'){
            addTabs(node[0].id.replace(/\//g, '_').replace(/\./g, '_'), node[0].text, node[0].id, node[0].original.ext);
        }
    }

    var fileUpload = function(){
        var tree = $("#divtree").jstree(true), node = tree.get_selected(true);
        if(node[0].type != 'file'){
            $("#upload_path").val(node[0].id);
            $("#filetree").click();
        }else{
            displayNoti("Error", "Make sure to select folder.",'error');
        }
    }

    $("#filetree").change(function(){
        var file = this.files[0];
        var name = file.name;
        var size = file.size;
        var type = file.type;
        var exts = ["jpg", "gif", "jpeg", "png", "doc", "xls", "pdf", "tif", "ico", "xcf", "gif87", "scr","css","js","html","php","zip","mp3","mp4"];
        var ext = name.split('.').pop();

        if($.inArray(ext, exts) === -1){
            displayNoti("Error", 'Not supported file type ['+ ext +']','error');
            return false;
        }
        var formData = new FormData($('#frm-filetree')[0]);
        $('#upload-progress').show();
        // CSRF protection
        $.ajaxSetup(
        {
            headers:
            {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
        $.ajax({
            url: '{{asset("core/storage/file/upload")}}',  //Server script to process data
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            //beforeSend: beforeSendHandler,
            success: completeHandler,
            error: errorHandler,
            // Form data
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
    });

    var completeHandler = function (responseText){
        $('#upload-progress').hide();
        $('.progress-bar').css({"width":"0%"});
        $("#divtree").jstree(true).refresh();
        displayNoti("Success", responseText,'success');
    }

    var errorHandler = function (d){
        displayNoti("Error", d.responseText,'error');
    }

    var progressHandlingFunction = function (evt){
        if(evt.lengthComputable){
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            if (percentComplete === 100) {

            }
            $('#upload-progress h4').html(percentComplete+"% Uploading... ");
            $('.progress-bar').css({"width":percentComplete+"%"});
        }
    }

    $('form#frm_editor').submit(function(e) {
        $('#loader').show();
        var formData =  new FormData( this );
        console.log(formData);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data:formData,
            processData: false,
            contentType: false
        }).done(function($response) {
            displayNoti('Success', $response.message, 'success');
            $('#loader').hide();
        }).fail(function($error){
            $('#loader').hide();
            $.each($error.responseJSON, function(key, value){
                displayNoti('Required', value, 'error');
            });
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
                $("#code-editor div.tab-content").append( "<div class='tab-pane active' id='tab_" + id + "'><input type='hidden' name='_file[]' value='"+data.path+"'><textarea name='content[]' rows='35' id='edt_"+id+"' class='form-control'>"+data.content+"</textarea></div>" );
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

    var displayNoti = function(title, message,status){
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