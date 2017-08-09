@extends('layouts.system')
@section('style')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
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
                        <i class="fa fa-database font-red"></i>
                        <span class="caption-subject font-red bold">{{$title}}</span>
                    </div>
                    <div class="actions">
                        
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row no-margin margin-bottom-20">
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                @if (session('message'))
                                    <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <!-- <div class="panel-heading"> Panel heading without title </div> -->
                                <div class="panel-body" id="form-content">
                                    <form action="{{url($action)}}" method="post" class="form-horizontal" data-parsley-validate>
                                        {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="form-group margin-top-10">
                                                <label class="control-label col-md-3">Table Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="table_name" value="{{$table}}" placeholder="eg. tb_category" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"> Storage Engine </label>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="engine">
                                                        @foreach($engine as $e)
                                                         <option value="{{ $e }}" @if(isset($info->Engine) && $info->Engine ==$e) selected @endif>{{ $e }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>  
                                            </div>
                                            <hr>
                                            <div class="table-responsive  bulk-form">
                                                <table class="table table-striped" id="tables">
                                                    <thead>
                                                        <tr>
                                                            <th> Field Name  </th>
                                                            <th> DataType </th>
                                                            <th width="80"> Lenght </th>
                                                            <th width="80"> Default </th>
                                                            <th width="90" > Not Null ? </th>
                                                            <th > Key </th>
                                                            <th > A_I </th>
                                                            <th width="75"> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($columns) >=1)
                                                    @foreach($columns as $i => $column)
                                                        <tr class="" id="field-{{ $column['Field'] }}">
                                                            
                                                            <td>
                                                                {{ $column['Field'] }}
                                                                <input name="move_columns[]" type="hidden" value="{{ $column['Field'] }}">
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $types = explode('(', $column['Type']);
                                                                preg_match("/\((.*)\)/i", $column['Type'],$typeVal);
                                                                $type = $types[0];
                                                                $length = (isset($typeVal[1]))?$typeVal[1]:'';
                                                                ?>  
                                                                {{ $type }} @if($column['Key']) [{{$column['Key']}}] @endif            
                                                    
                                                            </td>
                                                            <td>{{ $length }}</td>
                                                            <td>                       
                                                                {{ $column['Default'] }}                        
                                                            </td>
                                                            <td> @if($column['Null'] =='NO') <i class="text-success fa fa-check-circle"></i> @else <i class="font-red fa fa-minus-circle"></i>  @endif</td>
                                                            <td>
                                                            @if($column['Key'] =='PRI') <i class="text-success fa fa-check-circle"></i> @else <i class="text-danger fa fa-minus-circle"></i>  @endif
                                                            </td>
                                                            <td>
                                                            @if($column['Extra'] =='auto_increment') <i class="text-success fa fa-check-circle"></i> @else <i class="text-danger fa fa-minus-circle"></i>  @endif   
                                                            </td>
                                                            <td class="text-right">
                                                                <?php $info = 'field='.$column['Field'].'&type='.$type.'&lenght='.$length.'&default='.$column['Default'].'&notnull='.$column['Null'].'&key='.$column['Key'].'&ai='.$column['Extra']; ?>
                                                                <a href="{{ url('core/table/'.$table.'/field?'.$info) }}" class="btn btn-xs green" onclick="_Modal(this.href,'Edit Column : {{$column['Field']}} '); return false;" ><i class="fa fa-edit "></i></a>
                                                                <a href="{{ url('core/table/'.$table.'/'.$column['Field'].'/remove') }}" onclick="return confirm('Are you sure want to delete?');" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>
                                                            </td>
                                                                            
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                        <tr class="clone clonedInput">
                                                            
                                                            <td>
                                                                <input type="text" autocomplete="off" onfocus="$('.addC').click();" name="fields[]" data-name="fields" value="" placeholder="eg. id" class="form-control fields input-sm">
                                                            </td>
                                                            <td>                    
                                                                <select name="types[]" data-name="types" type="select" class="form-control input-sm" >
                                                                    @foreach($tbtypes as $t)
                                                                     <option value="{{ $t }}" >{{ $t }}</option>
                                                                    @endforeach
                                                                </select>                   
                                                            </td>
                                                            <td>

                                                            <input type="text" name="lenghts[]" data-name="lenghts" value="" placeholder="eg. 11" class="form-control input-sm" ></td>
                                                            <td>
                                                                <input type="text" name="defaults[]" data-name="defaults" class="form-control input-sm" />                            
                                                            </td>
                                                                                  
                                                            <td class="icheck"><input type="checkbox" name="null[]" data-name="null" value="1"  /></td>
                                                            <td class="icheck"><input type="checkbox" name="key[]" data-name="key" value="1"/></td>
                                                            <td class="icheck"><input type="checkbox" name="ai[]" data-name="ai" value="1"/></td>
                                                            <td class="text-right">
                                                                <a onclick=" $(this).parents('.clonedInput').remove(); return false" href="#" class="remove btn btn-xs red"><i class="fa fa-close"></i></a>  
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                
                                                </table>
                                            
                                            </div>
                                            @if($table)
                                            <a href="javascript:void(0);" class="btn btn-sm yellow-gold" onclick="_Modal('{{url("core/table/$table/field")}}', 'Add Field');"><i class="fa fa-plus"></i> New Field</a>
                                            @else
                                            <a href="javascript:void(0);" class="addC btn btn-sm yellow-gold" rel=".clone"><i class="fa fa-plus"></i> New Field</a> 
                                            @endif
                                            <div class="row">
                                                <hr />
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Submit</button>
                                                    <a href="{{url('core/table')}}" class="btn btn-default">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/simpleclone.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.addC').relCopy({});
        $('.icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
        });
        $('#form-content .fields').focus(function($el){
            $('#form-content .fields').attr('onfocus','');
            var count = $('#form-content .fields').length;
            if($(this).parents('td').parents('tr').hasClass('copy'+(count-1)))
            {
                $('.addC').click();
            }
        });
    });
</script>
@endsection

