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
        height: 600px !important;
    }
</style>
@endsection
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid font-red"></i>
                        <span class="caption-subject font-red bold">Email Template</span>
                    </div>
                    <div class="actions">
                        
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('message'))
                        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="block-content">
                        {!! Form::open(array('url'=>'core/settings/email', 'class'=>'form-vertical row')) !!}
                        <div class="col-sm-6">
                            <div class="sbox  ">
                                <div class="sbox-title"> 
                                    Register New Account
                                </div>
                                <div class="sbox-content">
                                    <div class="form-group">
                                        <textarea rows="20" id="register_editor" name="regEmail" class="form-control input-sm  markItUp">{{ $regEmail }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn green" type="submit"> Save changes</button>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="sbox  ">
                                <div class="sbox-title"> Forget Password</div>
                                <div class="sbox-content">
                                    <div class="form-group">
                                        <textarea id="forget_editor" rows="20" name="resetEmail" class="form-control input-sm markItUp">{{ $resetEmail }}</textarea>
                                    </div>

                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>

                        </div>
                        {!! Form::close() !!}
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
<script type="text/javascript">
    var register = document.getElementById("register_editor");
    var regEditor = CodeMirror.fromTextArea(register, {
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

    var forget = document.getElementById("forget_editor");
    var forgEditor = CodeMirror.fromTextArea(forget, {
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
            regEditor.setOption("mode", spec);
            forgEditor.setOption("mode", spec);
            CodeMirror.autoLoadMode(regEditor, mode);
            CodeMirror.autoLoadMode(forgEditor, mode);
        } else {
            alert("Could not find a mode corresponding to " + val);
        }
    }

</script>
@endsection