/**
 * jQuery-Plugin "relCopy"
 * 
 * @version: 1.1.0, 25.02.2010
 * 
 * @author: Andres Vidal
 *          code@andresvidal.com
 *          http://www.andresvidal.com
 *
 * Instructions: Call $(selector).relCopy(options) on an element with a jQuery type selector 
 * defined in the attribute "rel" tag. This defines the DOM element to copy.
 * @example: $('a.copy').relCopy({limit: 5}); // <a href="example.com" class="copy" rel=".phone">Copy Phone</a>
 *
 * @param: string	excludeSelector - A jQuery selector used to exclude an element and its children
 * @param: integer	limit - The number of allowed copies. Default: 0 is unlimited
 * @param: string	append - HTML to attach at the end of each copy. Default: remove link
 * @param: string	copyClass - A class to attach to each copy
 * @param: boolean	clearInputs - Option to clear each copies text input fields or textarea
 * 
 */

(function($) {

	$.fn.relCopy = function(options) {
		var settings = jQuery.extend({
			excludeSelector: ".exclude",
			emptySelector: ".empty",
			copyClass: "copy",
			append: '',
			clearInputs: true,
			limit: 0 // 0 = unlimited
		}, options);
		
		settings.limit = parseInt(settings.limit);
		
		// loop each element
		this.each(function() {
			
			// set click action
			$(this).click(function(){
				if ($('.bulk-form select.select2').data('select2')) {
				   $('.bulk-form select.select2').select2('destroy');
				}
				$('.bulk-form input.tags').tagsinput('destroy');
				$('.bulk-form .date').datepicker('remove');
				$('.bulk-form .datetime').datetimepicker('remove');

				var rel = $(this).attr('rel'); // rel in jquery selector format				
				var counter = $(rel).length;
				// stop limit
				if (settings.limit != 0 && counter >= settings.limit){
					return false;
				};
				
				var master = $(rel+":first");
				var parent = $(master).parent();						
				var clone = $(master).clone(true).addClass(settings.copyClass+counter).append(settings.append);
				
				//Remove Elements with excludeSelector
				if (settings.excludeSelector){
					$(clone).find(settings.excludeSelector).remove();
				};
				
				//Empty Elements with emptySelector
				if (settings.emptySelector){
					$(clone).find(settings.emptySelector).empty();
				};								
				
				// Increment Clone IDs
				if ( $(clone).attr('id') ){
					var newid = $(clone).attr('id') + (counter +1);
					$(clone).attr('id', newid);
				};
				
				// Increment Clone Children IDs
				$(clone).find('[id]').each(function(){
					var newid = $(this).attr('id') + (counter +1);
					$(this).attr('id', newid);
					$(this).attr('data-row', counter + 1);
				});

				// Increment Clone Children IDs
				$(clone).find('[name]').each(function(){
					if($('.table-responsive').hasClass('detailview')){
						var newName = $(this).attr('name').replace('[0]', '')+'['+counter+']';
						$(this).attr('name', newName);
					}
				});

				// Increment Clone Children IDs
				$(clone).find('.bulk-form [data-name]').each(function(){
					if($('.table-responsive').hasClass('detailview')){
						var newName = $(this).attr('data-name').replace('[0]', '')+'['+counter+']';
						$(this).attr('data-name', newName);
					}
				});
			
				$(clone).find('.fileinput-preview').each(function(){
					$(this).html('<img src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />');
				});
				
				//Clear Inputs/Textarea
				if (settings.clearInputs){
					$(clone).find(':input').each(function(){
						var type = $(this).attr('type');
						switch(type)
						{
							case "select":
								break;
							case "button":
								break;
							case "reset":
								break;
							case "submit":
								break;
							case "radio":
								break;
							case "checkbox":
								$(this).prop("checked", false);
								break;
							default:
							  	$(this).val("");
						}						
					});	

									
				};
				$(parent).find(rel+':last').after(clone);

				$('.bulk-form .icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck('destroy');
				$('.bulk-form .icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                }); 

				$('.bulk-form .select2').select2();

				$(parent).find(rel+':last').each(function()
				{
					var script = '';
					$(this).find('select').each(function(){
						var param = '';
						if($(this).data('isdependency') == 1){
							param = '&parent='+$(this).data('dependency')+':';
							script += '$("#'+$(this).attr('id')+'").jCombo("'+$(this).data('url')+param+'",{ parent:"#bulk_'+$(this).data('dependency')+$(this).attr('data-row')+'", selected_value : "" });';
						}else{
							script += '$("#'+$(this).attr('id')+'").jCombo("'+$(this).data('url')+'");';
						}
					});
					
					$('<script>')
				    .attr('type', 'text/javascript')
				    .text(script)
				    .appendTo($(this));

				});

				$('.bulk-form input.tags').tagsinput();
				$('.bulk-form .bulk-fileinput').fileinput('clear');
				$('.bulk-form .date').datepicker({format:'yyyy-mm-dd',autoClose:true});
				$('.bulk-form .datetime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});

				return false;
				
			}); // end click action
			
		}); //end each loop
		
		return this; // return to jQuery
	};
	
})(jQuery);