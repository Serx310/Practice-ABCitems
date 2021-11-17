<?php



function MyDate($str) {

  if (strlen($str) == 0)
  {
    return $str;
  }

  $sArray = explode(" ", $str);
  $dateArray = explode("-", $sArray[0]);

  $year = $dateArray[0];
	$month = $dateArray[1];
  $day = $dateArray[2];

  return $day.".".$month.".".$year." ".$sArray[1];
}

function MyDate2($str) {

  if (strlen($str) == 0)
  {
    return $str;
  }

  $sArray = explode(" ", $str);
  $dateArray = explode("-", $sArray[0]);

  $year = $dateArray[0];
	$month = $dateArray[1];
  $day = $dateArray[2];

  return $day.".".$month.".".$year;
}

 function MySqlDate($str) {


  $dateArray = explode(".", $str );

  $day = $dateArray[0];
	$month = $dateArray[1];
  $year= $dateArray[2];

  return "'".$year."-".$month."-".$day."'";

}


  function MyPriceNZ ($str, $idec=2 ) {

  if (strlen($str) == 0)
  {
    return $str;
  }

  if ( $str == 0 ) return '&nbsp;';

  if(strstr($str, ".")) {
   $str = str_replace(",", " ", $str); // replace dots (thousand seps) with blancs
   $str = str_replace(".", ",", $str); // replace ',' with '.'
   $str= $str."000000";

  }
  else if (strstr($str, ","))
  {
    $str= $str."000000";
  }
  else
  {
     $str = $str.",000000";
  }


  $iLen = strlen($str);
  $iPos = strpos($str, ",");

  if ( $iLen > $iPos + 3) {

      if ( $idec > 0) return substr($str, 0, $iPos + 1+ $idec );
      else  return substr($str, 0, $iPos  );

  }
  else return $str;
}


function MyHind($str, $idec=2 ) {

  if (strlen($str) == 0)
  {
    return $str;
  }

  if(strstr($str, ".")) {
   $str = str_replace(",", " ", $str); // replace dots (thousand seps) with blancs
   $str = str_replace(".", ",", $str); // replace ',' with '.'
   $str= $str."000000";

  }
  else if (strstr($str, ","))
  {
    $str= $str."000000";
  }
  else
  {
     $str = $str.",000000";
  }


  $iLen = strlen($str);
  $iPos = strpos($str, ",");

  if ( $iLen > $iPos + 3) {

      if ( $idec > 0) return substr($str, 0, $iPos + 1+ $idec );
      else  return substr($str, 0, $iPos  );

  }
  else return $str;
}


function MyDiscount($str) {
  if(strstr($str, ".")) {
   $str = str_replace(",", " ", $str); // replace dots (thousand seps) with blancs
   $str = str_replace(".", ",", $str); // replace ',' with '.'
  }

  $iLen = strlen($str);
  $iPos = strpos($str, ",");

  if ( $iLen > $iPos + 5) {

    return substr($str, 0, $iPos + 5 );

  }
  else return $str;
}


function  GetDocTypeName ($type){

 switch ($type){
 case 0: $sName="Arve"; break;
 case 1: $sName="Saateleht"; break;
 case 2: $sName="Sularaha"; break;
 case 3: $sName="Sisemine"; break;
 case 10: $sName="Arve"; break;
 case 11: $sName="Saateleht"; break;
 case 12: $sName="Sularaha"; break;
 case 13: $sName="Sisemine"; break;
 case 14: $sName="Kreedit"; break;
 case 20: $sName="Sisemine"; break;
 case 30: $sName="Telllimus"; break;
 case 40: $sName="Pakkumine"; break;
 case 41: $sName="Tellimus"; break;

 default: $sName="Sularaha";

 }

 return $sName;
}

function  GetDocTypeNameForFile ($type){

 switch ($type){
 case 0: $sName="arve"; break;
 case 1: $sName="saateleht"; break;
 case 2: $sName="sularaha"; break;
 case 3: $sName="sisemine"; break;
 case 10: $sName="arve"; break;
 case 11: $sName="saateleht"; break;
 case 12: $sName="sularaha"; break;
 case 13: $sName="sisemine"; break;
 case 14: $sName="kreedit"; break;
 case 20: $sName="sisemine"; break;
 case 30: $sName="telllimus"; break;
 case 40: $sName="pakkumine"; break;
 case 41: $sName="tellimus"; break;

 default: $sName="sularaha";

 }

 return $sName;
}


function  GetPaymentName ($payment)
{

   $sName = 'Sularaha';

   if ($payment == 'cash' )  $sName = 'Sularaha';
   else if ($payment == 'magcard' )  $sName = 'Maksekaart';
   else if ($payment == 'cheque' )  $sName = 'Ülekanne';
   else if ($payment == 'free' )  $sName = 'Tasuta';
   else if ($payment == 'paperin' )  $sName = 'Kinkekaart';
   else if ($payment == 'debt' )  $sName = 'Võlg';
   else if ($payment == 'cashin' )  $sName = 'Sissemaks';
   else if ($payment == 'cashout' )  $sName = 'Väljamaks';
   else if ($payment == 'magcardrefund' )  $sName = 'Maksekaart';
   else if ($payment == 'cashrefund' )  $sName =  'Sularaha';
   else $sName = $payment;

   return $sName;
}


function  MyReadFile ($fileName )
{
  $html = "";

  $handle = @fopen($fileName, "r");
  if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 1024);
        $html .=  $buffer;
    }
    fclose($handle);
}


return $html;

}

function  MyReadScriptFile ($fileName )
{
  $html = "";

  $handle = @fopen($fileName, "r");
  if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 1024);
        $html .=  $buffer;
    }
    fclose($handle);
   }

return $html;

}


 function  MyLabelBalticChars ($sIn )
 {
   /// $sOut = ($_GET['name']);

    $sOut = str_replace (  chr(245) , chr(147),  $sIn );
    $sOut = str_replace (  chr(246) , chr(148),  $sOut );
    $sOut = str_replace (  chr(228) , chr(132),  $sOut );
    $sOut = str_replace (  chr(252) , chr(129),  $sOut );

    $sOut = str_replace (  chr(213) , chr(147),  $sOut );
    $sOut = str_replace (  chr(220) , chr(154),  $sOut );
    $sOut = str_replace (  chr(196) , chr(142),  $sOut );
    $sOut = str_replace (  chr(214) , chr(153),  $sOut );

   return $sOut;

 }


 function getPrestoImageUrl ( $sServer, $sImgID )
 {
    // https://abcled.ee/img/p/1/0/10.jpg

    $sUrl = $sServer.'/img/p/';

    $iLen = strlen ($sImgID );

     for ( $i=0; $i < $iLen; $i++ )  $sUrl .= $sImgID[$i].'/';

     $sUrl .= $sImgID.'.jpg';

     return $sUrl;

 }


  function safeForFileName ( $sIn )
 	{
 		$sOut=$sIn;



 		$sOut = str_replace('>', '_',  $sOut );
 		$sOut = str_replace('<', '_',  $sOut );
 		$sOut = str_replace('|', '_',  $sOut );
 		$sOut = str_replace('?', '_',  $sOut );
 		$sOut = str_replace('*', '_',  $sOut );
 		$sOut = str_replace('/', '_',  $sOut );
 		$sOut = str_replace('\\', '_',  $sOut );
 		$sOut = str_replace(':', '_',  $sOut );
 		$sOut = str_replace('\"', '_',  $sOut );
    $sOut = str_replace('#', '_',  $sOut );

 	   return $sOut;
 	}



  function sonadega($summa) {


       $sonadega_p = "";

        $sona[0] = "";
        $sona[1] = "üks";
        $sona[2] = "kaks";
        $sona[3] = "kolm";
        $sona[4] = "neli";
        $sona[5] = "viis";
        $sona[6] = "kuus";
        $sona[7] = "seitse";
        $sona[8] = "kaheksa";
        $sona[9] = "üheksa";

        $x = $summa;
        $summa = str_replace(",",".",$summa);
        list($paber,$sendid) = explode(".", $summa);

        $summ = strrev($paber);

        $sendid = number_format(".".$sendid,2,".","");
        list($jama,$sendid) = explode(".", $sendid);

        if(isset($summ[0])){
         $sn = $summ[0];
         $sonadega[0] = $sona[$sn];
        }

        if(isset($summ[1])){
        $sn = $summ[1];
                if($summ[1] == 1 && $summ[0] == 0){
                $sonadega[1] = "kümme";
                $sonadega[0] = "";
                }else if($summ[1] == 1){
                $sonadega[1] = $sonadega[0]."teist";
                $sonadega[0] = "";
                }else if($summ[1] == 0){
                $sonadega[1] = "";
                }else{
                $sonadega[1] = $sona[$sn]."kümmend";
                }
        }

        if(isset($summ[2])){
        $sn = $summ[2];
                if($summ[2] == 0){
                $sonadega[2] = "";
                }else{
                $sonadega[2] = $sona[$sn]."sada";
                }
        }

        if(isset($summ[3])){
        $sn = $summ[3];
        $sonadega[3] = $sona[$sn];
        }

        if(isset($summ[4])){
        $sn = $summ[4];
                if($summ[4] == 1 && $summ[3] == 0){
                $sonadega[4] = "kümme tuhat";
                $sonadega[3] = "";
                }else if($summ[4] == 1){
                $sonadega[4] = $sonadega[3]."teist tuhat";
                $sonadega[3] = "";
                }else if($summ[4] == 0 && $summ[5] == 0){
                $sonadega[4] = "";
                }else if($summ[4] == 0){
                $sonadega[4] = " tuhat";
                }else{
                $sonadega[3] = $sonadega[3]." tuhat";
                $sonadega[4] = $sona[$sn]."kümmend";
                }
        }else if(isset($summ[3])){
        $sonadega[3] = $sonadega[3]." tuhat";
        }

        if(isset($summ[5])){
        $sn = $summ[5];
                if($summ[5] == 0){
                $sonadega[5] = "";
                }else{
                $sonadega[5] = $sona[$sn]."sada";
                }
        }

        if(isset($summ[6])){
        $sn = $summ[6];
        $sonadega[6] = $sona[$sn];
        }

        if(isset($summ[7])){
        $sn = $summ[7];
                if($summ[7] == 1 && $summ[6] == 0){
                $sonadega[7] = "kümme miljonit";
                $sonadega[6] = "";
                }else if($summ[4] == 1){
                $sonadega[7] = $sonadega[6]."teist miljonit";
                $sonadega[6] = "";
                }else if($summ[7] == 0 && $summ[8] == 0){
                $sonadega[7] = "";
                }else if($summ[7] == 0){
                $sonadega[7] = " tuhat";
                }else{
                $sonadega[6] = $sonadega[6]." miljonit";
                $sonadega[7] = $sona[$sn]."kümmend";
                }
        }else if(isset($summ[6])){
        $sonadega[6] = $sonadega[6].' miljonit';
        }

        if(isset($summ[8])){
        $sn = $summ[8];
        $sonadega[8] = $sona[$sn].'sada';
        }

        if(isset($summ[9])){
        $sn = $summ[9];
        $sonadega[9] = $sona[$sn].' miljard';
        }


        if($sendid == 0 or empty($sendid) or !isset($sendid)){
        $sendid = '00';
        }else if($sendid < 10){
        $sendid = strrev($sendid);
        $sendid = '0'.$sendid[0];
        }

        $son=0;
        while ($son <= 9){
                if(isset($sonadega[$son])){
                $sonadega_p = $sonadega[$son].' '.$sonadega_p;
                }
        $son++;
        }

        $sonadega_p = $sonadega_p." eurot ja $sendid senti";
        $sonadega_p = str_replace('  ', ' ', $sonadega_p);

        return ucfirst($sonadega_p);
}

?>
