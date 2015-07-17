$(function(){
	$("#addField").click(function(){
		var number = parseInt($("#numberField").val(), 10);
		var fieldName = "<input class='fieldName' placeholder='field name' type='text' name='fieldName"+number+"'/>";
		var fieldValue = "<input class='fieldValue' placeholder='field value' type='text' name='fieldValue"+number+"'/><br/>";
		$("<label id='label"+number+"'></label>").insertBefore($("#numberField"));
		$(fieldName).appendTo($("#label"+number));
		$(fieldValue).appendTo($("#label"+number));
		
		$("#numberField").val(number+1)
	});
})