<?php
    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../database.php';
    require_once  '../vendor/autoload.php';
    //include("../MPDF/mpdf.php");


   $sBotText[1] = 'Esimene Firma OÜ';
   $sBotText[2] = 'Reg. nr.:11258546';
   $sBotText[3] = 'IBAN: EE511010220235663228';

   $sBotText[4] = 'Õle 5a-20,';
   $sBotText[5] = 'KMKR: EE101064628';
   $sBotText[6] = 'SWIFT Code (BIC): EEUHEE2X';

   $sBotText[7] = '10611 Tallinn';
   $sBotText[8] = 'E-post: info@kassa.ee';
   $sBotText[9] = 'SEB Pank';

   $sBotText[10] = 'Telefon: +372 534 92230';
   $sBotText[11] = '<a href="https://www.kassa.ee">www.kassa.ee</a>';
   $sBotText[12] = '';

   $sCommentText[1] = "";
   $sCommentText[2] = "";

    $logoimage =  './pics/logo.jpg';  /// w 159  x 66
// width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px

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
   $w = array(1,22,45,45,90,60,15,39,50,19,50,60,60,20,10,1);   //
        //    0 1   2  3  4  5  6  7  8  9 10 11 12 13 14 15   000000      1 6
   $gw=0;
   for ($i=0; $i< 16; $i++  )  $gw=$gw + $w[$i];

 for ($z=1; $z<( $iLKcount + 1) ;$z++ )
  { /// begin page

$sOutHtlm .= '<table style="width: '.$gw.'px; border-collapse: collapse" cellpadding="0" cellspacing="0" border="0" bgcolor="white" >';
$sOutHtlm .='<tr>';  // 1.tr
   for ($i=0; $i< 16; $i++  ) $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[$i].'px; height: 10px;"/></td>';
$sOutHtlm .= '</tr>';
$sOutHtlm .= '<tr valign="top">'; // 2.tr
$sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 8px;"/></td>
  <td colspan="14" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 8px;">Lk. '.$z.'/'.$iLKcount.'</span></td></td>
  <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 8px;"/></td></tr>';
$sOutHtlm .= '<tr valign="top">'; // 3.tr

//$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px; height: 11px;"/></td>
//  <td colspan="3" rowspan="5 " style="padding-left: 20px;" ><img src="'.$logoimage.'" style="width: '.($w[2]+$w[3]+$w[4]-21).'px" alt=""/></td>
//   <td colspan="11"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px; height: 16px;"/></td>

  <td colspan="7" rowspan="4" style="padding-left: 20px;" ><span style="font-family: Arial; color: #000000; font-size: 28px; font-weight: bold; font-style: italic;">'. $sBotText[1].'</span></td>

   <td colspan="7"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 4.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 18px;"/></td>';
   //<td colspan="4"><img alt="" src="pics/px" style="width: '.( $w[5]+$w[6]+$w[7]+$w[8]).'px; height: 18px;"/></td>
$sOutHtlm .= '<td colspan="3" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 13px; font-weight: bold;">'.GetDocTypeName( $aDocDetails[0]['DOCTYPE'] ).' nr.:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
   <td colspan="2" style="text-align: left;"><span style="font-family: Arial; color: #000000; font-size: 13px; font-weight: bold;">'.( $aDocDetails[0]['DOCNUMBER'] ).'</span></td>

   <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14] + $w[15]).'px; height: 18px;"/></td></tr>';





   $sHtmlLine = '<tr valign="top">
      <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 1px;"/></td>
      <td colspan="13" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
      <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 1px;"/></td></tr>';


  $sOutHtlm .= '<tr valign="top">';  // 5.tr
  $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 3px;"/></td>
   <td colspan="7"><img alt="" src="pics/px" style="width: '.( $w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 3px;"/></td></tr>';
  $sOutHtlm .= '<tr valign="top">'; // 6.tr

  $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 18px;"/></td>';
  //  <td colspan="4"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]).'px; height: 18px;"/></td>
  $sOutHtlm .= '<td colspan="3" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 13px; ">Kuupäev:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    <td colspan="2" style="text-align: left;"><span style="font-family: Arial; color: #000000; font-size: 13px; ">'.$docdate.'</span></td>

    <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 18px;"/></td></tr>';

//  $sOutHtlm .= '<tr valign="top">'; // 7.tr
//  $sOutHtlm .= '<tdcolspan="2" ><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 16px;"/></td>
//  <td colspan="11"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

//  $sOutHtlm .= '<tr valign="top">'; // 8.tr
//  $sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 1px;"/></td></tr> ';


  $sOutHtlm .= '<tr valign="top">'; // 9.tr


  $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>';

  $sOutHtlm .= '<td colspan="2" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.$sFirma.'&nbsp;</span></td>
  <td colspan="7"><span style="font-family: Arial; color: #000000; font-size: 12px;">&nbsp;'.$sFirmaName.'</span></td>
  <td colspan="2" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; ">'.$payCondDesc.'&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td colspan="2" style="text-align: left;"><span style="font-family: Arial; color: #000000; font-size: 12px; ">'.$payCond.'</span></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';






  $sOutHtlm .= '<tr valign="top">'; // 10.tr
  $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
  <td colspan="7"><span style="font-family: Arial; color: #000000; font-size: 12px;">&nbsp;'. ($aDocDetails[0]['ADDRESS']).'</span></td>
  <td colspan="2" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 13px;">'.$payDayDesc.'&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td colspan="2" style="text-align: left;"><span style="font-family: Arial; color: #000000; font-size: 13px;">'.$payDay.'</span></td>

  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

  $sOutHtlm .= '<tr valign="top">'; // 11.tr
  $sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
  <td colspan="7"><span style="font-family: Arial; color: #000000; font-size: 12px;">&nbsp;'.$aDocDetails[0]['ADDRESS2'].'</span></td>
  <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 10px;"></span></td>

  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

  $sOutHtlm .= '<tr valign="top">'; // 12.tr
  $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
  <td colspan="2" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.$sRegNrDesc.'&nbsp;</span></td>
  <td colspan="7" ><span style="font-family: Arial; color: #000000; font-size: 12px;">&nbsp;'.$sRegNr.'</span></td>
  <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 10px;"></span></td>
  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td>
  </tr>';
  //$sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
  //<td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Reg.nr.:&nbsp;</span></p></td>
  //<td colspan="7" ><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($aDocDetails[0]['TAXID']).'</span></p></td>
  //<td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">Makseaeg: '.$aDocDetails[0]['DUEDAYS'].' päeva</span></p></td>
//  <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
//  </tr>';

   if ( isset($aDocDetails[0]['SUBCUSTOMER']) )
   {
     $sOutHtlm .= '<tr valign="top"><td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
     <td colspan="2" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">Saaja:&nbsp;</span></td>
     <td colspan="12" ><span style="font-family: Arial; color: #000000; font-size: 12px;">&nbsp;'.$aDocDetails[0]['SUBNAME'].', '.$aDocDetails[0]['SUBADDRESS'].' '.$aDocDetails[0]['SUBADDRESS2'].'</span></td>
     <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 16px;"/></td>
     </tr>';

   }
   else
   {
      $sOutHtlm .= '<tr valign="top">'; // 13.tr
      $sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 11px;"/></td></tr>';
   }



   if ( strlen( $aDocDetails[0]['DCOMMENT']) > 0 ){ $sOutHtlm .= '<tr valign="top">';  // 14.tr
      $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
      <td colspan="2" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Märkused:&nbsp;</span></td>
      <td colspan="12" ><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($aDocDetails[0]['DCOMMENT']).'</span></td>
      <td ><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 13px;"/></td>
    </tr>';
    }
   else {$sOutHtlm .= '<tr valign="top">';  // 14.tr
      $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
      <td colspan="14"><img alt="" src="pics/px" border="0"/></td>
      <td ><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 13px;"/></td></tr>'; }

    $sOutHtlm .= '<tr valign="top">'; // 15.tr
    $sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 20px;"/></td>
    </tr>'.$sHtmlLine.'<tr valign="top">';// 16.tr
    $sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td></tr>';
    $sOutHtlm .= '<tr valign="top">'; // 17.tr



    $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 14px;"/></td>';

    $iColSpanForName = 0;

    if ( $iShowCode == 1 )
    { $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kood</span></td>';
      $iColSpanForName = 0;
    }
    else if ( $iShowCode == 2 )
    { $sOutHtlm .= '<td><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kood</span></td>';
      $iColSpanForName = 1;
    }
    else $iColSpanForName = 2;

   if ( $iShowBarcode == 1 )
   {
        $sOutHtlm .= '<td><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Ribakood</span></td>';
   }
   else   $iColSpanForName =   $iColSpanForName + 1;


    $sOutHtlm .= '<td colspan="'.( 6 + $iColSpanForName ).'"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">&nbsp;&nbsp;&nbsp;Kauba nimetus</span></td>

      <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Hind</span></td>

      <td  style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Kogus</span></td>
      <td  style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">Summa</span></td>
      <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td></tr>';

    $sOutHtlm .= '<tr valign="top">'; // 18.tr
    $sOutHtlm .= '<td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
    </tr>'.$sHtmlLine.'<tr valign="top">
       <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td>
    </tr>';  // 19.tr


    $iRowsHeight = 0;



      for ( $i = $aLKdata[$z]['start']; ( $i < $aDocRowsDetails['count'] )&& ( $i < $aLKdata[$z]['stop'] )  ;  $i++ )
      {

        $sOutHtlm .= '<tr valign="top">
         <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
         <td style="text-align: right;"><span style="font-family: Arial; color: #848484; font-size: 11px;">'.( $i+1 ).'&nbsp;</span></td>';

         $iColSpanForName = 0;

         if ( $iShowCode == 1 )
         { $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $aDocRowsDetails[$i]['CODE'] ).'</span></td>';
           $iColSpanForName = 0;
         }
         else if ( $iShowCode == 2 )
         { $sOutHtlm .= '<td><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $aDocRowsDetails[$i]['CODE'] ).'</span></td>';
           $iColSpanForName = 1;
         }
         else $iColSpanForName = 2;

        if ( $iShowBarcode == 1 )
        {
             $sOutHtlm .= '<td><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $aDocRowsDetails[$i]['BARCODE'] ).'</span></td>';
        }
        else   $iColSpanForName =   $iColSpanForName + 1;



        $sOutHtlm .= '<td colspan="'.( 6 + $iColSpanForName ).'" style="white-space: nowrap;"><span style="font-family: Arial; color: #000000; font-size: 12px;white-space: nowrap;">'. ( $aDocRowsDetails[$i]['NAME'] ).'</span></td>
         <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( $aDocRowsDetails[$i]['DOCPRICE'] ).'</span></td>
         <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( $aDocRowsDetails[$i]['UNITS'] ).'</span></td>
         <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( ( $aDocRowsDetails[$i]['UNITS'] * $aDocRowsDetails[$i]['DOCPRICE'] ) ).'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td>
         </tr>';

         if (  ( isset ($aDocRowsDetails[$i]['SERIAL']) ) && ( strlen($aDocRowsDetails[$i]['SERIAL']) >0 ) )
         {
           $sOutHtlm .= '<tr valign="top"><td colspan="3" style="text-align: right;"><span style="font-family: Arial;  font-size: 10px; color: #343434; font-style: italic;">S/N:&nbsp;&nbsp;</span></td>
                                          <td colspan="11" style="text-align:left;"><span style="font-family: Arial;  font-size: 10px; color: #343434; font-style: italic; ">'.$aDocRowsDetails[$i]['SERIAL'].'</span></td>
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 12px;"/></td></tr>';
            $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td></tr>';
           $iRowsHeight = $iRowsHeight +30 ;

         }
         else
         {
            $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td></tr>';
            $iRowsHeight = $iRowsHeight +19 ;
         }
       }


       $sOutHtlm .= '<tr valign="top">
                     <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td></tr>'.$sHtmlLine;

       $sOutHtlm .='<tr valign="top"> <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 8px;"/></td></tr>';

   if ($z == $iLKcount)
   {
       $sOutHtlm .= '<tr valign="top">
           <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td>
           <td colspan="7"></td>
           <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">Kokku käibemaksuta:</span></td>
           <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $aDocDetails[0]['NETAMOUNT'] ).'</span></td>
           <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td></tr> ';

    $sOutHtlm .= '<tr valign="top">
       <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
       <td colspan="4" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">Käibemaks 20%:</span></td>
       <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $aDocDetails[0]['DOCAMOUNT'] - $aDocDetails[0]['NETAMOUNT'] ) ).'</span></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td></tr>';


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
        <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td>
        <td colspan="14"></td>
       </tr>';



       $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: '.(660 - $iRowsHeight ).'px;"/></td></tr>';



       $sOutHtlm .= '<tr valign="top">
              <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
              <td colspan="4"><span style="font-family: Arial; color: #000000; font-size: 11px;">Arve väljastaja allkiri:</span></td>
              <td colspan="2"></td>
              <td colspan="4"><span style="font-family: Arial; color: #000000; font-size: 11px;">Kauba saaja nimi:</span></td>
               <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
            </tr>';

         $sOutHtlm .= '<tr valign="top">
                          <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 20px;"/></td>
                          <td colspan="10"></td>

                           <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
                        </tr>';

     $sOutHtlm .= '<tr valign="top">
                   <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 12px;"/></td>
                   <td colspan="6"></td>
                   <td colspan="4"><span style="font-family: Arial; color: #000000; font-size: 11px;">Allkiri:</span></td>
                  <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td></tr>';

    $sOutHtlm .= '<tr valign="top">
                  <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 1px;"/></td>
                  <td colspan="10"></td>
                 <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td></tr>';


       } // end of last page with KOKKU
       else
       {

           $sOutHtlm .= '<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: '.(590 - $iRowsHeight ).'px;"/></td></tr>';
       }


$sOutHtlm .= '<tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="11"><span style="font-family: Arial; color: #000000; font-size: 9px;">'.$sCommentText[1].'</span></td>
        <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
     </tr>
    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
       <td colspan="11"><span style="font-family: Arial; color: #000000; font-size: 9px;">'.$sCommentText[2].'</span></td>
        <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
    </tr>

<tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 14px;"/></td></tr>'.$sHtmlLine;

 $sOutHtlm .= '<tr valign="top">
                    <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
     </tr>
    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 15px;"/></td>
       <td colspan="3"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[1].'</span></td>
       <td colspan="6" style="text-align: center;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[2].'</span></td>
       <td colspan="3" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[3].'</span></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 15px;"/></td>
    </tr>

    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 15px;"/></td>
       <td colspan="3"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[4].'</span></td>
       <td colspan="6" style="text-align: center;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[5].'</span></td>
       <td colspan="3" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[6].'</span></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 15px;"/></td>
    </tr>

    <tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 15px;"/></td>
       <td colspan="3"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[7].'</span></td>
       <td colspan="6" style="text-align: center;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[8].'</span></td>
       <td colspan="3" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[9].'</span></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 15px;"/></td>
    </tr>';

   $sOutHtlm .= '<tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 18px;"/></td>
       <td colspan="3"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[10].'</span></td>
       <td colspan="6" style="text-align: center;"><span style="font-family: Arial; color: #000000; font-size: 16px;">'.$sBotText[11].'</span></td>
       <td colspan="3" style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$sBotText[12].'</span></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[14]+$w[15]).'px; height: 18px;"/></td>
    </tr>';


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
//    echo $sOutHtlm;



?>
