
<!-- BEGIN FORM-->
<form action="{{url($action)}}" method="post" class="form-horizontal" data-parsley-validate>
    {{csrf_field()}}
    <div class="form-body">
        <div class="form-group margin-top-10">
            <label class="control-label col-md-3">Table Name
                <span class="required"> * </span>
            </label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="name" value="" placeholder="eg. Category" required />
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
        <div class="note note-danger">
            <p>NOTE: Don't neet to set <code>created_at and updated_at</code> that would created by default. </p>
        </div>
        <hr>
        <div class="table-responsive bulk-form">
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
                            <a href="{{ url('core/model/'.$table.'/field?'.$info) }}" class="btn btn-xs green" onclick="_Modal(this.href,'Edit Column : {{$column['Field']}} '); return false;" ><i class="fa fa-edit "></i></a>
                            <a href="{{ url('core/model/'.$table.'/'.$column['Field'].'/remove') }}" onclick="return confirm('Are you sure want to delete?');" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>
                        </td>
                                        
                    </tr>
                @endforeach
                @else
                    <tr class="clone clonedInput">
                        
                        <td>
                            <input type="text" autocomplete="off" onfocus="$('.addC').click();" name="fields[]" data-name="fields" value="" class="form-control fields input-sm">
                        </td>
                        <td>                    
                            <select name="types[]" data-name="types" type="select" class="form-control input-sm" >
                                @foreach($tbtypes as $t)
                                 <option value="{{ $t }}" >{{ $t }}</option>
                                @endforeach
                            </select>                   
                        </td>
                        <td>

                        <input type="text" name="lenghts[]" data-name="lenghts" value="" class="form-control input-sm" ></td>
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
        <a href="javascript:void(0);" class="btn btn-sm yellow-gold" onclick="_Modal('{{url("core/model/$table/field")}}', 'Add Field');"><i class="fa fa-plus"></i> New Field</a>
        @else
        <a href="javascript:void(0);" class="addC btn btn-sm yellow-gold" rel=".clone"><i class="fa fa-plus"></i> New Field</a> 
        @endif
        <div class="row">
            <hr />
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Submit</button>
                <a href="{{url('core/model/create')}}" class="btn btn-default">Cancel</a>
            </div>
        </div>
    </div>
</form>
<!-- END FORM-->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.addC').relCopy({});
    $('.icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
    });
    $('#advenced-settings').click(function(){
      $('.advenced-settings').toggle('show');
    });
    $('#form-content .fields').focus(function($el){
        $('#form-content .fields').attr('onfocus','');
        var count = $('#form-content .fields').length;
        if($(this).parents('td').parents('tr').hasClass('copy'+(count-1)))
        {
            $('.addC').click();
        }
    });
    
</script>