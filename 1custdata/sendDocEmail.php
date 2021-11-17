<?php

    require '../PHPMailerAutoload.php';
    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../database.php';



/*
 $sMailHost = 'smtp.zone.ee';
  $sMailPort = 1025;
  $sMailUser = 'info@kassa.ee';
  $sMailPassword = '';

  $sMailFromEmail = 'info@kassa.ee';
  $sMailFromName = 'Esimene Firma OÜ';

  */
  $sMailHost = 'localhost';
  $sMailPort = 25;
  $sMailUser = '1.firma@kassa.ee';
  $sMailPassword = 'H6xq(,itA/_e#+rSW4m';

  $sMailFromEmail = '1.firma@kassa.ee';
  $sMailFromName = 'Esimene Firma OÜ';



     if (  (isset ($_REQUEST['docid'])) && ( strlen($_REQUEST['docid'])>0 )    )
     {
             $my_set = new Obstock_Settings();
             $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database ,      $my_set->table_preffix );

             require_once( './lang/lang'.$my_set->lang.'.php' );

              $myLang = new OBLang();

              $aDocDetails = $my_db->GetDocuments ( -1, $_REQUEST['docid'] );

              $sFilePref = "";
              if ( $aDocDetails[0]['DOCTYPE'] < 10 ) $sFilePref = "in_";
              else if ( ( $aDocDetails[0]['DOCTYPE'] > 9 ) && ( $aDocDetails[0]['DOCTYPE'] < 20 ) ) $sFilePref = "";
              else if  ( $aDocDetails[0]['DOCTYPE'] == 20 )$sFilePref = "";
              else if  ( $aDocDetails[0]['DOCTYPE'] == 30 )  $sFilePref = "ord_";
              else $sFilePref = "";
                 




              if ( ( isset( $aDocDetails[0]['DOCNUMBER']) ) && ( strlen($aDocDetails[0]['DOCNUMBER'])>0 ) )

                 $sFileName = $sFilePref.GetDocTypeNameForFile( $aDocDetails[0]['DOCTYPE'] ).safeForFileName( $aDocDetails[0]['DOCNUMBER']).'.pdf';
              else
                 $sFileName = $sFilePref.GetDocTypeNameForFile( $aDocDetails[0]['DOCTYPE'] ).'_st'.$aDocDetails[0]['ID'].'.pdf';






               $mail = new PHPMailer;

           //$mail->SMTPDebug = 3;

          $mail->isSMTP();
          $mail->CharSet = "UTF-8";
          $mail->Host = $sMailHost;
          $mail->SMTPAuth = false;                           //  $mail->SMTPAuth = true;   true v kontore    false na saite
           $mail->Username = $sMailUser;
          $mail->Password = $sMailPassword;
          $mail->SMTPSecure = 'none';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $sMailPort;                                    // TCP port to connect to

          $mail->From = $sMailFromEmail;
          $mail->FromName = $sMailFromName;


          if (  (isset ($_REQUEST['em'])) && ( strlen($_REQUEST['em'])>0 )  )
          {
              $sToMail = $_REQUEST['em'];
          }
          else
          {
              $sToMail = $aDocDetails[0]['EMAIL'];
          }


          $mail->addAddress( $sToMail, $aDocDetails[0]['CUSTNAME'] );



          $mail->addReplyTo( 'info@kassa.ee', 'Esimene Firma OÜ');
         //$mail->addCC('info@kassa.ee');
           $mail->addBCC('info@kassa.ee');





           $mail->addAttachment( '../tmp/'.$sFileName  );         // Add attachments


            $mail->isHTML(true);                                  // Set email format to HTML




             $mail->Subject = 'Arve';
             $mail->Body    = '<html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /></head>Arve '.$sFileName.' lisatud!</html>';
             $mail->AltBody = 'Arve lisatud '.$sFileName ;

             if(!$mail->send()) {

                 $arr = array('id' => 1, 'mes' => 'Viga!  '.$mail->ErrorInfo  );
             } else {
                  $arr = array('id' => 0, 'mes' => $myLang->sendto.' '.$sToMail.' !'  );
             }

             $my_db->close();
      }
      else  $arr = array('id' => 2, 'mes' => 'Puudub id  '  );

      echo json_encode($arr);
?>
