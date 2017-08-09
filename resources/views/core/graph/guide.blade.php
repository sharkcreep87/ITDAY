@extends('layouts.system')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/lib/codemirror.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/dialog/dialog.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/hint/show-hint.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/addon/scroll/simplescrollbars.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/codemirror/theme/monokai.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
    .CodeMirror {
        min-height: 500px !important;
    }
    code {
        border: none !important; 
        -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.1); 
        -moz-box-shadow: 0 1px 4px rgba(0,0,0,.1);
        box-shadow: none !important; 
    }
</style>
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line hidden-print">
                    <div class="caption caption-md">
                        <i class="icon-notebook font-red"></i>
                        <span class="caption-subject font-red bold">API Collection</span>
                    </div>
                    <div class="actions">
                        <button class="btn btn-circle green"  onclick="javascript:window.print();"> <i class="icon-printer"></i> Print</button>
                    </div>
                    <!-- <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab">Preview</a>
                        </li>
                        <li class="">
                            <a href="#tab_1_2" data-toggle="tab">Edit Guide</a>
                        </li>
                    </ul> -->
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        @if (session('message'))
                            <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="preivew"></div>
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            <div class="row">
                                <div class="col-md-8 font-red"><h3>Add more your API documentation and save your changes.</h3></div>
                                <div class="col-md-4 text-right">
                                    <button class="btn green margin-bottom-20">Save Changes</button>
                                    <button class="btn red margin-bottom-20">Cancel</button>
                                </div>
                            </div>
                            <textarea class="form-contro" name="guide" id="guide">{{$guide}}</textarea>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/mode/meta.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/codemirror/keymap/sublime.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/meltdown/js/lib/js-markdown-extra.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function(){
        var guide = document.getElementById("guide");
        var guideEditor = CodeMirror.fromTextArea(guide, {
            lineNumbers: true,
            matchBrackets: true,
            styleActiveLine: true,
            mode: "application/x-httpd-php",
            extraKeys: {"Ctrl-Space": "autocomplete", "Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
            keyMap: "sublime",
            autoCloseBrackets: true,
            showCursorWhenSelecting: true,
            assets: "monokai",
            tabSize: 4,
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            scrollbarStyle: "simple"
        });
        guideEditor.on('change', function(cm){
            $('.preivew').html(Markdown( cm.getValue() ));
        });

        $('.nav-tabs a').on('shown.bs.tab', function() {
            guideEditor.refresh();
        }); 
        change("mode.php");

        function change(modeInput) {
            var val = modeInput, m, mode, spec;
            if (m = /.+\.([^.]+)$/.exec(val)) {
                var info = CodeMirror.findModeByExtension(m[1]);
                if (info) {
                  mode = info.mode;
                  spec = info.mime;
                }
            } else if (/\//.test(val)) {
            var info = CodeMirror.findModeByMIME(val);
            if (info) {
                mode = info.mode;
                spec = val;
            }
            } else {
                mode = spec = val;
            }
            if (mode) {
                guideEditor.setOption("mode", spec);
                CodeMirror.autoLoadMode(guideEditor, mode);
            } else {
                alert("Could not find a mode corresponding to " + val);
            }
        }
        var guide = guideEditor.getValue();

        $('.preivew').html(Markdown( guide ));
    });

</script>
@endsection