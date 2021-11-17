<?php

  $SERVER_IP = '192.168.0.29';
$SERVER_PORT = '9100';


//$SERVER_IP = '213.100.251.37';
//$SERVER_PORT = '9010';




if(isset($_GET['code'])){
    $code = $_GET['code'];
} else {
    $code = '';
}
if(isset($_GET['name'])){
    $name = $_GET['name'];
} else {
    $name = '';
}

if(isset($_GET['price'])){
    $price = $_GET['price'];
} else {
    $price = '';
}

if(isset($_GET['place'])){
    $place = $_GET['place'];
} else {
    $place = '';
}

if(isset($_GET['qty'])){
    $qty = $_GET['qty'];
} else {
    $qty = '1';
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



// template XPrinter    TSC   lable printer program langu

    $EPL[0] = 'SIZE 60 mm, 40 mm';
    $EPL[1] = 'GAP 2 mm, 0 mm';
    $EPL[2] = 'COUNTRY 046';
    $EPL[3] = 'CODEPAGE 865';
    $EPL[4] = 'SPEED 3';
    $EPL[5] = 'DENSITY 5';
    $EPL[6] = 'SET PEEL OFF';
    $EPL[7] = 'DIRECTION 0';
    $EPL[8] = 'REFERENCE 30,10';
    $EPL[9] = 'OFFSET 0 mm';
    $EPL[10] = 'SHIFT 0';
    $EPL[11] = 'CLS';

    $EPL[12] = 'TEXT 70,20,"4",0,1,1,"'.$code.'"';
    $EPL[13] = 'TEXT 200,20,"3",0,1,1,"'.$place.'"';
    $EPL[14] = 'A$="'.$name.'"';

    if ( strlen ($name ) > 26  )
    {
        $EPL[15] = 'B=LEN(A$)';
        $EPL[16] = 'C1$=LEFT$(A$,26)+"-"';
        $EPL[17] = 'C2$=MID$(A$,27,(B-26))';
    }
    else
    {
        $EPL[15] = 'C1$=A$';
        $EPL[16] = 'C2$=" "';
        $EPL[17] = 'C2$=" "';
    }

        $EPL[18] = 'TEXT 10,70,"3",0,1,1,C1$';
        $EPL[19] = 'TEXT 10,100,"3",0,1,1,C2$';
        $EPL[20] = 'TEXT 70,150,"4",0,1,1,"Kogus: '.$qty.'"';
      	$EPL[21] = 'TEXT 170,200,"3",0,1,1,"www.abcled.ee"';
        $EPL[22] = 'BAR 10,230,440,2';


        if ( strlen($sPakkumine) > 0 )
        {
            $EPL[23] = 'TEXT 10,250,"3",0,1,1,"Pakkumine: '.$sPakkumine.'"';
        }
        else if ( strlen($sArveNr) > 0 )
        {
          $EPL[23] = 'TEXT 10,250,"3",0,1,1,"Pakkumine: '.$sPakkumine.'"';
        }
        else if ( strlen($sBufName ) > 0 )
        {
           $EPL[23] = 'TEXT 10,250,"3",0,1,1,"Buf: '.$sBufName.'"';
        }
        else
        {
              $EPL[23] = 'TEXT 10,250,"3",0,1,1," "';
        }

       if ( strlen($sCustName) > 0 )
       {
          $EPL[24] = 'TEXT 10,279,"3",0,1,1,"Klient: '.$sCustName.'"';
       }
       else
       {
          $EPL[24] = 'TEXT 10,279,"3",0,1,1," "';
       }




    $EPL[25] = 'PRINT 1';
    $EPL[26] = 'BEEP';
    $EPL[27] = 'BEEP';
    $EPL[28] = 'BEEP';
    $EPL[29] = 'BEEP';
    $EPL[30] = 'BEEP';


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

     for ( $i = 0; $i < 26; $i ++)
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
