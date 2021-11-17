<?php
    require_once '../1custdata/settings.php';
    require_once '../funcont.php';
    require_once '../database.php';
    require_once  '../vendor/autoload.php';
    require_once '../1custdata/arveform.php';




         if (  (isset ($_REQUEST['docid'])) && ( strlen($_REQUEST['docid'])>0 )    )
         {
             $my_set = new Obstock_Settings();



              $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );
              $aDocDetails = $my_db->GetDocuments ( -1, $_REQUEST['docid'],'',0,0 );
              $aDocRowsDetails = $my_db->GetDocumentRows ( $_REQUEST['docid'], $my_set->serialnumber, $aDocDetails[0]['CUSTOMER_ID'] );

              $arveForm = new ArveForm();

              $arveForm->setData( $aDocDetails[0],  $aDocRowsDetails );

              $sOutHtlm = $arveForm->getHtml ();


  $mpdf = new \Mpdf\Mpdf();
      //  $mpdf->forcePortraitMargins = true;

     $mpdf->WriteHTML($sOutHtlm);


    if ( ( isset( $aDocDetails[0]['DOCNUMBER']) ) && ( strlen($aDocDetails[0]['DOCNUMBER'])>0 ) )

       $sFileName = $arveForm->sFilePref.GetDocTypeNameForFile( $aDocDetails[0]['DOCTYPE'] ).safeForFileName( $aDocDetails[0]['DOCNUMBER']).'.pdf';
    else
       $sFileName = $arveForm->sFilePref.GetDocTypeNameForFile( $aDocDetails[0]['DOCTYPE'] ).'_st'.$aDocDetails[0]['ID'].'.pdf';





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
