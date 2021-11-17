<?php
    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../database.php';
    require_once  '../vendor/autoload.php';
    //include("../MPDF/mpdf.php");



       $sBotText[1] = 'ABCLED OÜ';
       $sBotText[2] = 'Telefon +372 58 28 8084';
       $sBotText[3] = 'Pank: Swedbank';

       $sBotText[4] = 'Hellerheina tee 27, Maardu 74117';
       $sBotText[5] = 'e-mail: abcled24@gmail.com';
       $sBotText[6] = 'IBAN: EE072200221054142803';

       $sBotText[7] = 'Reg. nr: 11147156';
       $sBotText[8] = 'E-pood: www.abcled.ee';
       $sBotText[9] = 'SWIFT/BIC: HABAEE2X';

       $sBotText[10] = 'KMKR nr.EE101738077';
       $sBotText[11] = '';
       $sBotText[12] = '';

       $sCommentText[1] = " ";
       $sCommentText[2] = " ";

        $logoimage =  'pics/img_0_0_3.jpg';  // images/tat.svg






         if (  (isset ($_REQUEST['docid'])) && ( strlen($_REQUEST['docid'])>0 )    )
         {
             $my_set = new Obstock_Settings();



              $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );
              $aDocDetails = $my_db->GetDocuments ( -1, $_REQUEST['docid'] );
              $aDocRowsDetails = $my_db->GetDocumentRows ( $_REQUEST['docid'] );


          $iSize = $aDocRowsDetails['count'];

           $iLKcount = 0;

           $iStartIndx = 0;
           $iStopIndx = 0;

          while ( $iSize > 0 )
          {
             $iLKcount ++;
             if ( $iSize > 40 )
             {  $aLKdata[$iLKcount]['items'] = 40;

                $iStartIndx = $iStopIndx;
                $aLKdata[$iLKcount]['start'] = $iStartIndx;
                $iStopIndx = $iStopIndx + 40;
                $aLKdata[$iLKcount]['stop'] = $iStopIndx;
             }
             else
             {
                $aLKdata[$iLKcount]['items'] = $iSize;
                $iStartIndx = $iStopIndx;
                $aLKdata[$iLKcount]['start'] = $iStartIndx;
                $iStopIndx = $iStopIndx + $iSize;
                $aLKdata[$iLKcount]['stop'] = $iStopIndx;
             }

              $iSize = $iSize - 40;

          }


               $sOutHtlm = '<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
  </style>
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000">';

 //$w = array(1,12,44   ,60,79,80,39,50,39,66,46,42,88,10,1);
   $w = array(1,12,45,45,90,60,15,39,50,19,50,60,60,60,10,1);   //
        //    0 1   2  3  4  5  6  7  8  9 10 11 12 13 14 15   000000      1 6
   $gw=0;
   for ($i=0; $i< 16; $i++  )  $gw=$gw + $w[$i];

 for ($z=1; $z<( $iLKcount + 1) ;$z++ )
  { /// begin page

$sOutHtlm .= '<table style="width: '.$gw.'px; border-collapse: collapse" cellpadding="0" cellspacing="0" border="0" bgcolor="white" ><tr>';


   for ($i=0; $i< 16; $i++  ) $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[$i].'px; height: 10px;"/></td>';



$sOutHtlm .= '</tr>
<tr valign="top">
  <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 8px;"/></td>
  <td colspan="14" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 8px;">Lk. '.$z.'/'.$iLKcount.'</span></p></td></td>
  <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 8px;"/></td>
</tr>
<tr valign="top">
  <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px; height: 11px;"/></td>
  <td colspan="3" rowspan="5 " style="padding-left: 20px;" ><img src="'.$logoimage.'" style="width: '.($w[2]+$w[3]+$w[4]-21).'px" alt=""/></td>
  <td colspan="11"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 11px;"/></td>
</tr>';




 $sOutHtlm .= '<tr valign="top">

   <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 18px;"/></td>

   <td colspan="4"><img alt="" src="pics/px" style="width: '.( $w[5]+$w[6]+$w[7]+$w[8]).'px; height: 18px;"/></td>

  <td colspan="5" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.GetDocTypeName( $aDocDetails[0]['DOCTYPE'] ).' nr.: '.( $aDocDetails[0]['DOCNUMBER'] ).'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14] + $w[15]).'px; height: 18px;"/></td>
   </tr>';


   if ( isset ( $aDocDetails[0]['DOCDATE'] ) )  $docdate = MyDate2($aDocDetails[0]['DOCDATE']);
   else   $docdate = MyDate2($aDocDetails[0]['REGDATE']) ;


   $sHtmlLine = '<tr valign="top">
      <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 1px;"/></td>
      <td colspan="13" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
      <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 1px;"/></td></tr>';


  $sOutHtlm .= '<tr valign="top">
   <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 3px;"/></td>
   <td colspan="11"><img alt="" src="pics/px" style="width: '.( $w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 3px;"/></td>
</tr>
  <tr valign="top">
    <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 18px;"/></td>
    <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]).'px; height: 18px;"/></td>
    <td colspan="6" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Arve kuupäev: '.$docdate.'</span></p></td>
    <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 18px;"/></td>
   </tr>';

$sOutHtlm .= '<tr valign="top">
  <tdcolspan="2" ><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 16px;"/></td>
  <td colspan="11"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 16px;"/></td>
</tr>
<tr valign="top">
  <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 1px;"/></td>
</tr> ';


  $sOutHtlm .= '<tr valign="top">
  <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
  <td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Tellija:&nbsp;</span></p></td>
  <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ( $aDocDetails[0]['CUSTNAME'] ).'</span></p></td>
  <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Selgitus: Arve '.( $aDocDetails[0]['DOCNUMBER'] ).'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
   </tr>';

   $sOutHtlm .= '<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
  <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($aDocDetails[0]['ADDRESS']).'</span></p></td>
  <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Makse saaja: '.$sBotText[1].'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
  </tr>';

  $sOutHtlm .= '<tr valign="top">
  <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
  <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($aDocDetails[0]['ADDRESS2']).'</span></p></td>
  <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">Swedbank, IBAN &nbsp;'.$sBotText[6].'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
  </tr>';

  $sOutHtlm .= '<tr valign="top">
  <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
  <td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Reg.nr.:&nbsp;</span></p></td>
  <td colspan="7" ><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($aDocDetails[0]['TAXID']).'</span></p></td>
  <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">Makseaeg: '.$aDocDetails[0]['DUEDAYS'].' päeva</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
  </tr>';

  $sOutHtlm .= '<tr valign="top">
     <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 11px;"/></td>
   </tr>';


   if ( strlen( $aDocDetails[0]['DCOMMENT']) > 0 ) $sOutHtlm .= '<tr valign="top">
      <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
      <td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Märkused:&nbsp;</span></p></td>
      <td colspan="12" ><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($aDocDetails[0]['DCOMMENT']).'</span></p></td>
      <td ><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 13px;"/></td>
    </tr>';

   else $sOutHtlm .= '<tr valign="top">
      <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
      <td colspan="14"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><img alt="" src="pics/px" border="0"/></p></td>
      <td ><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 13px;"/></td>
    </tr>';


    $sOutHtlm .= '<tr valign="top">
      <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
    </tr>'.$sHtmlLine.'<tr valign="top">
       <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
    </tr>
    <tr valign="top">
      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 14px;"/></td>

      <td colspan="2"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kood</span></p></td>

      <td><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Ribakood</span></p></td>

      <td colspan="6"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kauba nimetus</span></p></td>

      <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Hind</span></p></td>

      <td  style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kogus</span></p></td>
      <td  style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Summa</span></p></td>
      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
    </tr>
    <tr valign="top">
       <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
    </tr>'.$sHtmlLine.'<tr valign="top">
       <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td>
    </tr>';


    $iRowsHeight = 0;



      for ( $i = $aLKdata[$z]['start']; ( $i < $aDocRowsDetails['count'] )&& ( $i < $aLKdata[$z]['stop'] )  ;  $i++ )
      {

        $sOutHtlm .= '<tr valign="top">
         <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
         <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #848484; font-size: 11px;">'.( $i+1 ).'&nbsp;</span></p></td>

         <td colspan="2"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'. ( $aDocRowsDetails[$i]['CODE'] ).'</span></p></td>

         <td><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'. ( $aDocRowsDetails[$i]['BARCODE'] ).'</span></p></td>

         <td colspan="6" style="white-space: nowrap;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;white-space: nowrap;">'. ( $aDocRowsDetails[$i]['NAME'] ).'</span></p></td>
         <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocRowsDetails[$i]['DOCPRICE'] ).'</span></p></td>
         <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocRowsDetails[$i]['UNITS'] ).'</span></p></td>
         <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $aDocRowsDetails[$i]['UNITS'] * $aDocRowsDetails[$i]['DOCPRICE'] ) ).'</span></p></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 13px;"/></td>
         </tr>
         <tr valign="top">
           <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
         </tr>';

         $iRowsHeight = $iRowsHeight +16 ;
       }


       $sOutHtlm .= '<tr valign="top">
                     <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td>
</tr>'.$sHtmlLine.'<tr valign="top">
      <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 8px;"/></td>
   </tr>';

   if ($z == $iLKcount)
       {

$sOutHtlm .= '<tr valign="top">
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td>
  <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Arve koostas</span></p></td>
  <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Kokku käibemaksuta:</span></p></td>

  <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocDetails[0]['NETAMOUNT'] ).'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td>
</tr> ';

  $sOutHtlm .= '<tr valign="top">
  <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
  <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Käibemaks 20%:</span></p></td>
  <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $aDocDetails[0]['DOCAMOUNT'] - $aDocDetails[0]['NETAMOUNT'] ) ).'</span></p></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td>
</tr>';


    $sOutHtlm .= '<tr valign="top">
      <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
      <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Summa kokku:</span></p></td>
      <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocDetails[0]['DOCAMOUNT']  ).'</span></p></td>
      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td>
   </tr>
   <tr valign="top">
      <td colspan="6"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]).'px; height: 1px;"/></td>
      <td colspan="9" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
       <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 1px;"/></td>
   </tr> ';

     $sOutHtlm .= '<tr valign="top">
        <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td>
        <td colspan="14"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">Võttis vastu:</span></p></td>
       </tr>';



       $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: '.(606 - $iRowsHeight ).'px;"/></td></tr>';


       }
       else
       {

           $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: '.(665 - $iRowsHeight ).'px;"/></td></tr>';
       }


$sOutHtlm .= '<tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="11"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 9px;">'.$sCommentText[1].'</span></p></td>
        <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
     </tr>
    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="11"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 9px;">'.$sCommentText[2].'</span></p></td>
        <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
    </tr>

<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 20px;"/></td></tr>'.$sHtmlLine;

 $sOutHtlm .= '<tr valign="top">
                    <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
     </tr>
    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[1].'</span></p></td>
       <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[2].'</span></p></td>
       <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[3].'</span></p></td>
       <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
    </tr>

    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[4].'</span></p></td>
       <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[5].'</span></p></td>
       <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[6].'</span></p></td>
       <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
    </tr>

    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[7].'</span></p></td>
       <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[8].'</span></p></td>
       <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[9].'</span></p></td>
       <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
    </tr>';

   $sOutHtlm .= '<tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[10].'</span></p></td>
       <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[11].'</span></p></td>
       <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$sBotText[12].'</span></p></td>
       <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
    </tr>';


   $sOutHtlm .= '</table>';

      if ($z<$iLKcount)   $sOutHtlm .= '<pagebreak />';

    }// end page

   $sOutHtlm .= '</body></html>';


        $mpdf = new \Mpdf\Mpdf();
      //  $mpdf->forcePortraitMargins = true;

        $mpdf->WriteHTML($sOutHtlm);


        $mpdf->Output('../tmp/arve'.$aDocDetails[0]['DOCNUMBER'].'.pdf' , 'F');
       //

        // $mpdf->Output();

            $arr = array('id' => 0, 'mes' =>  'Loodud PDF fail <a href="tmp/arve'.$aDocDetails[0]['DOCNUMBER'].'.pdf" target="_blank" >arve'.$aDocDetails[0]['DOCNUMBER'].'.pdf</a> !'   );

             $my_db->close();

        }
        else
        {
           $arr = array('id' => 1, 'mes' => 'Vale id '.$_REQUEST['docid']  );
        }

       echo json_encode($arr);

    ///  test

//     }
  //    echo $sOutHtlm;



?>
