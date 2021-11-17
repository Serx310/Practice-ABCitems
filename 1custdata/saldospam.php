<?php
    require '../PHPMailerAutoload.php';
    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../tools/tdatabase.php';

// ******************************************************************


  $sSinglePrefix = '<p>Tere,<p>Meie andmetel on Teil tasumata maksetähtaja ületanud arve. Ootame tasumist!';
  $sPrefix = '<p>Tere,<p>Meie andmetel on Teil tasumata maksetähtaja ületanud arved. Ootame tasumist!';
  $sSuffix = '<p>Tervitades,<br>Vladimir Rudkov<br>Esimene Firma OÜ<br><a href="www.kassa.ee" >www.kassa.ee</a>';

  $sMailHost = 'smtp.zone.ee';
  $sMailPort = 1025;
  $sMailUser = 'info@kassa.ee';
  $sMailPassword = '3F1ks1dl4p';

  $sMailFromEmail = 'info@kassa.ee';
  $sMailFromName = 'Esimene Firma OÜ';



// ****************************************************************************************
// ****************************************************************************************
// ****************************************************************************************

      $my_set = new Obstock_Settings();
      $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );


echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="./html/default.css" type="text/css">

<title>dolgi</title>
</head><body>';




       $timestamp = time();

      $aSaldoList =  $my_db->GetCustDebtList ( 1, $_REQUEST['custid'] );


      if ( $aSaldoList['count'] > 0 )
      {

            $iNeedSpam = 0;
            $iBadSaldo = 0;
            $iSaldo = 0;

            $aFiles['count']= 0;

            $sPrevArveNr="-1";


            $sTable =  '<p><table border="1"><tr><td align="center" width="80" ><b>Arve Nr</b></td><td align="center" width="120" ><b>Kuup�ev</b></td><td align="center" width="80" ><b>Summa</b></td><td align="center" width="120"><b>T�htaeg</b></td> <td align="center" width="80"><b>�le t�htaja</b></td><td align="center" width="80"><b>Tasumata</b></td> </tr>';


            for ( $i=0 ; $i< $aSaldoList['count']; $i++  )
            {

                 if(  $sPrevArveNr != $aSaldoList[$i]['TICKETID'] )
                 {
                   $sPrevArveNr = $aSaldoList[$i]['TICKETID'];

                 $timecanwait = strtotime($aSaldoList[$i]['DEBTDATE'] ) + ($aSaldoList[$i]['DUEDAYS'] +3 )*24*60*60;

                 $iSaldo =  $iSaldo + ( $aSaldoList[$i]['DEBIT_AMOUNT'] - $aSaldoList[$i]['PAIDSUM'] );

                if  ( $timecanwait < $timestamp )
                {
                       $iNeedSpam ++;
                       $iBadSaldo = $iBadSaldo  + ( $aSaldoList[$i]['DEBIT_AMOUNT'] - $aSaldoList[$i]['PAIDSUM'] );

                       $iBadDays = (int) ( ($timestamp - strtotime($aSaldoList[$i]['DEBTDATE'] ) ) / (24*60*60));
                 }

                 $sTable .=  '<tr><td align="center">'.$aSaldoList[$i]['TICKETID'].'</td><td align="center">&nbsp;'. date("d.m.Y",strtotime($aSaldoList[$i]['DEBTDATE'] ) ).'&nbsp;</td><td align="right">'.MyHind( $aSaldoList[$i]['DEBIT_AMOUNT']).'&nbsp;</td><td align="center">&nbsp;'.date("d.m.Y", ( strtotime($aSaldoList[$i]['DEBTDATE'] ) + $aSaldoList[$i]['DUEDAYS']*24*60*60   ) ) .'&nbsp;</td> <td  align="right" >'.$iBadDays.'</td> <td  align="right" >'.MyHind(($aSaldoList[$i]['DEBIT_AMOUNT'] - $aSaldoList[$i]['PAIDSUM'] )).'&nbsp;</td>  </tr>';

                 $sFileName = 'D:/1f/doc/'.date("Y",strtotime($aSaldoList[$i]['DEBTDATE'] ) ).'/'.date("m",strtotime($aSaldoList[$i]['DEBTDATE'] ) ).'/arve'.$aSaldoList[$i]['TICKETID'].'.pdf';

                 if ( file_exists( $sFileName ) )
                 {
                          $aFiles[$aFiles['count']] ['fname']= $sFileName;
                          $aFiles['count'] ++;
                 }
                 else
                 {
                      echo "File ".$sFileName." NOT FOUND!<br>";
                 }
                  }

            }

             $sTable .=  '<tr><td colspan="5" align="right" >Kokku:&nbsp;</td><td  align="right">'.MyHind($iSaldo).'&nbsp;</td>  </tr>';
             $sTable .=  '</table>';


             if ( $iNeedSpam > 1 )   $sMessageBody = $sPrefix ;
             else  $sMessageBody = $sSinglePrefix;

             $sMessageBody .=  $sTable ;
             $sMessageBody .=  $sSuffix ;


             echo  utf8_encode( $sMessageBody );

             echo  '<br><br>';


      if ( $iNeedSpam > 0 )
      {

          $mail = new PHPMailer;
          $mail->CharSet = "UTF-8";
        //  $mail->Encoding = "16bit";

           //$mail->SMTPDebug = 3;                               // Enable verbose debug output

          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = $sMailHost;  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $sMailUser;                 // SMTP username
          $mail->Password = $sMailPassword;                           // SMTP password
          $mail->SMTPSecure = 'none';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $sMailPort;                                    // TCP port to connect to

          $mail->From = $sMailFromEmail;
          $mail->FromName = $sMailFromName;


        //    $mail->addAddress($aSaldoList[0]['EMAIL'], $aSaldoList[0]['NAME'] );     // Add a recipient

            $mail->addAddress('info@kassa.ee','mm');

             //if ( ( isset( $aEmail['email2'] ) ) && ( strlen( $aEmail['email2'] ) > 3 ) ) $mail->addAddress( $aEmail['email2'] );               // Name is optional

             $mail->addReplyTo( $sMailFromEmail, $sMailFromName );
             //$mail->addCC('info@kassa.ee');
             $mail->addBCC($sMailFromEmail);

             for ( $i=0; $i < $aFiles['count']; $i ++)  $mail->addAttachment( $aFiles[$i]['fname']  );         // Add attachments
         ///$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
             $mail->isHTML(true);                                  // Set email format to HTML




             $mail->Subject = 'Meeldetuletus, tasumata arve(d)';
             $mail->Body    = '<html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /></head><body>'.$sMessageBody.'</body></html>';
             $mail->AltBody = 'Tere,\nMeie andmetel on Teil tasumata makset�htaja �letanud arve. Ootame tasumist! ';

             if(!$mail->send()) {
                echo 'Message   could not be sent.<br>';
                echo 'Mailer Error: ' . $mail->ErrorInfo.' <br>';
             } else {
                echo 'Message  has been sent<br>';
             }
          }
       }

   echo '</body></html>';

     $my_db->close();

?>
