<form action="{{url('core/storage/perms')}}" method="POST">
     {{csrf_field()}}
     <input type="hidden" name="_file" value="{{$path}}">
     <div class="form-horizontal">
          <div class="form-group row" >
               <label class="col-md-12">Owner Permissions</label>
               <div class="col-md-12">
                    <div class="row">
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="owner[]" value="400" @if($perms >= 400) checked @endif> Read
                              </label>
                         </div>
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="owner[]" value="200" @if($perms >= 600) checked @endif> Write
                              </label>
                         </div>
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="owner[]" value="100" @if($perms >= 700) checked @endif> Execute
                              </label>
                         </div>
                    </div>
                    <hr>
               </div>
               <label class="col-md-12">Group Permissions</label>
               <div class="col-md-12">
                    <div class="row">
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="group[]" value="40" @if($perms >= 740) checked @endif> Read
                              </label>
                         </div>
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="group[]" value="20" @if($perms >= 760) checked @endif> Write
                              </label>
                         </div>
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="group[]" value="10" @if($perms >= 770) checked @endif> Execute
                              </label>
                         </div>
                    </div>
                    <hr>
               </div>
               <label class="col-md-12">Public Permissions</label>
               <div class="col-md-12">
                    <div class="row">
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="public[]" value="4" @if($perms >= 774) checked @endif> Read
                              </label>
                         </div>
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="public[]" value="2" @if($perms >= 776) checked @endif> Write
                              </label>
                         </div>
                         <div class="col-md-4">
                              <label>
                                   <input type="checkbox" class="permission" name="public[]" value="1" @if($perms >= 777) checked @endif> Execute
                              </label>
                         </div>
                    </div>
                    <hr>
               </div>
               <div class="col-md-9 col-md-offset-3">
                   <input type="submit" class="btn green" value="Save Changes " />
                   <input type="button" class="btn btn-default" value="Cancel" data-dismiss="modal" aria-hidden="true"/>
               </div>
          </div>
     </div>
</form>
<script type="text/javascript">
     $(document).ready(function () {
          $('input[type="checkbox"],input[type="radio"]').iCheck({
             checkboxClass: 'icheckbox_square-red',
             radioClass: 'iradio_square-red',
          });
     });
</script>