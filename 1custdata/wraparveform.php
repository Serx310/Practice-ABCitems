<?php
  require_once '../1custdata/settings.php';
  require_once '../funcont.php';
  require_once '../database.php';
  require_once  '../vendor/autoload.php';
  require_once '../1custdata/arveform.php';

  $my_set = new Obstock_Settings();

   $docid = 15;

   $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );
   $aDocDetails = $my_db->GetDocuments ( -1, $docid );
   $aDocRowsDetails = $my_db->GetDocumentRows ( $docid, $my_set->serialnumber );




   $arveForm = new ArveForm();

   $arveForm->setData( $aDocDetails[0],  $aDocRowsDetails );

   echo  $arveForm->getHtml ();



?>
