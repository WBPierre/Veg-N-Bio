<?php

require_once "../config/config.php";



print_r($_FILES['coverPicture']);

foreach($_FILES as $fichier)
{

    $dossier =$_SERVER['DOCUMENT_ROOT'];
    $fich=$fichier['name'];

    if(move_uploaded_file($fichier['tmp_name'],$dossier . $fich))
    {
        echo 'Upload effectué avec succès pour le fichier '.$fichier['name'] . "<br/>";
    }
    else
    {
        echo '<font color="red">Echec de l\'upload pour le fichier <f/ont>'.$fichier['name']. "<br/><br/>";
    }
}

