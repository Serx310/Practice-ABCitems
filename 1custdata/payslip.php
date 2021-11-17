<?php

  require_once  '../vendor/autoload.php';


class KassaOrder {

var $m_sSelStock = "";

function getLink ( $in )
{


    $logoimage =  '../1custdata/pics/indigo.jpg';  /// w 159  x 66
    $sOwnerName = 'Indigo Travel OÜ';
    $sOwnerAddress = 'Jõe 3, 10151, Tallinn, Eesti';
    $sOwnerRegNr = '12190247';
    $sOwnerKMKR = 'EE101501123';



  $sOutHtlm = '<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">
a {text-decoration: none}
</style>
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000">';

$w = array( 1, 22, 20, 70, 90, 60, 15, 39, 50, 19, 50, 60, 60, 70, 25, 1);   //
     //     0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15   000000      1 6
$gw=0;
for ($i=0; $i< 16; $i++  )  $gw=$gw + $w[$i];

$sOutHtlm .= '<table style="width: '.$gw.'px; border-collapse: collapse" cellpadding="0" cellspacing="0" border="0" bgcolor="white" >';

$sOutHtlm .='<tr>';  // 1.tr
   for ($i=0; $i< 16; $i++  ) $sOutHtlm .= '<td><img alt="" src="pics/px" style="width: '.$w[$i].'px; height: 10px;"/></td>';
$sOutHtlm .= '</tr>';

$sHtmlLine = '<tr valign="top">
   <td><img alt="" src="pics/px" style="width: '.( $w[0] ).'px; height: 8px;"/></td>
   <td colspan="14" style="border-top-style: solid; border-top-width: 1px; border-top-color: #000000; "><img alt="" src="pics/px" border="0"/></td>
   <td><img alt="" src="pics/px" style="width: '.$w[15].'px; height: 8px;"/></td></tr>';

$sOutHtlm .= $sHtmlLine;


$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; " ><img src="'.$logoimage.'" style="width:160px" alt=""/></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><img src="'.$logoimage.'" style="width:160px" alt=""/></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$sOwnerName.'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; ">'.$sOwnerName.'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="9" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000;"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+ $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]) .'px;height: 10px;"/></td>';
$sOutHtlm .='<td colspan="7"><img alt="" src="pics/px" style="width: '. ($w[9] + $w[10] +$w[11]+$w[12]+$w[13]+$w[14]+$w[15] ).'px;height: 10px;"/></td> </tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 12px; ">'.$sOwnerAddress.'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 12px; ">'.$sOwnerAddress.'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 12px; ">Reg. nr. '.$sOwnerRegNr.'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 12px; ">Reg. nr. '.$sOwnerRegNr.'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 12px; ">KMKR nr. '.$sOwnerKMKR.'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 12px; ">KMKR nr. '.$sOwnerKMKR.'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="9" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000;"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+ $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]) .'px;height: 10px;"/></td>';
$sOutHtlm .='<td colspan="7"><img alt="" src="pics/px" style="width: '. ($w[9] + $w[10] +$w[11]+$w[12]+$w[13]+$w[14]+$w[15] ).'px;height: 10px;"/></td> </tr>';

$sOutHtlm .= $sHtmlLine;

$sOutHtlm .='<tr><td colspan="9" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000;"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+ $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]) .'px;height: 10px;"/></td>';
$sOutHtlm .='<td colspan="7"><img alt="" src="pics/px" style="width: '. ($w[9] + $w[10] +$w[11]+$w[12]+$w[13]+$w[14]+$w[15] ).'px;height: 10px;"/></td> </tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 14px;font-weight: bold; ">';
$sOutHtlm .='KASSA SISSETULEKU ORDER NR. '.$in['ordnr'].'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 14px; font-weight: bold;">';
$sOutHtlm .='KVIITUNG ORDERILE NR.'.$in['ordnr'].'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .='Kellelt: '.$in['custname'].'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .='Kellelt: '.$in['custname'].'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 11px;font-weight: bold; ">';
$sOutHtlm .='Arve '.$in['invnr'].' '.$in['invdate'].'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 11px;font-weight: bold;">';
$sOutHtlm .='Arve '.$in['invnr'].' '.$in['invdate'].'</span></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .='Summa: </span><span style="font-family: Arial; color: #000000; font-size: 16px;font-weight: bold; "> '.$in['paid'].' </span><span style="font-family: Arial; color: #000000; font-size: 11px; ">EUR</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 11px;font-weight: bold;">';
$sOutHtlm .='Summa: </span><span style="font-family: Arial; color: #000000; font-size: 16px;font-weight: bold; "> '.$in['paid'].' </span><span style="font-family: Arial; color: #000000; font-size: 11px; ">EUR</span></td></tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 10px; ">';
$sOutHtlm .=sonadega($in['paid']).'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 10px;">';
$sOutHtlm .=sonadega($in['paid']).'</span></td></tr>';


$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .='Kuupäev: '.$in['paydate'].'</span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .='Kuupäev: '.$in['paydate'].'</span></td></tr>';


$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;height: 30px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .= $sOwnerName.' esindaja: </span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .= $sOwnerName.' esindaja: </span></td></tr>';

$sOutHtlm .='<tr><td colspan="9" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000;"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+ $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]) .'px;height: 60px;"/></td>';
$sOutHtlm .='<td colspan="7"><img alt="" src="pics/px" style="width: '. ($w[9] + $w[10] +$w[11]+$w[12]+$w[13]+$w[14]+$w[15] ).'px;height: 60px;"/></td> </tr>';

$sOutHtlm .='<tr><td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ) .'px;height: 30px;"/></td>';
$sOutHtlm .='<td colspan="7" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000; "><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .= 'Klient: </span></td>';
$sOutHtlm .='<td ><img alt="" src="pics/px" style="width: '. $w[9].'px;"/></td><td colspan="6"><span style="font-family: Arial; color: #000000; font-size: 11px; ">';
$sOutHtlm .= 'Klient: esindaja: </span></td></tr>';

$sOutHtlm .='<tr><td colspan="9" style="border-right-style: solid; border-right-width: 1px; border-right-color: #000000;"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1]+ $w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]) .'px;height: 60px;"/></td>';
$sOutHtlm .='<td colspan="7"><img alt="" src="pics/px" style="width: '. ($w[9] + $w[10] +$w[11]+$w[12]+$w[13]+$w[14]+$w[15] ).'px;height: 60px;"/></td> </tr>';

$sOutHtlm .= $sHtmlLine;


   $sOutHtlm .= '</table>';
   $sOutHtlm .= '</body></html>';

// return $sOutHtlm;


     $mpdf = new \Mpdf\Mpdf();
         //  $mpdf->forcePortraitMargins = true;

     $mpdf->WriteHTML($sOutHtlm);
     $mpdf->Output('../tmp/kviitung'.$in['ordnr'].'.pdf' , 'F');

    return 'kviitung'.$in['ordnr'].'.pdf';

}


}


?>
