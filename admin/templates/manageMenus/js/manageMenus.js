<script>
$(document).ready(function(){
	var menu;
	$('.checkThisMenu').on('click',function(){
		 menu = $(this).val();
	});
	$('.modifyMenu').on('click',function(){
		$('#modify'+menu).modal('show');
	});
	$('.deleteMenu').on('click',function(){
		$('#delete_'+menu).modal('show');
	});
});
</script>