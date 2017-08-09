@extends('core.model.config')
@section('form')
<div class="note note-danger">
    <p> <strong>Primary Key </strong> must be <strong>show</strong> and in <strong>hidden</strong> type </p>
</div>
<form action="{{url('core/model/config/'.$row->module_id.'/form')}}" method="post" class="form-horizontal">
    {{csrf_field()}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table">
            <thead class="no-border">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Field</th>
                    <th scope="col" width="100"><i class="fa fa-key"></i> Limit To</th>
                    <th scope="col" data-hide="phone">Title / Caption </th>

                    <th scope="col" data-hide="phone">Type </th>
                    <th scope="col" data-hide="phone">Show</th>

                    <th scope="col" data-hide="phone">Searchable</th>
                    <th scope="col" data-hide="phone">Required</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody class="no-border-x no-border-y">
                <?php 
                    usort($config['forms'], "SiteHelpers::_sort");
                    $i=0; 
                ?>  
                @foreach($config['forms'] as $rows)
                <?php if(!isset($rows['input_group'])) $rows['input_group'] = []; ?>
                <tr>
                    <td>
                        {{$i + 1}}
                        <input type="hidden" name="sortlist[{{$i}}]" value="{{$i}}">
                    </td>
                    <td>
                        {{$rows['field']}}
                    </td>
                    <td>
                        <?php
                            $limited_to = (isset($rows['limited']) ? $rows['limited'] : '');
                        ?>
                        <input type="text" class="form-control input-sm" name="limited[{{$i}}]" class="limited" value="{{$limited_to}}" />

                    </td>
                    <td>
                        <input type="text" name="label[{{$i}}]" class="form-control input-sm" value="{{$rows['label']}}" />

                    </td>
                    <td>
                        {{$rows['type']}}
                        <input type="hidden" name="type[{{$i}}]" value="{{$rows['type']}}" />
                    </td>
                    <td>
                        <label class="icheck">
                            <input type="checkbox" name="view[{{$i}}]" value="1" @if($rows[ 'view']==1 ) checked @endif />
                        </label>
                    </td>

                    <td>
                        <label class="icheck">
                            <input type="checkbox" name="search[{{$i}}]" value="1" @if($rows[ 'search']==1 ) checked @endif />
                        </label>
                    </td>
                    <td>
                        <select name="required[{{$i}}]" id="required" class="form-control input-sm" style="width:150px;">
                            <option value="0" @if($rows['required']==1 ) selected @endif>No Required</option>
                            @foreach($reqType as $item=>$val)
                            <option value="{{$item}}" @if($rows['required']== $item) selected @endif>
                                {{$val}}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-xs green editForm" role="button" onclick="_Modal('{{ url('core/model/config/'.$row->module_id.'/field?form_field='.$rows['field'].'&form_alias='.$rows['alias']) }}','Edit Field : {{$rows['field']}}')">
                            <i class="fa fa-cog"></i>
                        </a>
                    </td>

                </tr>
                <?php $i++; ?>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn green"> Save Changes </button>
</form>
@endsection