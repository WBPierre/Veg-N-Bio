<script>

$(document).ready(function(){
        var valueDiscount = 0;
        var item =0;
        var menu = 0;
        $('.addToList').on('click',function(){
           var id = $(this).find('input').val();
           var data = $(this).find('.getCarac').html();
           if($('.itemList').find('ul').attr('id') == 0){
               $('.itemList').find('ul').html('<li class="list-group-item" id="'+id+'" index="'+item+'"><i class="fa fa-minus-square" onclick="deleteItem('+item+')" aria-hidden="true" style="cursor:pointer"></i> '+data+'</li>');
               $('.itemList').find('ul').attr('id','1');
           }else{
               $('.itemList').find('ul').append('<li class="list-group-item" id="'+id+'" index="'+item+'"><i class="fa fa-minus-square" onclick="deleteItem('+item+')" aria-hidden="true" style="cursor:pointer"></i> <text>'+data+'</text></li>');
           }
           item++;
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
                if($('.itemList').find('ul').attr('id') == 0){
                    $('.itemList').find('ul').html('<li class="list-group-item menuItem" index="'+item+'" value="'+menu+'" id="'+id+'" style="cursor:pointer;"><i class="fa fa-minus-square" onclick="deleteItem('+item+')" aria-hidden="true" style="cursor:pointer"></i>  <text onclick="toastr.info(\''+selected1Text+' - '+selected2Text+' - '+selected3Text+' - '+selected4Text+'\');" style="cursor:pointer;">'+name+' - <price>'+price+'</price> €</text><input type="hidden" name="'+menu+'_'+0+'" value="'+selected1+'"><input type="hidden" name="'+menu+'_'+1+'" value="'+selected2+'"><input type="hidden" name="'+menu+'_'+2+'" value="'+selected3+'"><input type="hidden" name="'+menu+'_'+3+'" value="'+selected4+'"></li>');
                    $('.itemList').find('ul').attr('id','1');
                }else{
                    $('.itemList').find('ul').append('<li class="list-group-item menuItem" index="'+item+'" value="'+menu+'" id="'+id+'"><i class="fa fa-minus-square" onclick="deleteItem('+item+')" aria-hidden="true" style="cursor:pointer"></i>  <text onclick="toastr.info(\''+selected1Text+' - '+selected2Text+' - '+selected3Text+' - '+selected4Text+'\');" style="cursor:pointer;">'+name+' - <price>'+price+'</price> €</text><input type="hidden" name="'+menu+'_'+0+'" value="'+selected1+'"><input type="hidden" name="'+menu+'_'+1+'" value="'+selected2+'"><input type="hidden" name="'+menu+'_'+2+'" value="'+selected3+'"><input type="hidden" name="'+menu+'_'+3+'" value="'+selected4+'"></li>');
                }
            }else{
                var selected1 = $(body).find('.selection1 option:selected').val();
                var selected2 = $(body).find('.selection2 option:selected').val();
                var selected1Text = $(body).find('.selection1 option:selected').text();
                var selected2Text = $(body).find('.selection2 option:selected').text();
                if($('.itemList').find('ul').attr('id') == 0){
                    $('.itemList').find('ul').html('<li class="list-group-item menuItem" index="'+item+'" value="'+menu+'" id="'+id+'"><i class="fa fa-minus-square" onclick="deleteItem('+item+')" aria-hidden="true" style="cursor:pointer"></i>  <text onclick="toastr.info(\''+selected1Text+' - '+selected2Text+'\');" style="cursor:pointer;">'+name+' - <price>'+price+'</price> €</text><input type="hidden" name="'+menu+'_'+0+'" value="'+selected1+'"><input type="hidden" name="'+menu+'_'+1+'" value="'+selected2+'"></li>');
                    $('.itemList').find('ul').attr('id','1');
                }else{
                    $('.itemList').find('ul').append('<li class="list-group-item menuItem" index="'+item+'" value="'+menu+'" id="'+id+'"><i class="fa fa-minus-square" onclick="deleteItem('+item+')" aria-hidden="true" style="cursor:pointer"></i>  <text onclick="toastr.info(\''+selected1Text+' - '+selected2Text+'\');" style="cursor:pointer;">'+name+' - <price>'+price+'</price> €</text><input type="hidden" name="'+menu+'_'+0+'" value="'+selected1+'"><input type="hidden" name="'+menu+'_'+1+'" value="'+selected2+'"></li>');
                }
            }
            menu++;
            item++;
            updateTotal();
            $('#modal'+id).modal('hide');
        });

        // TO END

        $('#discountActivate').on('click',function(){
            var code = $('#codeDiscount').val();
            $.ajax({
                method: "POST",
                url: "/var/checkDiscount.php",
                async: false,
                data: { code: code }
            })
                .done(function( msg ) {
                    if(msg != 0){
                        valueDiscount = parseInt(msg);
                        $('.itemList').find('ul').append('<li class="list-group-item discountCodeInside" id="'+code+'">'+discountText+' : '+msg+' €</li>');
                        $('#discount').modal('hide');
                    }
                });
        });

        $('#goToOrder').on('click',function(){
            var care = 0;
            var cpt = 0;
            var jcode = "{";
            $( ".itemList" ).find('ul').find('li').each(function() {
                if(care != 0){
                    jcode += ",";
                }
                if($(this).hasClass("discountCodeInside")){
                    jcode += "\"discount\":\""+$(this).attr('id')+"\"";
                }else{
                    if($(this).hasClass("menuItem")){
                        jcode += "\""+cpt+"\":{\"id\":\""+$(this).attr('id')+"\"";
                        $(this).find('input').each(function() {
                            jcode += ",\""+$(this).attr('name')+"\":\""+$(this).val()+"\"";
                        });
                        jcode += "}";
                        cpt++;
                    }else{
                        jcode += "\""+$(this).attr('index')+"\":\""+$(this).attr('id')+"\"";
                    }
                }
                care++;
            });
            jcode += "}";
            window.location.replace("/var/completeOrder.php?json="+jcode);
        });


        $('#cancelOrder').on('click',function(){
            menu = 0;
            item = 0;
            valueDiscount = 0;
            $( ".itemList" ).find('ul').find('li').each(function(){
                $(this).remove();
            });
            $('.itemList').find('ul').attr('id','0');
            $('.itemList').find('ul').html('<li class="list-group-item">'+emptyCart+'</li>');
            $('.totalValue').find('total').html("0.00");
        });


        $('.mdb-select').material_select();
    });
function deleteItem(item){
    $( ".itemList" ).find('ul').find('li').each(function() {
        if($(this).attr("index") == item){
            $(this).remove();
        }
    });
    updateTotal();
}

function updateTotal(){
    var total = 0;
    $( ".itemList" ).find('ul').find('li').each(function(){
        total += parseInt($(this).find('price').html());
    });
    $('.totalValue').find('total').html(total);
    if(total == 0){
        $('.itemList').find('ul').attr('id','0');
        $('.itemList').find('ul').html('<li class="list-group-item">'+emptyCart+'</li>');
        $('.totalValue').find('total').html("0.00");
    }
}

</script>