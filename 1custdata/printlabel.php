<?php

    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../database.php';

//$SERVER_IP = '192.168.0.29';
//$SERVER_PORT = '9100';

$SERVER_IP = '213.100.251.37';
$SERVER_PORT = '9010';


    $my_set = new Obstock_Settings();
    $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );
    
    
  if(isset($_GET['code']))
  {
  
    $code = $_GET['code'];
    
   

  } else {
     $code = '';
  }
  
    $aItemsDetails = $my_db->GetItems ( $code  , 1 , "",  "", "0",  -1, 1 );
     $my_db->close(); 
  
if(isset($_GET['name'])){
    $name = utf8_decode($_GET['name']);
} else {
    if ( $aItemsDetails['count'] > 0 ) $name = $aItemsDetails[0]['NAME'];
     else  $name = '';
}

if(isset($_GET['price'])){
    $price = $_GET['price'];
} else {
    
    if ( $aItemsDetails['count'] > 0 ) $price = MyHind(  $aItemsDetails[0]['PRICESELL'] * ( 1 + $aItemsDetails[0]['RATE'] )  ) ;
    else  $price = '';
}

if(isset($_GET['place'])){
    $place = $_GET['place'];
} else {
    if ( $aItemsDetails['count'] > 0 ) $place = $aItemsDetails[0]['PLACE'];
    else $place = '';
}


if(isset($_GET['qty'])){
    $qty = $_GET['qty'];
} else {
    $qty = '1';
}


 if(isset($_GET['reff'])){
    $reff = $_GET['reff'];
} else {
     if ( $aItemsDetails['count'] > 0 ) $reff =  $aItemsDetails[0]['REFERENCE'];
     else $reff = '';
}

if(isset($_GET['offer'])){
    $sPakkumine = $_GET['offer'];
} else {
    $sPakkumine = '';
}

if(isset($_GET['docnr'])){
    $sArveNr = $_GET['docnr'];
} else {
    $sArveNr = '';
}

if(isset($_GET['buf'])){
    $sBufName = $_GET['buf'];
} else {
    $sBufName = '';
}

if(isset($_GET['cust'])){
    $sCustName = $_GET['cust'];
} else {
    $sCustName = '';
}

 $sDate =   date ("d.m.Y");

// template XPrinter    TSC   lable printer program langu

$name      = MyLabelBalticChars ( $name );
$place     = MyLabelBalticChars ( $place );
$sCustName = MyLabelBalticChars ( $sCustName );
$sBufName  = MyLabelBalticChars ( $sBufName );


    $EPL[0] = 'SIZE 60 mm, 38 mm';
    $EPL[1] = 'GAP 2 mm, 0 mm';
    $EPL[2] = 'COUNTRY 046';
    $EPL[3] = 'CODEPAGE 865';
    $EPL[4] = 'SPEED 5';
    $EPL[5] = 'DENSITY 7';
    $EPL[6] = 'SET PEEL OFF';

    $EPL[7] = 'DIRECTION 1';
    $EPL[8] = 'REFERENCE 0,0';
    $EPL[9] = 'OFFSET 0 mm';
    $EPL[10] = 'SHIFT 0';
    $EPL[11] = 'CLS';
     if (strlen($name) > 27 ) $EPL[12] = 'TEXT 10,15,"3",0,1,1,"'.substr ($name,0,27).'"';
     else    $EPL[12] = 'TEXT 10,15,"3",0,1,1,"'.$name.'"';

    if (strlen($name) > 27 )  $EPL[13] = 'TEXT 10,45,"3",0,1,1,"'.substr ($name, 27).'"';
    else   $EPL[13] = 'TEXT 10,45,"3",0,1,1,""';

    $EPL[14] = 'TEXT 10,90,"3",0,1,1,"Kogus: '.$qty.'"';
    $EPL[15] = 'TEXT 220,90,"3",0,1,1,"/'.$sCustName.'"';
   
   
    $EPL[16] = 'TEXT 10,130,"4",0,1,1,"'.$place.'"';
   
   
     if ( strlen($code) == 13 )   
     {
     
          $EPL[17] = 'BARCODE 10,190,"EAN13",45,1,0,3,3,"'.$code.'"';
          
          $EPL[18] = 'TEXT 30,247,"3",0,1,1,"'.$code.'"';
     }
     else
     {
        $EPL[17] = 'BARCODE 10,180,"128",55,1,0,4,4,"'.$code.'"';
        $EPL[18] = '';
    }

    $EPL[19] = 'TEXT 300,247,"3",0,1,1,"'.$reff.'"';
    $EPL[20] = 'TEXT 310,210,"2",0,1,1,"'. $sDate.'"';

    $EPL[21] = 'PRINT 1';
     
        $EPL[22] = 'BEEP';


 //   $EPL .= 'N'.'\n';
  //  $EPL .= 'Q320,16'.'\n';
 //   $EPL .= 'q464'.'\n';
 //   $EPL .= 'R220,10'.'\n';
 //   $EPL .= 'A10,5,0,4,1,1,N,"'. $name .'"'.'\n';
 //   $EPL .= 'B10,45,0,1,4,8,100,N,"'. $code .'"'.'\n';
 //   $EPL .= 'A10,170,0,3,3,3,N,"'.$id.'"'.'\n';

   // $EPL .= 'UG'.'\n';


/* variant 2 */

try {
    $fp = pfsockopen($SERVER_IP, $SERVER_PORT);

     for ( $i = 0; $i < 23; $i ++)
     {
       fputs($fp, $EPL[$i] );
       fputs($fp, pack ( 'H*', '0d' ) );
     }



    fclose($fp);
    echo 'Successfully Printed ' ;
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}







 // Bixolon an Zebra
// template EPL
//    $EPL = 'OD'.'\n';
//    $EPL .= 'N'.'\n';
  //  $EPL .= 'Q320,16'.'\n';
 //   $EPL .= 'q464'.'\n';
//    $EPL .= 'R220,10'.'\n';
//    $EPL .= 'A10,5,0,4,1,1,N,"'. $name .'"'.'\n';
//    $EPL .= 'B10,45,0,1,4,8,100,N,"'. $code .'"'.'\n';
//    $EPL .= 'A10,170,0,3,3,3,N,"'.$id.'"'.'\n';
//    $EPL .= 'P1'.'\n';
   // $EPL .= 'UG'.'\n';





?>
