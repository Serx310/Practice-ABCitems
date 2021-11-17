<?php
    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../database.php';
    require_once  '../vendor/autoload.php';
    //include("../MPDF/mpdf.php");


   $sOwnerName = 'Albamare OÜ';
   $sOwnerRegNr = 'Reg. nr.:12148357';
   $sOwnerMTR = 'MTR reg. TRE000653';
   $sOwnerKMKR = 'KMKR: EE101064628';

   $sOwnerAddress = "Narva mnt.13A, 10151 Tallinn, Estonia. www.albamare.ee Tel. +372 6617312, info@albamare.ee.";
   $sOwnerBank1 = "Swedbank AS IBAN: EE572200221053022717 SWIFT/BIC: HABAEE2X";
   $sOwnerBank2 = "AS SEB Pank IBAN: EE961010220212812225 SWIFT/BIC: EEUHEE2X";



   $sCommentText[1] = "";
   $sCommentText[2] = "";



    $logoimage =  './pics/albamare_logo.png';  /// w 159  x 66

    $iShowCode = 2; // 0-no, 1 long, 2 shot
    $iShowBarcode = 0; // 0-no, 1 long, 2 shot



         if (  (isset ($_REQUEST['docid'])) && ( strlen($_REQUEST['docid'])>0 )    )
         {
             $my_set = new Obstock_Settings();



              $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );
              $aDocDetails = $my_db->GetDocuments ( -1, $_REQUEST['docid'] );
              $aDocRowsDetails = $my_db->GetDocumentRows ( $_REQUEST['docid'], $my_set->serialnumber );



                $sFirma = "Maksja:";
                $sFilePref = "";
                $sFirmaName = $aDocDetails[0]['CUSTNAME'];
                $payCondDesc = 'Maksetingimused:';
                $payCond = $aDocDetails[0]['DUEDAYS'].' päeva';
                $sRegNrDesc = 'Reg.nr.:';
                $sRegNr  = $aDocDetails[0]['TAXID'];
                $payDayDesc = 'Tähtaeg:';
                $payDay = '';

                if ( isset ( $aDocDetails[0]['DOCDATE'] ) )  $docdate = MyDate2($aDocDetails[0]['DOCDATE']);
                else   $docdate = MyDate2($aDocDetails[0]['REGDATE']) ;

                  $dateArray = explode(".", $docdate );

                  $day = $dateArray[0];
                	$month = $dateArray[1];
                  $year= $dateArray[2];

              if ( $aDocDetails[0]['DOCTYPE'] < 10 )
              {  $sFirma = "Hankija:";
                 $sFilePref = "in_";
                 $sFirmaName = $aDocDetails[0]['CUSTNAME'];
                 $payCondDesc = 'Maksetingimused:';
                 $payCond = $aDocDetails[0]['DUEDAYS'].' päeva';
                 $sRegNrDesc = 'Reg.nr.:';
                 $sRegNr  = $aDocDetails[0]['TAXID'];
                 $payDayDesc = 'Tähtaeg:';
                 $payDay = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $aDocDetails[0]['DUEDAYS'] ) )  );
              }
              else if ( ( $aDocDetails[0]['DOCTYPE'] > 9 ) && ( $aDocDetails[0]['DOCTYPE'] < 20 ) )
              {
                $docdate = MyDate2($aDocDetails[0]['REGDATE']) ;
                $sFirma = "Maksja:";
                $sFilePref = "";
                $sFirmaName = $aDocDetails[0]['CUSTNAME'];
                $payCondDesc = 'Maksetingimused:';
                $payCond = $aDocDetails[0]['DUEDAYS'].' päeva';
                $sRegNrDesc = 'Reg.nr.:';
                $sRegNr  = $aDocDetails[0]['TAXID'];
                $payDayDesc = 'Tähtaeg:';
                $payDay = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $aDocDetails[0]['DUEDAYS'] ) )  );
              }
              else if  ( $aDocDetails[0]['DOCTYPE'] == 20 )
              {
                $sFirma = "Laost:";
                $sFilePref = "";
                $sFirmaName = $aDocDetails[0]['OUTSTOCK'];
                $payCondDesc = '';
                $payCond = '';
                $sRegNrDesc = 'Lattu:';
                $sRegNr  = $aDocDetails[0]['INSTOCK'];
                $payDayDesc = '';
                $payDay = '';
              }
              else if  ( $aDocDetails[0]['DOCTYPE'] == 30 )
              {
                $sFirma = "Hankija:";
                $sFilePref = "ord_";
                $sFirmaName = $aDocDetails[0]['CUSTNAME'];
                $payCondDesc = '';
                $payCond = ' ';
                $sRegNrDesc = 'Reg.nr.:';
                $sRegNr  = $aDocDetails[0]['TAXID'];
                $payDayDesc = '';
                $payDay = '';
              }
              else {
                 $sFirma = "Klient:";
                 $sFilePref = "";
                 $sFirmaName = $aDocDetails[0]['CUSTNAME'];
                 $payCondDesc = '';
                 $payCond = ' ';
                 $sRegNrDesc = 'Reg.nr.:';
                 $sRegNr  = $aDocDetails[0]['TAXID'];
                 $payDayDesc = '';
                 $payDay = '';
              }



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
   $w = array( 1, 22, 20, 70, 90, 60, 15, 39, 50, 19, 50, 60, 60, 70, 25, 1);   //
        //     0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15   000000      1 6
   $gw=0;
   for ($i=0; $i< 16; $i++  )  $gw=$gw + $w[$i];

 for ($z=1; $z<( $iLKcount + 1) ;$z++ )
  { /// begin page

$sOutHtlm .= '<table style="width: '.$gw.'px; border-collapse: collapse" cellpadding="0" cellspacing="0" border="0" bgcolor="white" >';
$sOutHtlm .='<tr>';  // 1.tr
   for ($i=0; $i< 16; $i++  ) $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[$i].'px; height: 1px;"/></td>';
$sOutHtlm .= '</tr>';
$sOutHtlm .= '<tr valign="top">'; // 2.tr
$sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 2px;"/></td>
  <td colspan="14" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 1px;"></span></td></td>
  <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 8px;"/></td></tr>';
$sOutHtlm .= '<tr valign="top">'; // 3.tr

//$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px; height: 11px;"/></td>
//  <td colspan="3" rowspan="5 " style="padding-left: 20px;" ><img src="'.$logoimage.'" style="width: '.($w[2]+$w[3]+$w[4]-21).'px" alt=""/></td>
//   <td colspan="11"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px; height: 20px;"/></td>

  <td colspan="6">&nbsp;</td>


  <td colspan="6" rowspan="5" style="padding-left: 20px;width: '.( $w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13] ) .'px;" ><img src="'.$logoimage.'" style="width: '.($w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13] ).'px" alt=""/>   </td>

   <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';


   $sOutHtlm .= '<tr valign="top">'; // 4.tr
   $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 20px;"/></td>
                 <td colspan="6"><span style="font-family: Arial; color: #000000; font-weight:bold;font-size: 18px; ">'.$sOwnerName.'</span></td>
                 <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 4.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
              <td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$sOwnerRegNr.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
              <td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$sOwnerMTR.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 6.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
              <td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$sOwnerKMKR.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';



$sOutHtlm .= '<tr valign="top">'; // 8.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
              <td colspan="12"><span style="font-family: Arial; color: #000000; font-size: 12px; ">'.$sOwnerAddress.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 8.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 20px;"/></td>
              <td colspan="12"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 14px; ">'.$sOwnerBank1.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 9.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 20px;"/></td>
              <td colspan="12"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 14px; ">'.$sOwnerBank2.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';

   $sHtmlLine = '<tr valign="top">
      <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 1px;"/></td>
      <td colspan="13" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
      <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 1px;"/></td></tr>';

  $sOutHtlm .= $sHtmlLine;


  $sOutHtlm .= '<tr valign="top">';  // 5.tr
  $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
   <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';

  $sOutHtlm .= '<tr valign="top">';  // 5.tr
   $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
                 <td colspan="12" align="right"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 16px;">'.GetDocTypeName( $aDocDetails[0]['DOCTYPE'] ).' nr.'.' '.$aDocDetails[0]['DOCNUMBER'].'</span></td>
                 <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

  $sOutHtlm .= '<tr valign="top">';  // 5.tr
  $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
                <td colspan="12" align="right"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 16px;">'.$docdate.'</span></td>
                <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

  $sOutHtlm .= '<tr valign="top">';  // 5.tr
 $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
             <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
             <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;"><b>'.$sFirma.'</b> '.$sFirmaName.'</span></td>
             <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">'.$aDocDetails[0]['PHONE'].'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">'.$aDocDetails[0]['EMAIL'].'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
              <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Maksetähtaeg: '.$payDay.'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

if ( ( $aDocDetails[0]['DUEDAYS1']>0 ) && ( $aDocDetails[0]['PART1']>0 ) )
{

 $payDay1 = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $aDocDetails[0]['DUEDAYS1'] ) )  );

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Ettemaksu tähtaeg: '. $payDay1 .' Summa '.MyHind( $aDocDetails[0]['PART1'] ).' EUR</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';
}



if ( ( $aDocDetails[0]['DUEDAYS2']>0 ) && ( $aDocDetails[0]['PART2']>0 ) )
{

 $payDay2 = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $aDocDetails[0]['DUEDAYS2'] ) )  );

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Osamaksu tähtaeg: '.$payDay2 .' Summa '.MyHind( $aDocDetails[0]['PART2'] ).' EUR</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';
}

if ( isset( $aDocDetails[0]['VOYAGEDATE']) )
{

  $sOutHtlm .= '<tr valign="top">';  // 5.tr
  $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
                <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Reisikuupäev: '.MyDate2($aDocDetails[0]['VOYAGEDATE']).'</span></td>
                <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

}
else {


$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">'.$aDocDetails[0]['DCOMMENT'].'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';
  }

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
              <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';


$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
              <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$aDocDetails[0]['NOTE1'].'</span></td>
              <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';


$sOutHtlm .= '<tr valign="top">'; // 13.tr
$sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 11px;"/></td></tr>';


  $sOutHtlm .= $sHtmlLine;

  $sOutHtlm .= '<tr valign="top">';  // 5.tr
  $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 14px;"/></td>';
  $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kood</span></td>';
  $sOutHtlm .= '<td colspan="7"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">&nbsp;&nbsp;&nbsp;Kauba / teenuste nimetus</span></td>

      <td  style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kogus</span></td>
      <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Hind EUR</span></td>
      <td  style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Summa EUR</span></td>
      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td></tr>';


    $sOutHtlm .= '<tr valign="top">'; // 18.tr
    $sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
    </tr>'.$sHtmlLine.'<tr valign="top">
       <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td>
    </tr>';  // 19.tr


    $iRowsHeight = 0;



      for ( $i = $aLKdata[$z]['start']; ( $i < $aDocRowsDetails['count'] )&& ( $i < $aLKdata[$z]['stop'] )  ;  $i++ )
      {



         if ( ( isset( $aDocRowsDetails[$i]['ATTRIBUTESET_ID'] ) ) && (  $aDocRowsDetails[$i]['ATTRIBUTESET_ID'] == 'notegr' ) )
         {
            $iRowsHeight = $iRowsHeight + 65;
            $sOutHtlm .= '<tr valign="top">
            <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 65px;"/></td>
            <td style="text-align: right;"><span style="font-family: Arial; color: #848484; font-size: 11px;"></span></td>';

             $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $aDocRowsDetails[$i]['CODE'] ).'</span></td>';

             $sOutHtlm .= '<td colspan="7" style="white-space: nowrap;"><pre style="font-family: Arial; color: #000000; font-size: 10px;" >'.  wordwrap($aDocRowsDetails[$i]['PNOTE'],50,"<br>\n",TRUE ) .'</pre></td>';
         }
         else {

            $iRowsHeight = $iRowsHeight + 20;
            $sOutHtlm .= '<tr valign="top">
            <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 20px;"/></td>
            <td style="text-align: right;"><span style="font-family: Arial; color: #848484; font-size: 11px;"></span></td>';

             $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $aDocRowsDetails[$i]['CODE'] ).'</span></td>';

             $sOutHtlm .= '<td colspan="7" style="white-space: nowrap;"><span style="font-family: Arial; color: #000000; font-size: 12px;white-space: nowrap;">'.  $aDocRowsDetails[$i]['NAME'] .'</span></td>';
          }

         $sOutHtlm .= '<td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( $aDocRowsDetails[$i]['UNITS'] ).'</span></td>
         <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( $aDocRowsDetails[$i]['DOCPRICE'] ).'</span></td>

         <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( ( $aDocRowsDetails[$i]['UNITS'] * $aDocRowsDetails[$i]['DOCPRICE'] ) ).'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td>
         </tr>';


       }


       $sOutHtlm .= '<tr valign="top">
                     <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td></tr>'.$sHtmlLine;

       $sOutHtlm .='<tr valign="top"> <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 8px;"/></td></tr>';

   if ($z == $iLKcount)
   {
  //     $sOutHtlm .= '<tr valign="top">
  //         <td colspan="7"></td>
  //       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td>
//           <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">Kokku käibemaksuta:</span></td>
  //         <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocDetails[0]['NETAMOUNT'] ).'</span></td>
  //         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td></tr> ';

//    $sOutHtlm .= '<tr valign="top">
  //     <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
  //     <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">Käibemaks 20%:</span></td>
//       <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $aDocDetails[0]['DOCAMOUNT'] - $aDocDetails[0]['NETAMOUNT'] ) ).'</span></td>
//       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td></tr>';


    $sOutHtlm .= '<tr valign="top">
      <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
      <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">Summa kokku:</span></td>
      <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.MyHind ( $aDocDetails[0]['DOCAMOUNT']  ).'</span></td>
      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td>
   </tr>
   <tr valign="top">
      <td colspan="6"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]).'px; height: 1px;"/></td>
      <td colspan="9" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
       <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 1px;"/></td>
   </tr> ';



                         $sOutHtlm .= '<tr valign="top">
                            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td><td colspan="10"></td></tr>';

        $sOutHtlm .= '<tr valign="top">';  // 5.tr
        $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                      <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.sonadega(MyHind ( $aDocDetails[0]['DOCAMOUNT']  )).'</span></td>
                      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

                      $sOutHtlm .= '<tr valign="top">
                         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td><td colspan="14"></td></tr>';

       $sOutHtlm .= '<tr valign="top">';  // 5.tr
       $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                     <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">Arve on esitatud vastavalt KMS §40 kasuminormi maksustamise kord - reisibürood</span></td>
                     <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

       $sOutHtlm .= '<tr valign="top">';  // 5.tr
       $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                                   <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">Albamare OÜ jätab endale õiguse arvestada viivist 0,15% päevas, kui lepingus ei ole sätestatud teisiti.</span></td>
                                   <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

     $sOutHtlm .= '<tr valign="top">
                   <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td><td colspan="14"></td></tr>';

    $sOutHtlm .= '<tr valign="top">';  // 5.tr
    $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                  <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">Koostas: '.$aDocDetails[0]['KASUTAJA'].' </span></td>
                 <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';




       $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: '.(290 - $iRowsHeight ).'px;"/></td></tr>';

     $sOutHtlm .= $sHtmlLine;

       $sOutHtlm .= '<tr valign="top">';  // 5.tr
       $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                     <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">Tasudes tellimuskinnituse/arve eest olete aktsepteerinud reisikorraldaja reisitingimusi</span></td>
                    <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

      $sOutHtlm .= '<tr valign="top">';  // 5.tr
      $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                   <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">(<a href="https://albamare.ee/et/reisitingimused">https://albamare.ee/et/reisitingimused</a>)</span></td>
                  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

      $sOutHtlm .= '<tr valign="top">';  // 5.tr
      $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                    <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">NB! Kontrollige oma reisidokumentide (pass, ID-kaart) kehtivust ja vajalike viisade olemasolu vastavalt nõuetele.</span></td>
                    <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

       $sOutHtlm .= '<tr valign="top">';  // 5.tr
      $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                   <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">Tuletame meelde, et pass peab kehtima 6 kuud pärast reisi lõppemise kuupäeva.</span></td>
                    <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

      $sOutHtlm .= '<tr valign="top">';  // 5.tr
      $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                   <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">Lennu-, bussi,- ja laevapileti kaotamine ei ole võimalik.</span></td>
                   <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

      $sOutHtlm .= '<tr valign="top">';  // 5.tr
      $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                   <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">Soovitame võimalike reisitõrgete puhuks vormistada reisikindlustus.</span></td>
                   <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

    $sOutHtlm .= '<tr valign="top">';  // 5.tr
     $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                  <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">Enne reisi tutvuge kindlasti reisitingimuste ja lennuliikluse sätetega meie kodulehel www.albamare.ee.</span></td>
                  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

     $sOutHtlm .= '<tr valign="top">';  // 5.tr
     $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                  <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 10px;">Palume kontrollida väljalennu aega 24 tundi enne reisi algust.</span></td>
                  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';




       } // end of last page with KOKKU
       else
       {
           $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: '.(570 - $iRowsHeight ).'px;"/></td></tr>';
       }


   $sOutHtlm .= '</table>';

      if ($z<$iLKcount)   $sOutHtlm .= '<pagebreak />';

    }// end page

   $sOutHtlm .= '</body></html>';


  $mpdf = new \Mpdf\Mpdf();
      //  $mpdf->forcePortraitMargins = true;

     $mpdf->WriteHTML($sOutHtlm);


    if ( ( isset( $aDocDetails[0]['DOCNUMBER']) ) && ( strlen($aDocDetails[0]['DOCNUMBER'])>0 ) )

       $sFileName = $sFilePref.GetDocTypeNameForFile( $aDocDetails[0]['DOCTYPE'] ).safeForFileName( $aDocDetails[0]['DOCNUMBER']).'.pdf';
    else
       $sFileName = $sFilePref.GetDocTypeNameForFile( $aDocDetails[0]['DOCTYPE'] ).'_st'.$aDocDetails[0]['ID'].'.pdf';





      $mpdf->Output('../tmp/'.$sFileName , 'F');
       //

        // $mpdf->Output();

        $sendButton = '<input type="text"  id="epost1"  value="'.$aDocDetails[0]['EMAIL'].'"  autocomplete="off" style="width:300px;height:25px;" >';
        $sendButton .=  '<div class="out_btn" style="left:330px;top:-5px" onclick="SendEmail( 1 );" ><span class="msg_yes" >Send</span> </div>';

       if ( isset($aDocDetails[0]['SUBEMAIL'] ) )
       {
         $sendButton2 = '<input type="text"  id="epost2"  value="'.$aDocDetails[0]['SUBEMAIL'].'"  autocomplete="off" style="width:300px;height:25px;" >';
         $sendButton2 .=  '<div class="out_btn" style="left:330px;top:-5px" onclick="SendEmail( 2 );" ><span class="msg_yes" >Send</span> </div>';
       }
       else $sendButton2 = '';



            $arr = array('id' => 0, 'mes' =>  'Loodud PDF fail <a href="tmp/'.$sFileName.'" target="_blank" >'.$sFileName.'</a> !' ,
            'but' =>  $sendButton , 'but2' =>  $sendButton2  );

             $my_db->close();

        }
        else
        {
           $arr = array('id' => 1, 'mes' => 'Vale id '   );
        }

        echo json_encode($arr);



    // }
  ///  test
    //echo $sOutHtlm;



?>
