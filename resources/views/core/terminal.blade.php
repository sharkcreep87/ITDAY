@extends('layouts.system')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/jquery-terminal/css/jquery.terminal.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-link font-red"></i>
                        <span class="caption-subject font-red bold">Terminal</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="terminal" style="height: 600px;margin: 15px 20px 10px"></div>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
@endsection
@section('plugin')
{{csrf_field()}}
<script src="{{ asset('apitoolz-assets/global/plugins/jquery-terminal/js/jquery.mousewheel-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/jquery-terminal/js/jquery.terminal.min.js') }}" type="text/javascript"></script>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {

        var terminal = $('#terminal').terminal(function(command, term) {
                            term.pause();
                            $.ajax({
                                url: '{{url("core/storage/terminal/command")}}',
                                type: 'post',
                                data: {command: command},
                                headers: {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                },
                                success: function (response) {
                                    term.echo(response).resume();
                                }
                            });
                        }, 
                        {
                            greetings: 'API Toolz Terminal',
                            prompt: '{{session("root")}} >',
                            onBlur: function() {
                                return true;
                            }
      
                    });
    });
</script>
@endsection