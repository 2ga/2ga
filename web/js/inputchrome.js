/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// Stop chrome's autocomplete from making your input fields that nasty yellow. Yuck.
if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0)
{
	$(window).load(function()
	{
		$('input:-webkit-autofill').each(function()
		{
			var text = $(this).val();
			var name = $(this).attr('name');
			$(this).after(this.outerHTML).remove();
			$('input[name=' + name + ']').val(text);
		});
	});
}
if ($.browser.webkit) {
    $('input[name="password"]').attr('autocomplete', 'off');
}