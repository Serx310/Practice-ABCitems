<?php
    require_once 'settings.php';
    require_once 'funcont.php';
    require_once 'database.php';
    include("./MPDF/mpdf.php");

  $logoimage =  'pics/kare_logo.png';             //'pics/img_0_0_3.jpg'; 
  $sFirma = "ABCLED OÜ";
  $sBank = "Swedbank, IBAN &nbsp;EE072200221054142803";
  $sPayTerm = "Makseaeg: " ;
  $sPayTerm = "Makseaeg: ";
  $sFtelefon = "+372 58 28 8084";

  $sFbank1 =  "Pank: SWEDBANK";
  $sFbank2 =  "EE072200221054142803";
  $sFbank3 =  "SWIFT/BIC: HABAEE2X";

  $sFadress = "Hellerheina tee 27, Maardu 74117";

  $sFemail ="abcled24@gmail.com";

  $sFreg = "Reg. nr 11147156 &nbsp;KMKR nr.EE101738077";

  $sFwww = "www.abcled.ee";
  
  
   
        
         if (  (isset ($_REQUEST['docid'])) && ( strlen($_REQUEST['docid'])>0 )    )
         {
             $my_set = new Obstock_Settings();
             
              require_once( './lang/lang'.$my_set->lang.'.php' );
    
              $myLang = new OBLang();
    
             $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );
             
              $aDocDetails = $my_db->GetDocuments ( -1, $_REQUEST['docid'] );
              
              $aDocRowsDetails = $my_db->GetDocumentRows ( $_REQUEST['docid'] );
      
              if ( $aDocRowsDetails['count'] > 0 ) $isHeadReadOnly = 1;
              
              
               $sOutHtlm = '<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
  </style>
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000">

<table style="width: 645px; border-collapse: collapse" cellpadding="0" cellspacing="0" border="1" bgcolor="white">
<tr>
  <td><img alt="" src="pics/px" style="width: 80px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 3px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 2px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 8px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 10px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 19px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 5px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 77px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 32px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 6px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 44px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 11px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 20px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 8px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 3px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 4px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 6px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 9px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 15px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 10px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 27px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 2px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 8px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 24px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 5px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 3px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 3px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 23px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 2px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 6px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 6px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 53px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 2px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 4px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 2px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 1px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 3px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 58px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 30px;"/></td>
</tr>
<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 11px;"/></td>
  <td colspan="10" rowspan="5"><img src="'.$logoimage.'" style="width: 161px" alt=""/></td>
  <td colspan="42"><img alt="" src="pics/px" style="width: 400px; height: 11px;"/></td>
</tr>';




 $sOutHtlm .= '<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 18px;"/></td>
  <td colspan="15"><img alt="" src="pics/px" style="width: 138px; height: 18px;"/></td>
  <td colspan="21" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.GetDocTypeName( $aDocDetails[0]['DOCTYPE'] ).' nr.: '.utf8_encode( $aDocDetails[0]['DOCNUMBER'] ).'</span></p></td>
  <td colspan="6"><img alt="" src="pics/px" style="width: 66px; height: 18px;"/></td>
   </tr>';


   if ( isset ( $aDocDetails[0]['DOCDATE'] ) )  $docdate = MyDate2($aDocDetails[0]['DOCDATE']);
   else   $docdate = MyDate2($aDocDetails[0]['REGDATE']) ;
   
  
  $sOutHtlm .= '<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 3px;"/></td>
  <td colspan="42"><img alt="" src="pics/px" style="width: 400px; height: 3px;"/></td>
</tr>
<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 18px;"/></td>
  <td colspan="15"><img alt="" src="pics/px" style="width: 138px; height: 18px;"/></td>
  <td colspan="21" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Arve kuupäev: '.$docdate.'</span></p></td>
  <td colspan="6"><img alt="" src="pics/px" style="width: 66px; height: 18px;"/></td>
</tr>';

$sOutHtlm .= '<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 16px;"/></td>
  <td colspan="42"><img alt="" src="pics/px" style="width: 400px; height: 16px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 1px;"/></td>
</tr> ';


    $sOutHtlm .= '<tr valign="top">
  <td><img alt="" src="pics/px" style="width: 30px; height: 12px;"/></td>
  <td colspan="7" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Tellija:</span></p></td>
  <td><img alt="" src="pics/px" style="width: 5px; height: 12px;"/></td>
  <td colspan="18"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.utf8_encode ( $aDocDetails[0]['CUSTNAME'] ).'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 11px; height: 12px;"/></td>
  <td colspan="20" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Selgitus: Arve '.utf8_encode( $aDocDetails[0]['DOCNUMBER'] ).'</span></p></td>
  <td colspan="6"><img alt="" src="pics/px" style="width: 66px; height: 12px;"/></td>
   </tr>';

   $sOutHtlm .= '<tr valign="top">
  <td colspan="9"><img alt="" src="pics/px" style="width: 79px; height: 12px;"/></td>
  <td colspan="18"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.utf8_encode ($aDocDetails[0]['ADDRESS']).'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 11px; height: 12px;"/></td>
  <td colspan="19" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Makse saaja: '.$sFirma.'</span></p></td>
  <td colspan="7"><img alt="" src="pics/px" style="width: 67px; height: 12px;"/></td>
  </tr>';

  $sOutHtlm .= '<tr valign="top">
  <td colspan="9"><img alt="" src="pics/px" style="width: 79px; height: 12px;"/></td>
  <td colspan="18"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.utf8_encode ($aDocDetails[0]['ADDRESS2']).'</span></p></td>
  <td colspan="21" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBank.'</span></p></td>
  <td colspan="7"><img alt="" src="pics/px" style="width: 67px; height: 12px;"/></td>
  </tr>';

  $sOutHtlm .= '<tr valign="top">
  <td><img alt="" src="pics/px" style="width: 30px; height: 12px;"/></td>
  <td colspan="7" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Reg.nr.</span></p></td>
  <td><img alt="" src="pics/px" style="width: 5px; height: 12px;"/></td>
  <td colspan="2" rowspan="2"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.utf8_encode ($aDocDetails[0]['TAXID']).'</span></p></td>
  <td colspan="17"><img alt="" src="pics/px" style="width: 145px; height: 12px;"/></td>
  <td colspan="21" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sPayTerm.'</span></p></td>
  <td colspan="6"><img alt="" src="pics/px" style="width: 66px; height: 12px;"/></td>
  </tr>';
  
  $sOutHtlm .= '<tr valign="top">
  <td colspan="9"><img alt="" src="pics/px" style="width: 79px; height: 1px;"/></td>
  <td colspan="44"><img alt="" src="pics/px" style="width: 407px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 10px;"/></td>
</tr>
<tr valign="top">
  <td><img alt="" src="pics/px" style="width: 30px; height: 13px;"/></td>
  <td colspan="47"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><img alt="" src="pics/px" border="0"/></p></td>
  <td colspan="7"><img alt="" src="pics/px" style="width: 67px; height: 13px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 3px;"/></td>
</tr>
<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 1px;"/></td>
  <td colspan="50" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 61px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 3px;"/></td>
</tr>
<tr valign="top">
  <td colspan="7"><img alt="" src="pics/px" style="width: 55px; height: 14px;"/></td>
  <td colspan="5"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kauba nimetus</span></p></td>
  <td colspan="18"><img alt="" src="pics/px" style="width: 181px; height: 14px;"/></td>
  <td colspan="4" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Hind</span></p></td>
  <td colspan="4"><img alt="" src="pics/px" style="width: 10px; height: 14px;"/></td>
  <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kogus</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 12px; height: 14px;"/></td>
  <td colspan="3" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Summa</span></p></td>
  <td colspan="7"><img alt="" src="pics/px" style="width: 67px; height: 14px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 3px;"/></td>
</tr>
<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 1px;"/></td>
  <td colspan="50" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 61px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 2px;"/></td>
</tr>';


    $iRowsHeight = 0; 
      
      for ( $i = 0; $i < $aDocRowsDetails['count'];  $i++ )
      {
             
        $sOutHtlm .= '<tr valign="top">
         <td colspan="6"><img alt="" src="pics/px" style="width: 45px; height: 13px;"/></td>
         <td colspan="25"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.utf8_encode ( $aDocRowsDetails[$i]['NAME'] ).'</span></p></td>
         <td colspan="6" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocRowsDetails[$i]['DOCPRICE'] ).'</span></p></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: 6px; height: 13px;"/></td>
         <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocRowsDetails[$i]['UNITS'] ).'</span></p></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: 8px; height: 13px;"/></td>
         <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $aDocRowsDetails[$i]['UNITS'] * $aDocRowsDetails[$i]['DOCPRICE'] ) ).'</span></p></td>
         <td colspan="8"><img alt="" src="pics/px" style="width: 71px; height: 13px;"/></td>
         </tr>
         <tr valign="top">
           <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 3px;"/></td>
        </tr>';
         
         $iRowsHeight = $iRowsHeight +16 ;          
       }

       $sOutHtlm .= '<tr valign="top">
                     <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 2px;"/></td>
</tr>
<tr valign="top">
  <td colspan="5"><img alt="" src="pics/px" style="width: 37px; height: 1px;"/></td>
  <td colspan="49" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
  <td><img alt="" src="pics/px" style="width: 58px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 8px;"/></td>
</tr>
<tr valign="top">
  <td colspan="27"><img alt="" src="pics/px" style="width: 332px; height: 1px;"/></td>
  <td colspan="13" rowspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Kokku käibemaksuta:</span></p></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 1px;"/></td>
  <td colspan="5" rowspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocDetails[0]['NETAMOUNT'] ).'</span></p></td>
  <td colspan="9"><img alt="" src="pics/px" style="width: 73px; height: 1px;"/></td>
</tr> ';
        
       $sOutHtlm .= '<tr valign="top">
  <td colspan="5"><img alt="" src="pics/px" style="width: 37px; height: 17px;"/></td>
  <td colspan="21"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Arve koostas</span></p></td>
  <td><img alt="" src="pics/px" style="width: 15px; height: 17px;"/></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 17px;"/></td>
  <td colspan="9"><img alt="" src="pics/px" style="width: 73px; height: 17px;"/></td>
</tr>
<tr valign="top">
  <td colspan="27"><img alt="" src="pics/px" style="width: 332px; height: 1px;"/></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 1px;"/></td>
  <td colspan="9"><img alt="" src="pics/px" style="width: 73px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="28"><img alt="" src="pics/px" style="width: 333px; height: 19px;"/></td>
  <td colspan="12" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Käibemaks 20%:</span></p></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 19px;"/></td>
  <td colspan="5" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $aDocDetails[0]['DOCAMOUNT'] - $aDocDetails[0]['NETAMOUNT'] ) ).'</span></p></td>
  <td colspan="9"><img alt="" src="pics/px" style="width: 73px; height: 19px;"/></td>
</tr>'; 
        
        
    $sOutHtlm .= '<tr valign="top">
  <td colspan="27"><img alt="" src="pics/px" style="width: 333px; height: 19px;"/></td>
  <td colspan="13" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Summa kokku:</span></p></td>
  <td><img alt="" src="pics/px" style="width: 7px; height: 19px;"/></td>
  <td colspan="5" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocDetails[0]['DOCAMOUNT']  ).'</span></p></td>
  <td colspan="9"><img alt="" src="pics/px" style="width: 73px; height: 19px;"/></td>
</tr>
<tr valign="top">
  <td colspan="19"><img alt="" src="pics/px" style="width: 285px; height: 1px;"/></td>
  <td colspan="35" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
  <td><img alt="" src="pics/px" style="width: 58px; height: 1px;"/></td>
</tr> '; 
        
     $sOutHtlm .= '<tr valign="top">
  <td colspan="6"><img alt="" src="pics/px" style="width: 45px; height: 14px;"/></td>
  <td colspan="13"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">Võttis vastu.</span></p></td>
  <td colspan="36"><img alt="" src="pics/px" style="width: 310px; height: 14px;"/></td>
</tr>';   

/// height 133 

  $sOutHtlm .= '<tr valign="top"><td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: '.(650 - $iRowsHeight ).'px;"/></td></tr>';
        
      
 $sOutHtlm .= '<tr valign="top">
  <td colspan="2"><img alt="" src="pics/px" style="width: 33px; height: 1px;"/></td>
  <td colspan="50" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
  <td colspan="3"><img alt="" src="pics/px" style="width: 62px; height: 1px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 4px;"/></td>
</tr>
<tr valign="top">
  <td colspan="4"><img alt="" src="pics/px" style="width: 35px; height: 12px;"/></td>
  <td colspan="6"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFirma.'</span></p></td>
  <td colspan="7"><img alt="" src="pics/px" style="width: 98px; height: 12px;"/></td>
  <td colspan="6" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">Telefon</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 7px; height: 12px;"/></td>
  <td colspan="8"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFtelefon.'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 6px; height: 12px;"/></td>
  <td colspan="15" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFbank1.'</span></p></td>
  <td colspan="5"><img alt="" src="pics/px" style="width: 65px; height: 12px;"/></td>
</tr>
<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: 34px; height: 12px;"/></td>
  <td colspan="9"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFadress.'</span></p></td>
  <td colspan="3"><img alt="" src="pics/px" style="width: 57px; height: 12px;"/></td>
  <td colspan="5" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">e-mail:</span></p></td>
  <td><img alt="" src="pics/px" style="width: 3px; height: 12px;"/></td>
  <td colspan="15"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFemail.'</span></p></td>
  <td colspan="15" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFbank2.'</span></p></td>
  <td colspan="4"><img alt="" src="pics/px" style="width: 64px; height: 12px;"/></td>
</tr>
<tr valign="top">
  <td colspan="4"><img alt="" src="pics/px" style="width: 35px; height: 12px;"/></td>
  <td colspan="10"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFreg.'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 14px; height: 12px;"/></td>
  <td colspan="6" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">web:</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: 7px; height: 12px;"/></td>
  <td colspan="8"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFwww.'</span></p></td>
  <td colspan="4"><img alt="" src="pics/px" style="width: 31px; height: 12px;"/></td>
  <td colspan="15" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sFbank3.'</span></p></td>
  <td colspan="4"><img alt="" src="pics/px" style="width: 64px; height: 12px;"/></td>
</tr>
<tr valign="top">
  <td colspan="55"><img alt="" src="pics/px" style="width: 595px; height: 22px;"/></td>
</tr>
</table>


</body>
</html>';
   
   echo $sOutHtlm ;  }
   
//////////////////////////////////////   
//  pdf gen
//  echo $sOutHtlm ;  }

///////////////////////   
 /*    
        $mpdf=new mPDF(); 

       $mpdf->WriteHTML($sOutHtlm);

       $mpdf->Output('./tmp/arve'.$aDocDetails[0]['DOCNUMBER'].'.pdf' , 'F');

 
//$mpdf->Output();

            $arr = array('id' => 0, 'mes' =>  $myLang->pdfrdy.' '.$aDocDetails[0]['DOCNUMBER'].'.pdf !'   );   
            
             $my_db->close();
             
        }
        else
        {
           
                  
           $arr = array('id' => 1, 'mes' => 'Vale id '.$_REQUEST['docid']  );   
      
        }
        
        echo json_encode($arr);
   */     
   
   
?>