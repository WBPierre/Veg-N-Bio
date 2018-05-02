<script>
	$(document).ready(function(){
		$('.addMe').on('click',function(){
			var id = $(this).attr('id');
			var text = $(this).find('a').html();
			var price = parseFloat($(this).find('h4').find('strong').html());
			if($('#row'+id).length != 0){
				var qty = parseFloat($('#row'+id).find('td.quantity').html());
				qty = qty + 1;
				var total = parseFloat($('#row'+id).find('td.total').html());
				total = (qty * price) + ' €'; 
				$('#row'+id).find('td.quantity').html(qty);
				$('#row'+id).find('td.total').html(total);
			}else{
				$('.tableListing').find('tbody').append('<tr id="row'+id+'"><td name="id">'+id+'</td><td name="name">'+text+'</td><td name="quantity" class="quantity">1</td><td name="price" class="price">'+price+' €</td><td name="total" class="total">'+price+' €</td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-success waves-effect my-0" onclick="addQuantity('+id+')"><i class="fa fa-plus-circle"></i></button></td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-warning waves-effect my-0" onclick="minusQuantity('+id+')"><i class="fa fa-minus-circle"></i></button></td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-danger waves-effect my-0" onclick="deleteQuantity('+id+')"><i class="fa fa-times-circle"></i></button></td></tr>');
			}
			updateTotal();
		});
		$('#clearOrder').on('click',function(){
			$('.tableListing').find('tbody').find('tr').each(function(){
				$(this).remove();
			});
			updateTotal();
		});
		$('.addModal').on('click',function(){
			var body  = $(this).parent().parent().find('.modal-body');
			var id = $(body).find('#idMenu').val();
			var type = $(body).find('#typeMenu').val();
			var name = $(body).find('#nameMenu').val();
			var price = $(body).find('#priceMenu').val();
			if(type == 2){
				var selected1 = $(body).find('.selection1 option:selected').val();
				var selected2 = $(body).find('.selection2 option:selected').val();
				var selected3 = $(body).find('.selection3 option:selected').val();
				var selected4 = $(body).find('.selection4 option:selected').val();
				var selected1Text = $(body).find('.selection1 option:selected').text();
				var selected2Text = $(body).find('.selection2 option:selected').text();
				var selected3Text = $(body).find('.selection3 option:selected').text();
				var selected4Text = $(body).find('.selection4 option:selected').text();
				$('.tableListing').find('tbody').append('<tr id="row'+id+'" class="menu"><input type="hidden" value="'+selected1+'" name="0" class="selected1 selection"><input type="hidden" value="'+selected2+'" name="1" class="selected2 selection"><input type="hidden" value="'+selected3+'" name="2" class="selected3 selection"><input type="hidden" value="'+selected4+'" name=3 class="selected4 selection"><td>'+id+'</td><td><a onclick="toastr.info(`'+selected1Text+', '+selected2Text+', '+selected3Text+' & '+selected4Text+'`);"><i class="fa fa-info-circle"> '+name+'</i></a></td><td name="quantity" class="quantity">1</td><td  name="price" class="price">'+price+' €</td><td name="total" class="total">'+price+' €</td></a><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-success waves-effect my-0" onclick="addQuantity('+id+')"><i class="fa fa-plus-circle"></i></button></td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-warning waves-effect my-0" onclick="minusQuantity('+id+')"><i class="fa fa-minus-circle"></i></button></td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-danger waves-effect my-0" onclick="deleteQuantity('+id+')"><i class="fa fa-times-circle"></i></button></td></tr>');
			}else{
				var selected1 = $(body).find('.selection1 option:selected').val();
				var selected2 = $(body).find('.selection2 option:selected').val();
				var selected1Text = $(body).find('.selection1 option:selected').text();
				var selected2Text = $(body).find('.selection2 option:selected').text();
				$('.tableListing').find('tbody').append('<tr id="row'+id+'" class="menu"><input type="hidden" value="'+selected1+'" name="0" class="selected1 selection"><input type="hidden" value="'+selected2+'" name="1" class="selected2 selection"><td name="id">'+id+'</td><td name="name"><a onclick="toastr.info(`'+selected1Text+' & '+selected2Text+'`);"><i class="fa fa-info-circle"> '+name+'</i></a></td><td name="quantity" class="quantity">1</td><td name="price" class="price">'+price+' €</td><td name="total" class="total">'+price+' €</td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-success waves-effect my-0" onclick="addQuantity('+id+')"><i class="fa fa-plus-circle"></i></button></td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-warning waves-effect my-0" onclick="minusQuantity('+id+')"><i class="fa fa-minus-circle"></i></button></td><td class="doNotAdd"><button type="button" class="btn btn-sm transparent btn-outline-danger waves-effect my-0" onclick="deleteQuantity('+id+')"><i class="fa fa-times-circle"></i></button></td></tr>');
			}
			updateTotal();
			$('#modal'+id).modal('hide');
		});
		$('#payByCB').on('click', function(){
			var total = parseFloat($('.totalCheckOut').html());
			if(total > 0){
				$("#totalCheckOutModal").html('Total : ' + $('.totalCheckOut').html()+ ' €');
				$('#payModalSuccess').modal('show');
			}
		});
		$('#payByCash').on('click', function(){
			var total = parseFloat($('.totalCheckOut').html());
			if(total > 0){
				$("#totalCheckOutCashModal").html('Total : ' + $('.totalCheckOut').html()+ ' €');
				$('#cashModal').modal('show');
			}
		});
		 $('#cashModal').on('shown.bs.modal', function (e) {
		 	$('#inputLGEx').focus();
		 });

		 $('#inputLGEx').keyup(function(){
		 	console.log(parseFloat($('#inputLGEx').val()));
		 	var du = parseFloat($('#inputLGEx').val()) - parseFloat($('.totalCheckOut').html());
		 	if(du >= 0){
			 	$('#inputDisabledEx').val(du.toFixed(2)+' €');
		 	}else{
		 		$('#inputDisabledEx').val(0);
		 	}
		 });

		 $('#payByCashConfirm').on('click', function(){
		 	pay();
		 	$('#cashModal').modal('hide');
		 });

		 $('#payByCBConfirm').on('click',function(){
		 	pay();
		 	$('#payModalSuccess').modal('hide');
		 });
	});
	function addQuantity(id){
		var price = parseFloat($('#row'+id).find('td.price').html());
		var qty = parseFloat($('#row'+id).find('td.quantity').html());
		qty = qty + 1;
		var total = parseFloat($('#row'+id).find('td.total').html());
		total = (qty * price) + ' €'; 
		$('#row'+id).find('td.quantity').html(qty);
		$('#row'+id).find('td.total').html(total);
		updateTotal();
	}

	function minusQuantity(id){
		var price = parseFloat($('#row'+id).find('td.price').html());
		var qty = parseFloat($('#row'+id).find('td.quantity').html());
		qty = qty - 1;
		if(qty <= 0){
			$('#row'+id).remove();
		}else{
			var total = parseFloat($('#row'+id).find('td.total').html());
			total = (qty * price) + ' €'; 
			$('#row'+id).find('td.quantity').html(qty);
			$('#row'+id).find('td.total').html(total);
		}
		updateTotal();
		
	}

	function deleteQuantity(id){
		$('#row'+id).remove();
		updateTotal();
	}

	function updateTotal(){
		var total = 0;
		$('.tableListing').find('tbody').find('tr').each(function(){
			var value = 0;
			value = parseFloat($(this).find('td.total').html());
			total = total + value;
		});
		$('.totalCheckOut').html(total);
	}
	function pay(){
		var total = parseFloat($('.totalCheckOut').html());
			if(total > 0){
				var array = {};
				var i =0;
				$('.tableListing').find('tbody').find('tr').each(function(){
					var row = {};
					if($(this).hasClass('menu')){
						$(this).find('.selection').each(function(){
							row[$(this).attr('name')] = $(this).val();
						});
					}
					$(this).find('td').each(function(){
							if($(this).hasClass('doNotAdd')){

							}else{
								if($(this).attr('name') == 'name' && $(this).parent().hasClass('menu')){
									row[$(this).attr('name')] = $(this).find('a').find('i').html().substr(1);
								}else{
									row[$(this).attr('name')] = $(this).html();
								}
							}
					});
					array[i] = row;
					i++;
				});
				var jsonArray = {data:JSON.stringify(array)};
				$.ajax({
					url: "templates/cashDesk/ajax.php", 
					type: "POST",
					data: jsonArray,
					success: function(result){
						if(result == true){
							toastr.info('{{ trans.orderInProcess }}');
						}else{
							toastr.warning('{{ trans.actionError }}');
						}
            		
            		// $('#clearOrder').click();
        		}});
			}
	}
</script>