// JavaScript Document
function makeSublist(parent,child,isSubselectOptional,childVal)
{
	$("body").append("<select style='display:none' id='"+parent+child+"'></select>");

	$('#'+parent+child).html($("#"+child+" option"));

	

		var parentValue = $('#'+parent).attr('value');

		$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());

	

	childVal = (typeof childVal == "undefined")? "" : childVal ;

	$("#"+child+' option[@value="'+ childVal +'"]').attr('selected','selected');

	

	$('#'+parent).change( 

		function()

		{

			var parentValue = $('#'+parent).attr('value');

			$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());

			if(isSubselectOptional) $('#'+child).prepend("<option value='none'> -- Seleccionar Categoria -- </option>");

			$('#'+child).trigger("change");

                        $('#'+child).focus();

		}

	);

}



	$(document).ready(function()

	{

		makeSublist('marcas','var_modelo', true, '1');
		
		makeSublist('grandsun','marcas', true, '1');
		
		makeSublist('child','grandsun', true, '1');	

		makeSublist('parent','child', true, '1');
		
			

	});