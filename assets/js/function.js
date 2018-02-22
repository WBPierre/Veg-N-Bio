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

    $('.adminEdition').click(function () {

        console.log(this);

        if(this.tagName === 'IMG') {
            state = 'img';
            $("#editionPicture").prop('hidden', false).attr('src', this.src);
            $("#editionText").prop('hidden', true);
        } else {
            state = 'text';
            $("#editionText").text(this.innerHTML).prop('hidden', false);
            $("#editionPicture").prop('hidden', true);
        }

        $('#fullHeightModalRight').modal('show');

        var splitFile;
        var file;

        if(state = 'img'){
            $('#validFile').click(function () {

                splitFile = $("#inputFile").val().split('\\');
                file = splitFile[2].split('.');

                $("#editionPicture").attr('src', '../assets/images/' + splitFile[2]);

            });
            $('#saveValidFile').click(function () {
                $('.adminEdition').attr('src', '../assets/images/' + splitFile[2]);
                $('#fullHeightModalRight').modal('hide');
            });
        };


    });
});
    /*

        $('#fullHeightModalRight').modal('show')
        if ($('#validFile').click(function () {

                var file = document.getElementById('inputFile').value
                var nameFile = file.split("\\");
                var splitFile = nameFile[2].split('.');

                if ((file).length > 1) {
                    console.log(splitFile[1].toLowerCase());
                    if (splitFile[1].toLowerCase() === 'jpg') {
                        console.log('Le fichier est bon');
                        console.log(file);
                        $("#imageEdition").attr('src', '../assets/images/' + nameFile[2]);
                    }
                } else {
                    console.log("Le fichier n'est pas bon");
                }
            })) ;
        if ($('#saveValidFile').click(function () {
                $("#imageEdition").attr('src', '../assets/images/' + nameFile[2]);
            })) ;

    });

    */

