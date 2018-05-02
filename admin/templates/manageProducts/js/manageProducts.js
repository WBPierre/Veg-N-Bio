<script>
$(document).ready(function(){
	var product;
	var ingredient = -1;
	$('.checkThisProduct').on('click',function(){
		 product = $(this).val();
	});
	$('.modifyProduct').on('click',function(){
		$('#'+product).modal('show');
	});
	$('.deleteProduct').on('click',function(){
		$('#delete_'+product).modal('show');
	});
	$('.swap').on('click',function(){
		$('#classic'+product).toggle("fast");
		$('#stock'+product).toggle("fast");
	});
	$('#addProductButton').on('click',function(){
		ingredient++;
		$('.addProductAddIngredients').append("<div class='row'><div class='col-md-6'><div class='md-form form-group'><input type='text' class='form-control' id='inputIngredient"+ingredient+"' name='ingredient"+ingredient+"'><label for='inputIngredient"+ingredient+"'>{{ trans.name }}</label></div></div><div class='col-md-6'><div class='md-form form-group'><input type='text' class='form-control' id='inputQuantity"+ingredient+"' name='quantity"+ingredient+"'><label for='inputQuantity"+ingredient+"'>{{ trans.quantity }}</label></div></div>");
	});
	$('#switchAddMenu').on('click',function(){
		$('#selectMenu').toggle('slow');
	});
});
</script>