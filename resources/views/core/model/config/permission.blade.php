@extends('core.model.config')
@section('permission')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>{{$row->module_title}} Permission</strong> ( Manage permission of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="{{url('core/model/config/'.$row->module_id.'/permission')}}" method="post" class="form-vertical" data-parsley-validate>
            {{csrf_field()}}
            <table class="table table-striped table-bordered" id="table">
                <thead class="no-border">
                    <tr>
                        <th field="name1" width="20">No</th>
                        <th field="name2">Group </th>
                        @foreach($config['tasks'] as $item=>$val)
                        <th field="name3" data-hide="phone">
                            {{$val}}
                        </th>
                        @endforeach

                    </tr>
                </thead>
                <tbody class="no-border-x no-border-y">
                	@foreach($access as $i=>$group)
                    <tr>
                        <td width="20">
                        	{{$group['group_id']}}
                            <input type="hidden" name="group_id[]" value="{{$group['group_id']}}" />
                        </td>
                        <td>
                            {{$group['group_name']}}
                        </td>
                        @foreach($config['tasks'] as $item=>$val)
                        <td class="">
                            <label class="icheck">
                                <input name="{{$item}}[{{$group['group_id']}}]" class="c{{$group['group_id']}}" type="checkbox" value="1" @if($group[$item]==1) checked @endif />
                            </label>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn green"> Save Changes </button>
        </form>
    </div>
</div>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection