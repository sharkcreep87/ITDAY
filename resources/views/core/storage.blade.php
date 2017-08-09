@extends('layouts.system')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet light portlet-form bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-drawer font-red"></i>
                <span class="caption-subject font-red bold">File Storage</span>
            </div>
            <div class="actions">
                <a href="{{url('core/storage/terminal')}}" class="tips btn" title="Go to Terminal">
                    <i class="fa fa-terminal"></i> Terminal
                </a>
            </div>
        </div>
        <div class="portlet-body">
            @if (session('message'))
                <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {{ session('message') }}
                </div>
            @endif
            <div class="row margin-top-10">
                <div class="col-md-12">
                	<div class="panel panel-default">
                        <div class="panel-body" id="form-content">
                        	<div style="display: none;" id="upload-progress">
					            <h4>Uploading...</h4>
					            <div class="progress progress-striped active">
					                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
					                </div>
					            </div>
					        </div>
                            <div id="divtree" class="min-height-500"></div>
                        </div>
                    </div>
                </div>
            </div>
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
@endsection
@section('script')
<script type="text/javascript">
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
                            inst.create_node(obj, { type : "default" }, "last", function (new_node) {
                                setTimeout(function () { inst.edit(new_node); },0);
                            });
                        }
                    },
                    "create_file" : {
                        "label"             : "File",
                        "action"            : function (data) {
                            var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);
                            inst.create_node(obj, { type : "file" }, "last", function (new_node) {
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
        'plugins' : ['state','dnd','sort','types','contextmenu','unique','table'],
        'table': {
            columns: [
              {width: '300px', header: "Folder/File Name"},
              {width: '300px', header: "File Size", value: "size"},
              {width: '250px', header: "Permission", value: "perms"},
              {width: '250px', header: "Created At", value: "created_at"},
            ],
            resizable: true,
            draggable: true,
            contextmenu: true,
        },
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
            window.location.href='{{url("core/storage/file")}}?_file='+node[0].id;
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