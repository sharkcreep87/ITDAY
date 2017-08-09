{!! Form::open(array('url'=>'#', 'class'=>'form-horizontal ','data-parsley-validate'=>'')) !!}
 <div class="form-group">
  <label for="ipt" class=" control-label col-md-4"> Access Token </label>
	<div class="col-md-8">
    <textarea name="access_token" rows="5" id="access_token" class="form-control input-sm" value="" required="true">{{$oauth->access_token}}</textarea>
	</div> 
</div>  
<div class="form-group">
  <label for="ipt" class=" control-label col-md-4"> Expires In </label>
  <div class="col-md-8">
    <input name="expires_in" type="text" id="expires_in" class="form-control input-sm" value="{{$oauth->expires_in}}" required="true" /> 
  </div> 
</div>  
<div class="form-group">
  <label for="ipt" class=" control-label col-md-4"> Token Type </label>
  <div class="col-md-8">
    <input name="name" type="token_type" id="token_type" class="form-control input-sm" value="{{$oauth->token_type}}" required="true" /> 
  </div> 
</div>  
<div class="form-group">
  <label for="ipt" class=" control-label col-md-4"> &nbsp; </label>
  <div class="col-md-8">
    <button type="button" class="btn green mt-clipboard" data-clipboard-action="copy" data-clipboard-target="#access_token">Copy Token</button>
    <button type="button" data-dismiss="modal" aria-hidden="true" name="search" class="doSearch btn btn-default"> Cancel </button>
  </div> 
</div>    
{!! Form::close() !!} 
<script src="{{ asset('apitoolz-assets/global/plugins/clipboardjs/clipboard.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var ComponentsClipboard = function() {
      return {
          init: function() {
              var t;
              $(".mt-clipboard").each(function() {
                  var o = new Clipboard(this);
                  o.on("success", function(o) {
                      t = o.text, console.log(t)
                  })
              }), $(".mt-clipboard").click(function() {
                  if (1 == $(this).data("clipboard-paste"))
                      if (t) {
                          var o = $(this).data("paste-target");
                          $(o).val(t), $(o).html(t)
                      } else alert("No text was copied or cut.")
              })
          }
      }
    }();
    jQuery(document).ready(function() {
      ComponentsClipboard.init()
    });
  });
</script>