jQuery(document).ready(function($){

	$('.icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
    });

  	$('.make-switch').bootstrapSwitch();
	$('.date').datepicker({format:'yyyy-mm-dd',autoclose: true});
	$('.datetime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'}); 

	$.listen('parsley:field:error', function(parsleyField) {
	  	var elem = parsleyField.$element;

	  	if (elem.hasClass('select2-multiple')) {
			var topParent = elem.parent('div').parent('div');
	        topParent.find('ul.parsley-errors-list').each(function() {
				// move $(this) to the bottom of top parent
				topParent.find('div.col-md-7').append($(this));

			});
		}

	  	if (elem.hasClass('select2') || elem.hasClass('editor')) {
			var topParent = elem.parent('div');
	        topParent.find('ul.parsley-errors-list').each(function() {
				// move $(this) to the bottom of top parent
				topParent.append($(this));

			});
		}

		if(elem.hasClass('date') || elem.hasClass('datetime') || elem.hasClass('group')){
			var topParent = elem.parent('div').parent('div');
	        topParent.find('ul.parsley-errors-list').each(function() {
				// move $(this) to the bottom of top parent
				topParent.append($(this));

			});
		}

		if(elem.hasClass('icheck')){
			var topParent = elem.parent('div').parent('label').parent('div');
	        topParent.find('ul.parsley-errors-list').each(function() {
				// move $(this) to the bottom of top parent
				topParent.append($(this));

			});
		}
	});

	/* Tooltip */
	$('.previewImage').fancybox();	
	$('.tips').tooltip();	
	$('.editor').summernote({'height':'200px'});
	$(".select2").select2({ width:"100%" });	
	$('.select2, .date, .datetime').change(function() {
        $(this).parsley().validate();
 	}); 

	$('.icheck').on('ifChecked', function(){
        $(this).parsley().validate();
    });

    $('.icheck').on('ifUnchecked', function(){
        $(this).parsley().validate();
    });

	$(".select-liquid").select2({
		minimumResultsForSearch: "-1",
	});	
	$('.panel-trigger').click(function(e){
		e.preventDefault();
		$(this).toggleClass('active');
	});

	$('.dropdown, .btn-group').on('show.bs.dropdown', function(e){
		$(this).find('.dropdown-menu').first().stop(true, true).fadeIn(100);
	});
	$('.dropdown, .btn-group').on('hide.bs.dropdown', function(e){
		$(this).find('.dropdown-menu').first().stop(true, true).fadeOut(100);
	});
	$('.popup').click(function (e) {
		e.stopPropagation();
	});	
    window.prettyPrint && prettyPrint();

	$(".checkall").click(function() {
		var cblist = $(".ids");
		if($(this).is(":checked"))
		{				
			cblist.prop("checked", !cblist.is(":checked"));
		} else {	
			cblist.removeAttr("checked");
		}	
	});
	
	$('.nav li ul li.active').parents('li').addClass('active');
	
	$('.checkall').on('ifChecked',function(){
		$('input[type="checkbox"]').iCheck('check');
	});
	$('.checkall').on('ifUnchecked',function(){
		$('input[type="checkbox"]').iCheck('uncheck');
	});	

	$('.removeCurrentFiles').on('click',function(){
		var removeUrl = $(this).attr('href');
		$.get(removeUrl,function(response){
			if(response.status == 'success')
			{
				
			}
		});
		$(this).parent('div').empty();	
		return false;
	});	

	$('input.tags').tagsinput();

	$('.multi_fileupload').on('click',function(){
        var id = makeid();
        $('#image_preview').append('<input type="file" name="'+$(this).data('name')+'" id="'+id+'" class="'+id+'" style="display: none;">');
        $('#'+id).click();
        $('#'+id).on('change', function(){
            var file = this.files[0];
            var size = Math.round(file.size/1024);
            var thumbnail = '<div class="col-md-4 '+id+'">'+
                            '    <div class="thumbnail">'+
                            '      <div class="image view view-first">'+
                            '        <img src="'+URL.createObjectURL(file)+'" style="width: 100%; display: block;" height="150">'+
                            '        <a href="javascript:;">'+size+' kbs<i class="fa fa-times" style="float:right; margin-top: 5px;" onclick="remove_image(\''+id+'\');"></i></a>'+
                            '      </div>'+
                            '    </div>'+
                            '</div>';
            $('#image_preview').append(thumbnail);
        });
    });

    $('.bulk_fileinput').on('click',function(){
        var el = $(this);
        var file = $("<input type='file' value='' />")
                     .attr("name",el.attr('data-name'))
                     .click()
                     .on('change', function(){
                            var file = this.files[0];
                            var size = file.size;
                            var thumbnail = '<img src="'+URL.createObjectURL(file)+'">';
                            $(el).find('.fileinput-preview').html(thumbnail);
                        });
        $(this).find('.fileinput').html(file);
    });
		    	
})

function addMoreFiles(id){

   $("."+id+"Upl").append(	'<div class="fileinput fileinput-new" data-provides="fileinput">'+
	                        '    <div class="input-group input-large">'+
	                        '        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">'+
	                        '            <i class="fa fa-file fileinput-exists"></i>&nbsp;'+
	                        '            <span class="fileinput-filename"> </span>'+
	                        '        </div>'+
	                        '        <span class="input-group-addon btn default btn-file">'+
	                        '            <span class="fileinput-new"> Select file </span>'+
	                        '            <span class="fileinput-exists"> Change </span>'+
	                        '            <input type="file" name="'+id+'[]" /> </span>'+
	                        '        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>'+
	                       	'     </div>'+
	                       	' </div>');
}

function _Delete()
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(total == 0)
	{
		alert('Please select one recourd.');
		return false;
	}
	if(confirm('Are u sure removing selected rows ?'))
	{
		$('#_Table').submit();// do the rest here	
	}	
}	

function _Rebuild()
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(total == 0)
	{
		alert('Please select one recourd.');
		return false;
	}
	$('#_Table').attr('action','../core/model/rebuild');
	$('#_Table').submit();
}	

function _Export($url)
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(total == 0)
	{
		alert('Please select one recourd.');
		return false;
	}
	$('#_Table').attr('action',$url);
	$('#_Table').submit();
}	

function _Modal( url , title)
{
	$('#modal-content').html(' ....Loading content , please wait ...');
	$('#modal-title').html(title);
	$('#modal-content').load(url,function(){
	});
	$('#modal').modal('show');	
}

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 9; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function remove_image(id){
    $('.'+id).remove();
}