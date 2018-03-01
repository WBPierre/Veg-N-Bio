new WOW().init();

$(document).ready(function() {



    // Init GridStack

    $(function () {
        $('.grid-stack')
            .gridstack()
            .on('dragstart', function(event, ui) {
                var grid = this;
                var element = event.target;
                console.log('test')
            });
    });

    // Init MDB library

    $('.mdb-select').material_select();

    // Init Fading MDB

    $(function () {
        var selectedClass = "";
        $(".filter").click(function () {
            selectedClass = $(this).attr("data-rel");
            $("#gallery").fadeTo(100, 0.1);
            $("#gallery div").not("." + selectedClass).fadeOut().removeClass('animation');
            setTimeout(function () {
                $("." + selectedClass).fadeIn().addClass('animation');
                $("#gallery").fadeTo(300, 1);
            }, 300);
        });
    });


    // Init Google Map

    var map;

    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.849145, lng: 2.389659},
        zoom: 15
    });

    var infoWindow = new google.maps.InfoWindow({map: map});

    // Try HTML5 geolocation.

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);

            var marker = new google.maps.Marker({
                position: pos,
                map: map
            });
        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    var state = 'img';

    $('.adminEdition').hover(function() {
        $(this).css({
            'transform': 'scale(1.1)',
            'cursor': 'pointer'
        });
        $(this).attr({
            'data-toggle': 'tooltip',
            'title': 'Click to modify',
            'data-placement': 'top'

        });
        $(this).tooltip('show')
    },
        function (){
            $(this).css("transform","scale(1)");
    });



    $('.adminEdition').click(function () {

        if (this.tagName === 'IMG') {

            state = 'img';

            var img = new Image();
            img = this;

            $("#editionPicture").attr({
                'hidden': false,
                'src': img.src
            });
            $("#editionText").attr('hidden', true);
            $("#showText").attr('hidden', true);
            $("#file-field").attr('hidden', false);
        } else {

            state = 'texte';

            var txt = new Text();
            txt = this;

            console.log(txt);

            $("#showText").text(txt.innerHTML).attr('hidden', false);
            $("#editionText").text($("#showText").text()).attr('hidden', false);
            $("#editionPicture").attr('hidden', true);
            $("#file-field").attr('hidden', true);

        }

        $('#fullHeightModalRight').modal('show');

        var splitFile;
        var file;

        if (state === 'img') {

            $.ajax({
                url: '../../src/ImageController.php', // Le nom du script a changé, c'est send_mail.php maintenant !
                type: 'GET', // Le type de la requête HTTP, ici devenu POST
                data: 'src=' + img.src,
            });
            $("#inputFile").change(function () {
                splitFile = $("#inputFile").val().split('\\');
                file = splitFile[2].split('.');
                $("#editionPicture").attr('src', '../assets/images/' + splitFile[2]);
            });

            $('#saveValidFile').click(function () {
                $(img).attr('src', '../assets/images/' + splitFile[2]);
                $('#fullHeightModalRight').modal('hide');

                img = new Image();
            });
        }
        else {

            $("#editionText").keyup(function () {
                $("#showText").text($("#editionText").val());
            });

            $('#saveValidFile').click(function () {

                $(txt).text($("#showText").html());
                $('#fullHeightModalRight').modal('hide');

                txt = new Text();
            });
        }

    });
});
