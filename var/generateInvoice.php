<?php

require_once "pdf/PDF.php";
require_once "../config/config.php";

$data = OrderController::getOrderDetail();
$pdf = new PDF( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete( "Veg'N'Bio",
    "242 Rue du Faubourg Saint-Antoine\n" .
    "75012 Paris\n".
    "R.C.S. PARIS B 000 000 007\n" .
    "Capital : 180 000 " . EURO );
$pdf->addDate( $data['0']['date_inserted']);
$cols=array( "REFERENCE"    => 23,
    "DESIGNATION"  => 78,
    "QUANTITE"     => 22,
    "MONTANT T.T.C." => 30);
$pdf->addCols( $cols);

$cols=array( "REFERENCE"    => "L",
    "DESIGNATION"  => "L",
    "QUANTITE"     => "C",
    "MONTANT T.T.C." => "R");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

$y    = 109;
foreach($data['menu'] as $key=>$value){
    $product = "";
    foreach($value['product'] as $keyProd=>$valueProd){
        $product.= " - ".$valueProd['name']."\n";
    }
    $line = array( "REFERENCE"    => $data['0']['id'],
        "DESIGNATION"  => 'Menu '.$value['info']['name']."\n" .
            $product,
        "QUANTITE"     => $value['info']['quantity'],
        "MONTANT T.T.C." => $value['info']['price']." euros");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
}

foreach($data['product'] as $key=>$value){
    $line = array( "REFERENCE"    => $data['0']['id'],
        "DESIGNATION"  => $value['name'],
        "QUANTITE"     => "1",
        "MONTANT T.T.C." => $value['price']." euros");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
}

$tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ));

$pdf->addTVAs( $data['0']['total'],$tot_prods);
$pdf->addCadreEurosFrancs();
$pdf->Output("I","invoiceVegNBio.pdf",true);