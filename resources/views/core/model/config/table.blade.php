@extends('core.model.config')
@section('table')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>{{$row->module_title}} Table</strong> ( Change table settings of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="{{url('core/model/config/'.$row->module_id.'/table')}}" method="post" class="form-vertical" data-parsley-validate>
            {{csrf_field()}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="no-border">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Field</th>
                            <th scope="col" width="80"><i class="fa fa-key"></i> Limit</th>
                            <th scope="col"><i class="icon-link"></i></th>
                            <th scope="col" data-hide="phone">Title / Caption </th>
                            <th scope="col" width="75" data-hide="phone">Align</th>
                            <th scope="col" width="75" data-hide="phone">Width</th>
                            <th scope="col" data-hide="phone">Show</th>
                            <th scope="col" data-hide="phone">View </th>
                            <th scope="col" data-hide="phone">Sortable</th>
                            <th scope="col" data-hide="phone">Download</th>
                            <th scope="col" data-hide="phone">API</th>
                            <th scope="col" data-hide="phone" width="200px"> Format As </th>
                        </tr>
                    </thead>
                    <tbody class="no-border-x no-border-y">
                        <?php 
                            usort($config['grid'], "SiteHelpers::_sort"); 
                            $num=0;
                        ?>
                        @foreach($config['grid'] as $rows)
                        <?php $id = ++$num; ?>
                            <tr>
                                <td class="index">
                                    {{$id}}
                                </td>
                                <td>
                                    <strong>{{$rows['field']}}</strong>
                                    <input type="hidden" name="field[{{$id}}]" id="field" value="{{$rows['alias']}}" /> 
                                </td>
                                <td>
                                    <?php
                                         $limited_to = (isset($rows['limited']) ? $rows['limited'] : '');
                                    ?>
                                    <input type="text" class="form-control input-sm" name="limited[{{$id}}]" class="limited" value="{{$limited_to}}" />

                                </td>
                                <td>
                                    <a href="javascript:;" class="@if(isset($rows['conn']['valid']) && $rows['conn']['valid'] == '1') font-red @else font-blue @endif " title="Lookup Display" onclick="_Modal('{{ url('core/model/config/'.$row->module_id.'/conn?table_field='.$rows['field'].'&table_alias='.$rows['alias']) }}' ,' Connect Field : {{ $rows['field']}} ' )">
                                        <i class="fa fa-external-link"></i>
                                    </a>
                                </td>
                                <td>
                                    <input name="label[{{$id}}]" type="text" class="form-control input-sm" id="label" value="{{$rows['label']}}" />
                                </td>
                                <td>
                                    <input name="align[{{$id}}]" type="text" class="form-control input-sm" id="align" value="{{$rows['align']}}" />
                                </td>
                                <td>
                                    <input name="width[{{$id}}]" type="text" class="form-control input-sm" id="width" value="{{$rows['width']}}" />
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="view[{{$id}}]" type="checkbox" id="view" value="1" @if($rows[ 'view']==1 ) checked @endif/>
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="detail[{{$id}}]" type="checkbox" id="detail" value="1" @if($rows[ 'detail']==1 ) checked @endif/>
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="sortable[{{$id}}]" type="checkbox" id="sortable" value="1" @if($rows['sortable']==1) checked @endif />
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="download[{{$id}}]" type="checkbox" id="download" value="1" @if($rows['download']==1 ) checked @endif/>
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="api[{{$id}}]" type="checkbox" id="api" value="1" @if($rows[ 'api']==1) checked @endif />
                                    </label>
                                </td>
                                <td>
                                    <select class="form-control input-sm" name="format_as[{{$id}}]">
                                        <option value=''> None </option>
                                        @foreach($formats as $key=>$val)
                                        <option value="{{ $key }}" @if(isset($rows[ 'format_as']) && $rows[ 'format_as']==$key) selected @endif > {{ $val }} </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group margin-top-5">
                                        <input type="text" name="format_value[{{$id}}]" value="@if(isset($rows['format_value'])){{ $rows['format_value'] }}@endif" class="form-control input-sm" placeholder="Format Value"> 
                                        <a href="javascript://ajax" data-html="true" class="text-success format_info" data-toggle="popover" title="Example Usage" data-content="  <b>Data </b> = dd-yy-mm <br /> <b>Image</b> = /uploads/path_to_upload <br />  <b>Link </b> = http://domain.com ? <br /> <b> Function </b> = class|method|params <br /> <b>Checkbox</b> = value:Display,...<br /> <b>Limit String</b> = 255<br /><b>Number Format</b> = 2<br /> <b>Database</b> = table|id|field <br /><br /> All Field are accepted using tag {FieldName} . Example {<b>{{$rows['field']}}</b>} " data-placement="left">
                                        <i class="icon-question4"></i> Help? </a>                                     
                                    </div>
                                    <input type="hidden" name="frozen[{{$id}}]" value="{{$rows['frozen']}}" />
                                    <input type="hidden" name="search[{{$id}}]" value="{{$rows['search']}}" />
                                    <input type="hidden" name="hidden[{{$id}}]" value="@if(isset($rows['hidden'])){{ $rows['hidden']}}@endif" />
                                    <input type="hidden" name="alias[{{$id}}]" value="{{$rows['alias']}}" />
                                    <input type="hidden" name="field[{{$id}}]" value="{{$rows['field']}}" />
                                    <input type="hidden" name="sortlist[{{$id}}]" class="reorder" value="{{$rows['sortlist']}}" />
                                    <input type="hidden" name="conn_valid[{{$id}}]" value="@if(isset($rows['conn']['valid'])){{$rows['conn']['valid']}}@endif" />
                                    <input type="hidden" name="conn_db[{{$id}}]" value="@if(isset($rows['conn']['db'])){{$rows['conn']['db']}}@endif" />
                                    <input type="hidden" name="conn_key[{{$id}}]" value="@if(isset($rows['conn']['key'])){{$rows['conn']['key']}}@endif" />
                                    <input type="hidden" name="conn_display[{{$id}}]" value="@if(isset($rows['conn']['display'])){{$rows['conn']['display']}}@endif" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="note note-info">
                <p> <strong>Tips !</strong> Drag and drop rows to re ordering lists </p>
            </div>
            <button type="submit" class="btn green"> Save Changes </button>
        </form>
    </div>
</div>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        $('.format_info').popover()

        var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function(i) {
                    $(this).html(i + 1);
                });
                $('.reorder', ui.item.parent()).each(function(i) {
                    $(this).val(i + 1);
                });
            };

        $("#table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        });
    });
</script>
@endsection
