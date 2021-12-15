<?php
    require_once './1custdata/settings.php';
    require_once 'funcont.php';
    require_once 'databaseABC.php';
    require_once 'itemform.php';



    ini_set("session.use_trans_sid", true );
         session_name("miskus");
         session_start();
         print_r($_REQUEST);

        if  (!isset($_SESSION['USERCODE']))
        {
           $loginForm =  MyReadFile("./html/loginform.html");

            echo  ( $loginForm );
            return;
        }
        else
        {

        $my_set = new Obstock_Settings();

        require_once( './lang/lang'.$my_set->lang.'.php' );

        $iShowSubGroup = 0;

        $myLang = new OBLang();

        $my_db =  new myDB( $my_set->host, $my_set->username,  $my_set->password , $my_set->database , $my_set->table_preffix );

        $sHead =  MyReadFile("./html/itemlist.html");
        echo   ( $sHead );

        //  print_r($_REQUEST) ;

        echo '<a href="index.php">'.$myLang->main.'</a><br><br>';

       if (  ( isset($my_set->showplace)) &&  ( $my_set->showplace == 1 ) ) $iShowPlace = 1;
       else $iShowPlace = 0;

        if (  ( isset($my_set->bron)) &&  ( $my_set->bron == 1 ) ) $iShowBron = 1;
        else $iShowBron = 0;


         $itemForm = new ItemForm();



         $aStockList = $my_db->GetStockList ();

         if ( isset( $_REQUEST['stockid'] ) ) $sTargetStock =  $_REQUEST['stockid'] ;
         else     $sTargetStock = "-1";

         if ( isset( $_REQUEST['sbysupcode'] ) && ( $_REQUEST['sbysupcode'] == 1 )  )
           $itemForm->m_iShowSuplCode=1;



         $itemForm->setStockList ( $aStockList , $sTargetStock ) ;

         $aGroupList = $my_db->GetGroupList ();
         if  ( !isset ( $_REQUEST['limit'] ) )  $_REQUEST['limit'] = 200 ;
         $itemForm->setGroupList ( $aGroupList,  $_REQUEST ) ;

        /////////////////////////////////////////////////////////////////
           $aBufferList = $my_db->GetBuffer ();

         if ( isset($_REQUEST['Bufid']) )  $iBufId =  $_REQUEST['Bufid'];
         else   $iBufId = -1;

         $itemForm->setBufferList ( $aBufferList , $iBufId) ;

         $itemForm->showAddInventLink ( 1 );

         echo $itemForm->getHTML ( $myLang , $_REQUEST, "itemlistABC.php" );




         $iItemSearchVersion = 0;
         $sWhere = "";
         $sOrderBy = "";

         if ( strlen($itemForm->m_sWhere) >0 ) { $sWhere = ' where 1=1 '.$itemForm->m_sWhere;  $iItemSearchVersion = 3; }




          $aItemsDetails = $my_db->GetKaubad (null , $iItemSearchVersion , $sWhere, $sOrderBy, $itemForm->m_sLocation , $iBufId, $iShowPlace, $iShowBron,  0, -1,  $itemForm->m_iLimit  );

          if ( isset ( $_REQUEST['sortby'] ) )    $iSortBy = $_REQUEST['sortby'];
          else                                    $iSortBy = 0;

          echo $itemForm->m_sInvParam;

          echo '<br> <br><br> <table align="left" border="1" cellpadding="3" cellspacing="0">';
          echo '<tr>';
            echo '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=0" >'.$myLang->Grupp.'</a></th>';
            echo '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=1" >'.$myLang->Nr.'</a></th>';
            echo '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=2" >'.$myLang->Ribakood. '</a></th>';
            echo  '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=3" >'.$myLang->supcode. '</a></th>';
            echo  '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=4" >'.$myLang->Nimetus.'</a></th>';
            echo '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=5" >'.$myLang->desc.'</a></th>';
          echo '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=6" >'.$myLang->Ost.'</a></th>';
          echo  '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=7" >'.$myLang->Hind.'</a></th>';
          echo  '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'&sortby=8" >'.$myLang->Laoseis.'</a></th>';

           if ( $my_set->iUnits == 1 ) echo '<th>'.$myLang->Yhik.'</th>';


            if ( $iShowBron == 1 )   echo '<th>'.$myLang->Bron.'</th><th>'.$myLang->Ostutellimus.'</th>';

            // if ( $iBufId> -1 ) {
            //   echo '<th><a href="buflist.php?bjnr='.$iBufId.'" target="_blank">'. ($itemForm->m_sBufComment).'</a></th>';
            // }

            if (  $iShowPlace ==1  )  echo '<th><a href="itemlistABC.php?'.$itemForm->m_sInvParam.'"sortby=0">'.$myLang->Paigutus.'</a></th>';
            echo '<th>'.$myLang->Pilt.'</th>';
            echo '</tr> ';


           for ( $i = 0; $i < $aItemsDetails['count']; $i++ )
           {
            //  echo '<tr><td><a href="groupcard.php?id='.$aItemsDetails[$i]['CATEGORY'].'"  target="_blank" >'. ($aItemsDetails[$i]['CATEGORYNAME']).'</a></td>';
            echo '<tr><td>'. ($aItemsDetails[$i]['CATEGORYNAME']).'</td>';
            //  echo '<td><a href="itemcard.php?id='.$aItemsDetails[$i]['ID'].'" style="text-decoration: none;" target="_blank" >'. ($aItemsDetails[$i]['REFERENCE']).'</a></td>';
              echo '<td>'. ($aItemsDetails[$i]['REFERENCE']).'</td>';
              echo '<td>'. ($aItemsDetails[$i]['CODE']).'</td>';
              echo '<td>'. ($aItemsDetails[$i]['HANKIJAKOOD']).'</td>';

              if ( isset ( $aItemsDetails[$i]['RETSITEM'] ) )  $sNclass = ' class="rets" ';
              else  $sNclass = '';

              echo '<td'.$sNclass.'>'. htmlspecialchars($aItemsDetails[$i]['NAME']).'</td>';
              $desc = $aItemsDetails[$i]['ProdDescription'];
              if(strlen($desc)>20){
                $desc = substr($desc, 0, 20).'...';
              }
              echo '<td>'.htmlspecialchars($desc).'</td>';
              echo '<td align="right">'.MyHind( $aItemsDetails[$i]['PRICEBUY']).'</td>';
              echo '<td align="right">'.MyHind($aItemsDetails[$i]['PRICESELL'] * (1.00 + $aItemsDetails[$i]['RATE'] )   ).'</td>';
              echo '<td align="right"><a href="stockcard.php?id='.$aItemsDetails[$i]['ID'].'&stock='.$itemForm->m_sLocation.'"  target="_blank" >'.MyHind( $aItemsDetails[$i]['UNITS'], 2 ).'</a></td>';


              // if ( $iBufId> -1 ) {
              //   echo '<td></td>';
              // }


              if (  $iShowPlace ==1  ) echo '<td>'. ($aItemsDetails[$i]['PLACE']).'</td>';


              /*
              {
                 if ( $aItemsDetails[$i]['BUFUNITS'] > 0 ) $sChecked = " checked ";
                 else $sChecked = "  ";

                 echo '<td> <input id="checkBox'.$aItemsDetails[$i]['REFERENCE'].'" type="checkbox" onchange="setlabel(\''.$aItemsDetails[$i]['REFERENCE'].'\', '.$iBufJNR.');" '.$sChecked.' autocomplete="off" > </td>';
              }

               */

               if(isset($aItemsDetails[$i]['IMAGECODE']) && strlen($aItemsDetails[$i]['IMAGECODE'])>0){
                 echo '<td> <img style="height:70px; width:auto" src="'  .getPrestoImageUrl ( $my_set->webserver, $aItemsDetails[$i]['IMAGECODE'] ) .'"/></td>';
               }else{
                 echo '<td> </td>';
               }


              echo '</tr>';
           }


            $iColSpan=8;
            if ( $my_set->iUnits == 1 ) $iColSpan++;
            if ( $iShowPlace == 1 ) $iColSpan++;
            if (   $iShowBron==1  )  $iColSpan=$iColSpan+2;

          echo '<tr><td colspan="'.$iColSpan.'">&nbsp;</td></tr></table>';




        echo '<br><br><br></body></html>' ;

          $my_db->close();

          }
?>
