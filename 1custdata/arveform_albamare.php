<?php
    require_once __DIR__.'/../funcont.php';

/// albamare

class ArveForm {


 var $sOwnerName = 'Albamare OÜ';
  var $sOwnerRegNr = 'Reg. nr.:12148357';
  var $sOwnerMTR = 'MTR reg. TRE000653';
  var $sOwnerKMKR = 'KMKR: EE101064628';

  var $sOwnerAddress = "Narva mnt.13A, 10151 Tallinn, Estonia. www.albamare.ee Tel. +372 6617312, info@albamare.ee.";
  var $sOwnerBank1 = "Swedbank AS IBAN: EE572200221053022717 SWIFT/BIC: HABAEE2X";
  var $sOwnerBank2 = "AS SEB Pank IBAN: EE961010220212812225 SWIFT/BIC: EEUHEE2X";


  var $logoimage =  __DIR__.'/pics/albamare_logo.png';  /// w 159  x 66

  var $iShowCode = 2; // 0-no, 1 long, 2 shot
  var $iShowBarcode = 0; // 0-no, 1 long, 2 shot

  var $sFilePref = '';
  var $sFirma = "Maksja:";
  var $sFirmaName = '';
  var $payCondDesc = 'Maksetingimused:';
  var $payCond = '';
  var $sRegNrDesc = 'Reg.nr.:';
  var $sRegNr  = '';
  var $payDayDesc = 'Tähtaeg:';
  var $payDay = '';

  var $m_aDocDetails = array();
  var $m_aDocRowsDetails = array();

  var $docdate = '';

   function setData ( $aH, $aR )
   {
       $this->m_aDocDetails = $aH;
       $this->m_aDocRowsDetails = $aR;


   }

   function  prepateHeader ()
   {



     if ( isset ( $this->m_aDocDetails['DOCDATE'] ) )  $this->docdate = MyDate2($this->m_aDocDetails['DOCDATE']);
     else   $this->docdate = MyDate2($this->m_aDocDetails['REGDATE']) ;

       $dateArray = explode(".", $this->docdate );

       $day = $dateArray[0];
       $month = $dateArray[1];
       $year= $dateArray[2];

   if ( $this->m_aDocDetails['DOCTYPE'] < 10 )
   {  $this->sFirma = "Hankija:";
      $this->sFilePref = "in_";
      $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
      $this->payCondDesc = 'Maksetingimused:';
      $this->payCond = $this->m_aDocDetails['DUEDAYS'].' päeva';
      $this->sRegNrDesc = 'Reg.nr.:';
      $this->sRegNr  = $this->m_aDocDetails['TAXID'];
      $this->payDayDesc = 'Tähtaeg:';
      $this->payDay = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $this->m_aDocDetails['DUEDAYS'] ) )  );
   }
   else if ( ( $this->m_aDocDetails['DOCTYPE'] > 9 ) && ( $this->m_aDocDetails['DOCTYPE'] < 20 ) )
   {
     $this->docdate = MyDate2($this->m_aDocDetails['REGDATE']) ;
     $this->sFirma = "Maksja:";
     $this->sFilePref = "";
     $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
     $this->payCondDesc = 'Maksetingimused:';
     $this->payCond = $this->m_aDocDetails['DUEDAYS'].' päeva';
     $this->sRegNrDesc = 'Reg.nr.:';
     $this->sRegNr  = $this->m_aDocDetails['TAXID'];
     $this->payDayDesc = 'Tähtaeg:';
     $this->payDay = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $this->m_aDocDetails['DUEDAYS'] ) )  );
   }
   else if  ( $this->m_aDocDetails['DOCTYPE'] == 20 )
   {
     $this->sFirma = "Laost:";
     $this->sFilePref = "";
     $this->sFirmaName = $this->m_aDocDetails['OUTSTOCK'];
     $this->payCondDesc = '';
     $this->payCond = '';
     $this->sRegNrDesc = 'Lattu:';
     $this->sRegNr  = $this->m_aDocDetails['INSTOCK'];
     $this->payDayDesc = '';
     $this->payDay = '';
   }
   else if  ( $this->m_aDocDetails['DOCTYPE'] == 30 )
   {
     $this->sFirma = "Hankija:";
     $this->sFilePref = "ord_";
     $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
     $this->payCondDesc = '';
     $this->payCond = ' ';
     $this->sRegNrDesc = 'Reg.nr.:';
     $this->sRegNr  = $this->m_aDocDetails['TAXID'];
     $this->payDayDesc = '';
     $this->payDay = '';
   }
   else {
      $this->sFirma = "Klient:";
      $this->sFilePref = "";
      $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
      $this->payCondDesc = '';
      $this->payCond = ' ';
      $this->sRegNrDesc = 'Reg.nr.:';
      $this->sRegNr  = $this->m_aDocDetails['TAXID'];
      $this->payDayDesc = '';
      $this->payDay = '';
   }

   }


   function getHtml ()
   {
     $this->prepateHeader ();

     $dateArray = explode(".", $this->docdate );

     $day = $dateArray[0];
     $month = $dateArray[1];
     $year= $dateArray[2];


     $iSize = $this->m_aDocRowsDetails['count'];

     $aLKdata = array();

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


<td colspan="6" rowspan="5" style="padding-left: 20px;width: '.( $w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13] ) .'px;" ><img src="'.$this->logoimage.'" style="width: '.($w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13] ).'px" alt=""/>   </td>

<td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';


$sOutHtlm .= '<tr valign="top">'; // 4.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 20px;"/></td>
            <td colspan="6"><span style="font-family: Arial; color: #000000; font-weight:bold;font-size: 18px; ">'.$this->sOwnerName.'</span></td>
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 4.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
         <td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$this->sOwnerRegNr.'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
         <td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$this->sOwnerMTR.'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 6.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
         <td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$this->sOwnerKMKR.'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';



$sOutHtlm .= '<tr valign="top">'; // 8.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
         <td colspan="12"><span style="font-family: Arial; color: #000000; font-size: 12px; ">'.$this->sOwnerAddress.'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 16px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 8.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 20px;"/></td>
         <td colspan="12"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 14px; ">'.$this->sOwnerBank1.'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 20px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">'; // 9.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 20px;"/></td>
         <td colspan="12"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 14px; ">'.$this->sOwnerBank2.'</span></td>
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
            <td colspan="12" align="right"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 16px;">'.GetDocTypeName( $this->m_aDocDetails['DOCTYPE'] ).' nr.'.' '.$this->m_aDocDetails['DOCNUMBER'].'</span></td>
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 16px;"/></td>
           <td colspan="12" align="right"><span style="font-family: Arial;font-weight:bold; color: #000000; font-size: 16px;">'.$this->docdate.'</span></td>
           <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
        <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
        <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;"><b>'.$this->sFirma.'</b> '.$this->sFirmaName.'</span></td>
        <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">'.$this->m_aDocDetails['PHONE'].'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">'.$this->m_aDocDetails['EMAIL'].'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
         <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Maksetähtaeg: '.$this->payDay.'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

if ( ( $this->m_aDocDetails['DUEDAYS1']>0 ) && ( $this->m_aDocDetails['PART1']>0 ) )
{

$payDay1 = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $this->m_aDocDetails['DUEDAYS1'] ) )  );

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Ettemaksu tähtaeg: '. $payDay1 .' Summa '.MyHind( $this->m_aDocDetails['PART1'] ).' EUR</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';
}



if ( ( $this->m_aDocDetails['DUEDAYS2']>0 ) && ( $this->m_aDocDetails['PART2']>0 ) )
{

$payDay2 = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $this->m_aDocDetails['DUEDAYS2'] ) )  );

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Osamaksu tähtaeg: '.$payDay2 .' Summa '.MyHind( $this->m_aDocDetails['PART2'] ).' EUR</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';
}

if ( isset( $this->m_aDocDetails['VOYAGEDATE']) )
{

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
           <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">Reisikuupäev: '.MyDate2( $this->m_aDocDetails['VOYAGEDATE']).'</span></td>
           <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';

}
else {


$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 14px;">'.$this->m_aDocDetails['DCOMMENT'].'</span></td>
         <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 11px;"/></td></tr>';
}

$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 10px;"/></td>
         <td colspan="14"><img alt="" src="pics/px" style="width: '.( $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 10px;"/></td></tr>';


$sOutHtlm .= '<tr valign="top">';  // 5.tr
$sOutHtlm .= '<td colspan="3"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
         <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.$this->m_aDocDetails['NOTE1'].'</span></td>
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



 for ( $i = $aLKdata[$z]['start']; ( $i < $this->m_aDocRowsDetails['count'] )&& ( $i < $aLKdata[$z]['stop'] )  ;  $i++ )
 {



    if ( ( isset( $this->m_aDocRowsDetails[$i]['ATTRIBUTESET_ID'] ) ) && (  $this->m_aDocRowsDetails[$i]['ATTRIBUTESET_ID'] == 'notegr' ) )
    {
       $iRowsHeight = $iRowsHeight + 65;
       $sOutHtlm .= '<tr valign="top">
       <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 65px;"/></td>
       <td style="text-align: right;"><span style="font-family: Arial; color: #848484; font-size: 11px;"></span></td>';

        $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $this->m_aDocRowsDetails[$i]['CODE'] ).'</span></td>';


        $reanote = str_replace( "\n", ' ', $this->m_aDocRowsDetails[$i]['PNOTE']);
        $reanote = str_replace( "\r", '', $reanote );

        $sOutHtlm .= '<td colspan="7" style="white-space: nowrap;"><pre style="font-family: Arial; color: #000000; font-size: 12px;" >'.  wordwrap( $reanote ,50,"<br>\n",TRUE ) .'</pre></td>';
    }
    else {

       $iRowsHeight = $iRowsHeight + 20;
       $sOutHtlm .= '<tr valign="top">
       <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 20px;"/></td>
       <td style="text-align: right;"><span style="font-family: Arial; color: #848484; font-size: 11px;"></span></td>';

        $sOutHtlm .= '<td colspan="2"><span style="font-family: Arial; color: #000000; font-size: 12px;">'. ( $this->m_aDocRowsDetails[$i]['CODE'] ).'</span></td>';

        $sOutHtlm .= '<td colspan="7" style="white-space: nowrap;"><span style="font-family: Arial; color: #000000; font-size: 12px;white-space: nowrap;">'.  $this->m_aDocRowsDetails[$i]['NAME'] .'</span></td>';
     }

    $sOutHtlm .= '<td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( $this->m_aDocRowsDetails[$i]['UNITS'] ).'</span></td>
    <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] ).'</span></td>

    <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.MyHind ( ( $this->m_aDocRowsDetails[$i]['UNITS'] * $this->m_aDocRowsDetails[$i]['DOCPRICE'] ) ).'</span></td>
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
 <td style="text-align: right;"><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.MyHind ( $this->m_aDocDetails['DOCAMOUNT']  ).'</span></td>
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
                 <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">'.sonadega(MyHind ( $this->m_aDocDetails['DOCAMOUNT']  )).'</span></td>
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
             <td colspan="11" align="left"><span style="font-family: Arial; color: #000000; font-size: 12px;">Koostas: '.$this->m_aDocDetails['KASUTAJA'].' </span></td>
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

       return $sOutHtlm;

   }



}

?>
