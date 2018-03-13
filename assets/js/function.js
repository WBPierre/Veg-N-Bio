new WOW().init();

$(document).ready(function() {

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
        zoom: 12
    });

    var infoWindow = new google.maps.InfoWindow({map: map});

    // Try HTML5 geolocation.

    var positionMarker = {
        Nation: { lat: 48.84839399999999 , lng: 2.395909999999958},
        Bastille: { lat: 48.8530842 , lng: 2.369251599999984},
        Republique: { lat: 48.867503, lng: 2.3638109999999415},
        PlaceItalie: { lat:  48.830816, lng: 2.3553901000000224}
    };

    var counter = 1;
    var markers = [];

    for(var property in positionMarker){

        var marker = new google.maps.Marker({
            position: positionMarker[property],
            map: map,
            names: {
                name: positionMarker
            }
        });
        markers.push(marker);
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);

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

    $(".list-group-item-action").click(function(){


        var list = new Text();
        list = this;

        var splitNameList = list.id.split('-');

        for( i = 0; i < 4; i++) {
            console.log(markers[i].position.lat);

        }
    });


    $('p').addClass('adminEdition');
    $('img').addClass('adminEdition');

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
