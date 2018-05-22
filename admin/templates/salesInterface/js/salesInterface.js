<script>
$(document).ready(function(){

    var counter = 0;

    var myCart = {
        drink: {
            carrotJuice: 0,
            appleJuice: 0,
            orangeJuice: 0,
        }
    }

    $('.choseItem').click(function(){

        $('#itemModal').modal('show');
        console.log('test');

    });

    $('.selectProduct').click(function() {

    });
});
</script>