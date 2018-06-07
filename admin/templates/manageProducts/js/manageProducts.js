<script>
$(document).ready(function(){
	var product;
	var ingredient = -1;
	var swap = 0;
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
		if(swap%2 == 0){
            $(this).html(backToProduct);
		}else{
            $(this).html(comsumption);
		}
		swap++;
	});
	$('#addProductButton').on('click',function(){
		ingredient++;
		var html = '';
		html += "<div class='row'><div class='col-md-6'><div class='md-form form-group'>";
        html += '<select class="mdb-select2 initialized addComponant" name="ingredient'+ingredient'" form="addProductForm">';
		{% for key,value in component %}
			html+= "<option value='{{ value['id'] }}'>{{ value['name'] }}</option>";
		{% endfor %}
        html += '</select>';
        html += '<label>{{ trans.selectComponant }}</label>';
		html += "</div></div><div class='col-md-6'><div class='md-form form-group'>";
		html += "<input type='text' class='form-control' id='inputQuantity"+ingredient+"' name='quantity"+ingredient+"'>";
		html += "<label for='inputQuantity"+ingredient+"'>{{ trans.quantity }}</label></div></div></div>";
		$('.addProductAddIngredients').append(html);
        $('.mdb-select2').material_select();
        $('.addComponant').removeClass('mdb-select2');
	});
	$('#switchAddMenu').on('click',function(){
		$('#selectMenu').toggle('slow');
	});

});
</script>