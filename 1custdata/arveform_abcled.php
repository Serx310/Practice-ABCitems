<?php
    require_once __DIR__.'/../funcont.php';

/// albamare

class ArveForm {

  var $m_aBotText = array();
  var $m_aCommentText = array();
  ////  ***************  prepareMyData () *************************************


  var $m_aDocDetails = array();
  var $m_aDocRowsDetails = array();
  var $m_aDocVatDetails = array();

  var $m_aPayDetails = array();

  var $m_docdate = '';

  var $sFirma = "Maksja:";
  var $sFilePref = "";
  var $sFirmaName = "";
  var $payCondDesc = 'Maksetingimused:';
  var $payCond = "";
  var $sRegNrDesc = 'Reg.nr.:';
  var $sRegNr  = "";
  var $payDayDesc = 'Tähtaeg:';
  var $payDay = '';

  var $m_sDocName;

  var $m_sDocDateDesc;

  var $m_iShowCode = 2; // 0-no, 1 long, 2 shot
  var $m_iShowBarcode = 0; // 0-no, 1 long, 2 shot

  var $m_logoimage;

  var $m_KoodHeader;
  var $m_RibakoodHeader;
  var $m_NimetusHeader;
  var $m_PriceHeader;
  var $m_KogusHeader;
  var $m_SummaHeader;




   function setData ( $aH, $aR )
   {
       $this->m_aDocDetails = $aH;
       $this->m_aDocRowsDetails = $aR;

   }


   function prepareMyData ()
   {

     $this->m_aBotText[1] = 'ABCLED OÜ';
     $this->m_aBotText[2] = 'Telefon +372 58 28 8084';
     $this->m_aBotText[3] = 'Pank: Swedbank';

     $this->m_aBotText[4] = 'Hellerheina tee 27, Maardu 74117';
     $this->m_aBotText[5] = 'e-mail: abcled24@gmail.com';
     $this->m_aBotText[6] = 'IBAN: EE072200221054142803';

     $this->m_aBotText[7] = 'Reg. nr: 11147156';
     $this->m_aBotText[8] = 'E-pood: www.abcled.ee';
     $this->m_aBotText[9] = 'SWIFT/BIC: HABAEE2X';

     $this->m_aBotText[10] = 'KMKR nr.EE101738077';
     $this->m_aBotText[11] = '';
     $this->m_aBotText[12] = '';



    $this->m_logoimage =  'pics/img_0_0_3.jpg';  // images/tat.svg



     $this->m_aCommentText[1] = "";
     $this->m_aCommentText[2] = "";

     $this->m_iShowCode = 2; // 0-no, 1 long, 2 shot
     $this->m_iShowBarcode = 0; // 0-no, 1 long, 2 shot

     $this->m_KoodHeader='Kood';
     $this->m_RibakoodHeader='Ribakood';
     $this->m_NimetusHeader='Kauba nimetus';
     $this->m_PriceHeader='Hind';
     $this->m_KogusHeader='Kogus';
     $this->m_SummaHeader='Summa';



   }

   function  prepateHeader ()
   {

     $this->sFirma = "Maksja:";
     $this->sFilePref = "";
     $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
     $this->payCondDesc = 'Maksetingimused:';
     $this->payCond = $this->m_aDocDetails['DUEDAYS'].' päeva';
     $this->sRegNrDesc = 'Reg.nr.:';
     $this->sRegNr  = $this->m_aDocDetails['TAXID'];
     $this->payDayDesc = 'Tähtaeg:';
     $this->payDay = '';

     $this->m_sDocDateDesc = 'Arve kuupäev';

     $this->m_sDocName = GetDocTypeName( $this->m_aDocDetails['DOCTYPE'] ).' nr.';


     $this->m_aPayDetails[0] = '';
     $this->m_aPayDetails[1] = '';
     $this->m_aPayDetails[2] = '';
     $this->m_aPayDetails[3] = '';

     if ( isset ( $this->m_aDocDetails['DOCDATE'] ) )  $this->m_docdate = MyDate2($this->m_aDocDetails['DOCDATE']);
     else   $this->m_docdate = MyDate2($this->m_aDocDetails['REGDATE']) ;

       $dateArray = explode(".", $this->m_docdate );

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
      $this->m_sDocDateDesc = 'Kuupäev';

      $this->m_aPayDetails[0] = 'Selgitus: Arve '.( $this->m_aDocDetails['DOCNUMBER'] );
      $this->m_aPayDetails[1] = 'Makse saaja: '.$this->m_aBotText[1];
      $this->m_aPayDetails[2] = 'Swedbank, IBAN &nbsp;'.$this->m_aBotText[6];
      $this->m_aPayDetails[3] = 'Makseaeg: '.$this->m_aDocDetails['DUEDAYS'].' päeva';



   }
   else if ( ( $this->m_aDocDetails['DOCTYPE'] > 9 ) && ( $this->m_aDocDetails['DOCTYPE'] < 20 ) )
   {
     $this->sFirma = "Maksja:";
     $this->sFilePref = "";
     $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
     $this->payCondDesc = 'Maksetingimused:';
     $this->payCond = $this->m_aDocDetails['DUEDAYS'].' päeva';
     $this->sRegNrDesc = 'Reg.nr.:';
     $this->sRegNr  = $this->m_aDocDetails['TAXID'];
     $this->payDayDesc = 'Tähtaeg:';
     $this->payDay = date("d.m.Y", ( mktime(0, 0, 0, $month, $day, $year)  + ( 60*60*24* $this->m_aDocDetails['DUEDAYS'] ) )  );
     $this->m_sDocDateDesc = 'Arve kuupäev';

     $this->m_aPayDetails[0] = '';
     $this->m_aPayDetails[1] = '';
     $this->m_aPayDetails[2] = '';
     $this->m_aPayDetails[3] = '';


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
     $this->m_sDocDateDesc = 'Kuupäev';

   }
   else if  ( $this->m_aDocDetails['DOCTYPE'] == 30 )
   {
     if ( ( isset ( $this->m_aDocDetails['COUNTRY'] ) ) && ( strlen( $this->m_aDocDetails['COUNTRY'] )>0  ) )
     {  // engl
       $this->sFirma = "Supplier:";
       $this->sRegNrDesc = 'Firma.id.:';
       $this->m_sDocDateDesc = 'Order date';
       $this->m_sDocName = 'Order no';

       $this->m_KoodHeader='Code';
       $this->m_RibakoodHeader='Barcode';
       $this->m_NimetusHeader='Item name';
       $this->m_PriceHeader='';
       $this->m_KogusHeader='Quantity';
       $this->m_SummaHeader='';

     }
     else
     {
       $this->sFirma = "Hankija:";
       $this->sRegNrDesc = 'Reg.nr.:';
       $this->m_sDocDateDesc = 'Tellimuse kuupäev';


       $this->m_PriceHeader='';
       $this->m_SummaHeader='';


     }

     $this->sFilePref = "ord_";
     $this->sFirmaName = $this->m_aDocDetails['CUSTNAME'];
     $this->payCondDesc = '';
     $this->payCond = ' ';
     $this->sRegNr  = $this->m_aDocDetails['TAXID'];
     $this->payDayDesc = '';
     $this->payDay = '';



     $this->m_docdate = MyDate2($this->m_aDocDetails['REGDATE']) ;
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
      $this->m_sDocDateDesc = 'Kuupäev';

     $this->m_aPayDetails[0] = 'Selgitus: '.GetDocTypeName( $this->m_aDocDetails['DOCTYPE'] ).' '.( $this->m_aDocDetails['DOCNUMBER'] );
     $this->m_aPayDetails[1] = 'Makse saaja: '.$this->m_aBotText[1];
     $this->m_aPayDetails[2] = 'Swedbank, IBAN &nbsp;'.$this->m_aBotText[6];
     $this->m_aPayDetails[3] = 'Makseaeg: '.$this->m_aDocDetails['DUEDAYS'].' päeva';



   }


   }


   function  prepateVatInfo ()
   {
        $this->m_aDocVatDetails = array();
        $this->m_aDocVatDetails['count'] = 0;

        for ( $i=0; $i <  $this->m_aDocRowsDetails['count']; $i++   )
        {
           if ( $this->m_aDocDetails['TAXTYPE'] == 2 ) $this->addVatInfo ( $this->m_aDocRowsDetails[$i]['TAXRATE'], ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] * $this->m_aDocRowsDetails[$i]['UNITS'] ) , ( ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] * $this->m_aDocRowsDetails[$i]['UNITS'] ) * $this->m_aDocRowsDetails[$i]['TAXRATE'] )  );
           else if ( $this->m_aDocDetails['TAXTYPE'] == 1 )  $this->addVatInfo ( $this->m_aDocRowsDetails[$i]['TAXRATE'], ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] * $this->m_aDocRowsDetails[$i]['UNITS'] ) / (1.0 + $this->m_aDocRowsDetails[$i]['TAXRATE'] ) , ( ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] * $this->m_aDocRowsDetails[$i]['UNITS'] ) - ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] * $this->m_aDocRowsDetails[$i]['UNITS'] ) / (1.0 + $this->m_aDocRowsDetails[$i]['TAXRATE'] )  )  );
           else $this->addVatInfo ( $this->m_aDocRowsDetails[$i]['TAXRATE'], ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] * $this->m_aDocRowsDetails[$i]['UNITS'] )  , 0 );
        }
   }

   function addVatInfo ( $Rate, $Net, $Vat )
   {
      $iFound = 0;

      for ( $i = 0; $i < $this->m_aDocVatDetails['count'] ; $i ++)
      {
         if (  $this->m_aDocVatDetails[$i]['RATE'] == $Rate )
         {
              $this->m_aDocVatDetails[$i]['NET'] += $Net;
              $this->m_aDocVatDetails[$i]['VAT'] += $Vat;
              $iFound = 1;
              $i = $this->m_aDocVatDetails['count'];
         }

      }

      if ( $iFound == 0 )
      {

           $this->m_aDocVatDetails[ $this->m_aDocVatDetails['count'] ]['RATE'] = $Rate;
           $this->m_aDocVatDetails[ $this->m_aDocVatDetails['count'] ]['NAME'] = 'K&auml;ibemaks '.( $Rate *100).'% ';
           $this->m_aDocVatDetails[ $this->m_aDocVatDetails['count'] ]['VAT'] = $Vat;
           $this->m_aDocVatDetails[ $this->m_aDocVatDetails['count'] ]['NET'] = $Net;

           $this->m_aDocVatDetails['count']++;

      }

   }


  function getVatTable ( $w)
  {
     $this->prepateVatInfo ();

      $sSpan = '<span style="font-family: Arial; color: #000000; font-size: 12px;">';

       $sVatHtml = '<table style="width:'.$w.'px; border-collapse: collapse" cellpadding="3" cellspacing="0" border="1" bgcolor="white" >';

       $sVatHtml .= '<tr align="center"><td>'.$sSpan.'Netto EUR</span></td>
                                        <td>'.$sSpan.'KM %</span></td>
                                        <td>'.$sSpan.'KM summa</span></td>
                                        <td>'.$sSpan.'Brutto EUR</span></td></tr>';

       for ( $i=0; $i< $this->m_aDocVatDetails['count'] ; $i++ )
       {

         $sVatHtml .= '<tr><td align="right">'.$sSpan.MyHind( $this->m_aDocVatDetails[$i]['NET'], 2).'</span></td>';
         $sVatHtml .= '<td>'.$sSpan.$this->m_aDocVatDetails[$i]['NAME'].'</span></td>';
         $sVatHtml .= '<td align="right">'.$sSpan.MyHind( $this->m_aDocVatDetails[$i]['VAT'], 2).'</span></td>';
         $sVatHtml .='<td align="right" >'.$sSpan.MyHind( ($this->m_aDocVatDetails[$i]['NET'] +$this->m_aDocVatDetails[$i]['VAT'] ), 2).'</span></td></tr>';

     }


       $sVatHtml .= '</table>';

      return $sVatHtml;
  }


   function getHtml ()
   {
     $this->prepareMyData ();
     $this->prepateHeader ();

     $iSize = $this->m_aDocRowsDetails['count'];

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
       <td colspan="3" rowspan="5 " style="padding-left: 20px;" ><img src="'.$this->m_logoimage.'" style="width: '.($w[2]+$w[3]+$w[4]-21).'px" alt=""/></td>
       <td colspan="11"><img alt="" src="pics/px" style="width: '.($w[5]+$w[6]+$w[7]+$w[8]+$w[9]+$w[10]+$w[11]+$w[12]+$w[13]+$w[14]+$w[15]).'px; height: 11px;"/></td>
     </tr>';




      $sOutHtlm .= '<tr valign="top">

        <td colspan="2"><img alt="" src="pics/px" style="width: '.( $w[0]+$w[1] ).'px; height: 18px;"/></td>

        <td colspan="4"><img alt="" src="pics/px" style="width: '.( $w[5]+$w[6]+$w[7]+$w[8]).'px; height: 18px;"/></td>
       <td colspan="5" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 12px; font-weight: bold;">'.$this->m_sDocName.': '.( $this->m_aDocDetails['DOCNUMBER'] ).'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14] + $w[15]).'px; height: 18px;"/></td>
        </tr>';




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
         <td colspan="6" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">'. $this->m_sDocDateDesc.': '.$this->m_docdate.'</span></p></td>
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
       <td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">'.$this->sFirma.':&nbsp;</span></p></td>
       <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ( $this->m_aDocDetails['CUSTNAME'] ).'</span></p></td>
       <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">'.$this->m_aPayDetails[0].'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
        </tr>';

        $sOutHtlm .= '<tr valign="top">
       <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
       <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($this->m_aDocDetails['ADDRESS']).'</span></p></td>
       <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">'.$this->m_aPayDetails[1].'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
       </tr>';

       $sOutHtlm .= '<tr valign="top">
       <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]).'px; height: 16px;"/></td>
       <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($this->m_aDocDetails['ADDRESS2']).'</span></p></td>
       <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aPayDetails[2].'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
       </tr>';

       $sOutHtlm .= '<tr valign="top">
       <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 16px;"/></td>
       <td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">'.$this->sRegNrDesc.'&nbsp;</span></p></td>
       <td colspan="7" ><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($this->m_aDocDetails['TAXID']).'</span></p></td>
       <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aPayDetails[3].'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
       </tr>';

       $sOutHtlm .= '<tr valign="top">
          <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 11px;"/></td>
        </tr>';


        if ( strlen( $this->m_aDocDetails['DCOMMENT']) > 0 ) $sOutHtlm .= '<tr valign="top">
           <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
           <td colspan="2" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px; font-weight: bold;">Märkused:&nbsp;</span></p></td>
           <td colspan="12" ><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">&nbsp;'. ($this->m_aDocDetails['DCOMMENT']).'</span></p></td>
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

           <td colspan="2"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">'.$this->m_KoodHeader.'</span></p></td>

           <td><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">'.$this->m_RibakoodHeader.'</span></p></td>

           <td colspan="6"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">'.$this->m_NimetusHeader.'</span></p></td>

           <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">'.$this->m_PriceHeader.'</span></p></td>

           <td  style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">'.$this->m_KogusHeader.'</span></p></td>
           <td  style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px; font-weight: bold;">'.$this->m_SummaHeader.'</span></p></td>
           <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 14px;"/></td>
         </tr>
         <tr valign="top">
            <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
         </tr>'.$sHtmlLine.'<tr valign="top">
            <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 2px;"/></td>
         </tr>';


         $iRowsHeight = 0;



           for ( $i = $aLKdata[$z]['start']; ( $i < $this->m_aDocRowsDetails['count'] )&& ( $i < $aLKdata[$z]['stop'] )  ;  $i++ )
           {

             $sOutHtlm .= '<tr valign="top">
              <td><img alt="" src="pics/px" style="width: '.$w[0].'px; height: 13px;"/></td>
              <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #848484; font-size: 11px;">'.( $i+1 ).'&nbsp;</span></p></td>';

             if ( $this->m_aDocDetails['DOCTYPE'] == 30 )  $sOutHtlm .= '<td colspan="2"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'. ( $this->m_aDocRowsDetails[$i]['SUPCODE'] ).'</span></p></td>';
             else  $sOutHtlm .= '<td colspan="2"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'. ( $this->m_aDocRowsDetails[$i]['CODE'] ).'</span></p></td>';


               $sOutHtlm .= '<td><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'. ( $this->m_aDocRowsDetails[$i]['BARCODE'] ).'</span></p></td>

              <td colspan="6" style="white-space: nowrap;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;white-space: nowrap;">'. ( $this->m_aDocRowsDetails[$i]['NAME'] ).'</span></p></td>';

              if ( $this->m_aDocDetails['DOCTYPE'] == 30 )  $sOutHtlm .= '<td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;"></span></p></td>';
              else $sOutHtlm .= '<td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $this->m_aDocRowsDetails[$i]['DOCPRICE'] ).'</span></p></td>';

              $sOutHtlm .= '<td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $this->m_aDocRowsDetails[$i]['UNITS'] ).'</span></p></td>';

              if ( $this->m_aDocDetails['DOCTYPE'] == 30 ) $sOutHtlm .= '<td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;"></span></p></td>';
              else  $sOutHtlm .= '<td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $this->m_aDocRowsDetails[$i]['UNITS'] * $this->m_aDocRowsDetails[$i]['DOCPRICE'] ) ).'</span></p></td>';

              $sOutHtlm .= '<td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 13px;"/></td>
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

        if ( ($z == $iLKcount) && ( $this->m_aDocDetails['DOCTYPE'] != 30 ) )
            {

     $sOutHtlm .= '<tr valign="top">
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 19px;"/></td>
       <td colspan="7"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Arve koostas</span></p></td>
       <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Kokku käibemaksuta:</span></p></td>

       <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $this->m_aDocDetails['NETAMOUNT'] ).'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td>
     </tr> ';

       $sOutHtlm .= '<tr valign="top">
       <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
       <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Käibemaks 20%:</span></p></td>
       <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( ( $this->m_aDocDetails['DOCAMOUNT'] - $this->m_aDocDetails['NETAMOUNT'] ) ).'</span></p></td>
       <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[14]+$w[15]).'px; height: 19px;"/></td>
     </tr>';


         $sOutHtlm .= '<tr valign="top">
           <td colspan="9"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]).'px; height: 19px;"/></td>
           <td colspan="4" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">Summa kokku:</span></p></td>
           <td style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 11px;">'.MyHind ( $this->m_aDocDetails['DOCAMOUNT']  ).'</span></p></td>
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
            <td colspan="11"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 9px;">'.$this->m_aCommentText[1].'</span></p></td>
             <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
          </tr>
         <tr valign="top">
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
            <td colspan="11"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 9px;">'.$this->m_aCommentText[2].'</span></p></td>
             <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
         </tr>

     <tr valign="top"><td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 20px;"/></td></tr>'.$sHtmlLine;

      $sOutHtlm .= '<tr valign="top">
                         <td colspan="16"><img alt="" src="pics/px" style="width: '.$gw.'px; height: 3px;"/></td>
          </tr>
         <tr valign="top">
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
            <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[1].'</span></p></td>
            <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[2].'</span></p></td>
            <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[3].'</span></p></td>
            <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
         </tr>

         <tr valign="top">
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
            <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[4].'</span></p></td>
            <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[5].'</span></p></td>
            <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[6].'</span></p></td>
            <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
         </tr>

         <tr valign="top">
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
            <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[7].'</span></p></td>
            <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[8].'</span></p></td>
            <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[9].'</span></p></td>
            <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
         </tr>';

        $sOutHtlm .= '<tr valign="top">
            <td colspan="2"><img alt="" src="pics/px" style="width: '.($w[0]+$w[1]).'px; height: 12px;"/></td>
            <td colspan="3"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[10].'</span></p></td>
            <td colspan="5" style="text-align: center;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[11].'</span></p></td>
            <td colspan="3" style="text-align: right;"><p style="overflow: hidden; line-height: 1.0; text-indent: 0px; "><span style="font-family: Arial; color: #000000; font-size: 10px;">'.$this->m_aBotText[12].'</span></p></td>
            <td colspan="3"><img alt="" src="pics/px" style="width: '.($w[13]+$w[14]+$w[15]).'px; height: 12px;"/></td>
         </tr>';


        $sOutHtlm .= '</table>';

           if ($z<$iLKcount)   $sOutHtlm .= '<pagebreak />';

         }// end page

        $sOutHtlm .= '</body></html>';



       return $sOutHtlm;

   }



}

?>
