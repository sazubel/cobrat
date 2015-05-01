<div id="footer">
	Copyright &copy; 2012, MadeByAmp Themes.
</div>

<script src="<?php  echo  base_url();?>js/all.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/jquery.bockUI.js"></script>
<script src="<?php echo base_url();?>/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>/js/jquery.dataTables.rowGrouping.js" type="text/javascript"></script>


<script>
$(function () { 
	$( ".datepicker" ).datepicker();
	$( ".datepicker_inline" ).datepicker();
	$('.colorpickerHolder').ColorPicker({flat: true});
	$('.timepicker').timepicker ({ 
		showPeriod: true 
		, showNowButton: true
		, showCloseButton: true
	});
	
	$('.timepicker_inline_div').timepicker({
	   defaultTime: '9:20'
	});		
		
	$('.colorSelector').ColorPicker({
		color: '#FF9900',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onSubmit: function (hsb, hex, rgb, el) {
			$(el).ColorPickerHide ();	
		},
		onChange: function (hsb, hex, rgb) {
			$('.colorSelector div').css({ 'background-color': '#' + hex });
			$('.colorpickerField1').val ('#' + hex);
		}
	});
	
	$('#colorpickerField1').live ('keyup', function (e) {
		var val = $(this).val ();
		val = val.replace ('#', '');
		$('.colorSelector div').css({ 'background-color': '#' + val });
		$('.colorSelector').ColorPickerSetColor(val);
	});

});

</script>

</body>


</html>