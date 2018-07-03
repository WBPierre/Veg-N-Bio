<?php


require_once "../../config/config.php";

$db = new DatabaseController();

$id = $db->fetchAll('SELECT * FROM vnb_order  WHERE state = 0');


foreach( $id as $id_order){
    $order = $db->fetchAll('SELECT * FROM vnb_order_product  WHERE id_order ='. $id_order['id']);
    $orderMenu = $db->fetchAll('SELECT * FROM vnb_order_menu  WHERE id_order ='. $id_order['id']);

    echo '<div class="card col-lg-3 float-left m-2">'
            .'<div class="card-body white-text rounded-bottom">'
                .'<div class="black-text">Commande n°'. $id_order['id'].'</div>'
                .'<div class="black-text">'.$id_order['date_inserted'].'</div>'
                .'<ul class="list-group">';

    foreach( $order as $id_product) {
        $product = $db->fetch('SELECT * FROM vnb_restaurant_product  WHERE id =' . $id_product['id_product']);
        echo "<li class='list-group-item list-group-item-warning itemOrder'>".$id_product['quantity']."x ".$product['name']."</li>";
    }

?>
                </ul>'
            <br>
            <button type="button" class="btn btn-primary validationOrder" onclick="changeState('<?php echo $id_order['id']; ?>')">Valider</button>
            </div>
        </div>
<?php
}
?>
<script>

    function changeState(id){
        $.ajax({
            type: 'POST',
            url: "templates/kitchenInterface/changeState.php",
            data : 'id=' + id,
            success: function(data){
                console.log(data);
            }
        })
    }
</script>