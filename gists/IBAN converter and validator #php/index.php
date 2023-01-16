<?php
function iban_test($iban) {
    $iban = str_replace( ' ', '', $iban );
    $iban1 = substr( $iban,4 ).strval( ord( $iban{0} )-55 ).strval( ord( $iban{1} )-55 ).substr( $iban, 2, 2 );
    for( $i = 0; $i < strlen($iban1); $i++) {
      if(ord( $iban1{$i} )>64 && ord( $iban1{$i} )<91) {
        $iban1 = substr($iban1,0,$i) . strval( ord( $iban1{$i} )-55 ) . substr($iban1,$i+1);
      }
    }
    $rest=0;
    for ( $pos=0; $pos<strlen($iban1); $pos+=7 ) {
        $part = strval($rest) . substr($iban1,$pos,7);
        $rest = intval($part) % 97;
    }
    $pz = sprintf("%02d", 98-$rest);
    if ( substr($iban,2,2)=='00') { return substr_replace( $iban, $pz, 2, 2 ); }
    else { return ($rest==1) ? true : false; }
}

function iban_create($kto, $blz) {
  $blz8 = str_pad( $blz, 8, "0", STR_PAD_RIGHT);
  $kontonr10 = str_pad ( $kto, 10, "0", STR_PAD_LEFT);
  $bban = $blz8 . $kontonr10;
  $pruefsumme = $bban . "131400";
  $modulo = (bcmod($pruefsumme,"97"));
  $pruefziffer = str_pad( 98 - $modulo, 2, "0",STR_PAD_LEFT);
  $iban = "DE" . $pruefziffer . $bban;
  return $iban;
}
