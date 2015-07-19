$(function(){
	$("#addField").click(function(){
		var number = parseInt($("#numberField").val(), 10);
		var fieldName = "<input class='fieldName' placeholder='field name' type='text' name='fieldName"+number+"'/>";
		var fieldValue = "<input class='fieldValue' placeholder='field value' type='text' name='fieldValue"+number+"'/>";
		
		$("#trashCustomField").remove();
		
		$("<label id='label"+number+"'></label>").insertBefore($("#numberField"));
		$(fieldName).appendTo($("#label"+number));
		$(fieldValue).appendTo($("#label"+number));
		$("<i id='trashCustomField' onclick='trashCustomField()' class='fa fa-trash'></i>").appendTo($("#label"+number));
		
		$("#numberField").val(number+1)
	});
	
	$('.trashField').click(function(){
		var result = confirm("This action will permanently remove this field. Are you sure you want to delete it?");
		if(result === true){
			$(this).parent().remove();
		}
	});
	
	$('.removeUser').click(function(){
		return confirm("Are you sure you want to delete this user?");
	});
	
	$('.removeDocument').click(function(){
		return confirm("Are you sure you want to delete this document?");
	});
	
	$('.removeCollection').click(function(){
		return confirm("Are you sure you want to delete this collection?");
	});
	
	$('.removeDatabase').click(function(){
		return confirm("Are you sure you want to delete this database?\nThis action will also delete users from the database.");
	});
});