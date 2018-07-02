<script>
$('.datepicker').pickadate({
{% if lang == 'fr' %}
monthsFull: ['Janvier', 'Févirer', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthsShort: ['Jan', 'Fév', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
    weekdaysFull: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    today: 'Aujourd\'hui',
    clear: 'Reset',
    close: 'Fermer',
    labelMonthNext: 'Mois suivant',
    labelMonthPrev: 'Mois précédent',
    labelMonthSelect: 'Sélectionnez un mois',
    labelYearSelect: 'Sélectionnez une année',
{% endif %}
format: 'yyyy-mm-dd'
});
$(document).ready(function(){
    var user;
    $('.checkThisEmployee').on('click',function(){
        user = $(this).val();
    });
    $('#modifyUser').on('click',function(){
        $('#'+user).modal('show');
    });
    $('#deleteUser').on('click',function(){
        $('#delete_'+user).modal('show');
    });
});
</script>