<?php


class ItemForm {

var $m_sSelStock = "";
var $m_sSelGroup = array() ;
var $m_sSelBuffer = "" ;
var $m_sSelOrdBuffer = "";


var $m_sCBmultilevelChecked = "";
var $m_sInvParam = "1=1";
var $m_iShowAddInventLink = "0";
var $m_iGLlevels = 0;
var $m_sBufComment = "";

var $m_sLocation = "0";

var $m_iShowOrderBuf = 0;
var $m_iShowSuplCode = 0;

var $m_iLimit = 2000;

var $m_aGroupList;
var $m_sWhere = "";





function showAddInventLink ( $in )
{
   $this->m_iShowAddInventLink = $in ;
}

function setStockList ( $aStockList,  $sTargetStock )
{

   $this->m_sSelStock = '<select id="stockid" name="stockid"  >';

    if (  $aStockList['count'] > 1 )
    {
       $sSelected = "";

      if ( $sTargetStock == "-1"  )
      {
          $sSelected = " selected ";
          $this->m_sLocation = "-1";
          $this->m_sInvParam = "stockid=-1";
      }

      $this->m_sSelStock .= '<option value="-1" '.$sSelected.' >-All-</option>';
    }

      for ( $l=0 ; $l < $aStockList['count']; $l++ )
      {
        $sSelected = "";

        if ( $sTargetStock != "-1"  )
        {
            if ( $sTargetStock == $aStockList[$l]['id'] )
            {
                $this->m_sLocation = $aStockList[$l]['id'];
                $sSelected = " selected ";
                $this->m_sInvParam .= "&stockid=".$this->m_sLocation;
            }

        }

        $this->m_sSelStock .= '<option value="'.$aStockList[$l]['id'].'" '.$sSelected.' >'. ($aStockList[$l]['name']).'</option>';
      }
      $this->m_sSelStock .= '</select>';

}


function setGroupList  ( $aGroupList  ,  $req )
{
    if ( ( isset ( $req['limit'] ) )  && ( strlen($req['limit']) >0 ) )   $this->m_iLimit = $req['limit'] ;
    else  $this->m_iLimit = 2000;

    $this->m_aGroupList = $aGroupList ;

     if ( ( isset( $req['cb_multilevel'] ) ) && ( $req['cb_multilevel'] == "on" ) )
     {
        $this->m_sCBmultilevelChecked = "checked";
        $this->m_sInvParam .= "&cb_multilevel=on";
     }

      $this->m_iGLlevels = ( $this->m_aGroupList['levels'] -1);

      for ( $g = 0; $g < $this->m_iGLlevels; $g++ )
       {
            $this->m_sSelGroup[$g]  = '<select id="Group'.$g.'id" name="Group'.$g.'id"  onchange="groupchg( '.$g.', '.$this->m_aGroupList['levels'].' );" >';

            $sSelected = "";

            if ( isset( $req['Group'.$g.'id'] ) )
            {
                if ( $req['Group'.$g.'id'] =='0' ) $this->m_sSelGroup[$g] .= '<option value="0" selected >-All-</option>';
                else $this->m_sSelGroup[$g] .= '<option value="0" >-All-</option>';

                  $this->m_sInvParam  .= "&Group".$g."id=".$req['Group'.$g.'id'];
            }
            else    $this->m_sSelGroup[$g] .= '<option value="0" selected >-All-</option>';

            for ( $l=0 ; $l < $this->m_aGroupList['count']; $l++ )
            {
                $sSelected = "";

               if (   $this->m_aGroupList[$l]['level'] == $g   )
               {
                    if  ( isset( $req['Group'.$g.'id'] ) )  if ($req['Group'.$g.'id'] == $this->m_aGroupList[$l]['id'] )    $sSelected = " selected ";


                   if ( ( $g == 1 ) &&  ( isset( $req['Group0id'] ) ) &&  (  $req['Group0id'] != '0' )  )
                   {
                       if ( $this->m_aGroupList[$l]['parent']  == $req['Group0id'] )
                       {
                          $this->m_sSelGroup[$g] .= '<option value="'.$this->m_aGroupList[$l]['id'].'" '.$sSelected.' >'. ($this->m_aGroupList[$l]['name']).'</option>';
                          $this->m_aGroupList[$l]['infilter'] = 1;
                       }
                   }
                   else if ( ( $g > 1 ) &&  ( isset( $req['Group'.($g-1).'id'] ) ) &&  (  $req['Group'.($g-1).'id'] != '0' )  )
                   {
                       if ( $this->m_aGroupList[$l]['parent']  == $req['Group'.($g-1).'id'] )
                       {
                          $this->m_sSelGroup[$g] .= '<option value="'.$this->m_aGroupList[$l]['id'].'" '.$sSelected.' >'. ($this->m_aGroupList[$l]['name']).'</option>';
                          $this->m_aGroupList[$l]['infilter'] = 1;
                       }
                   }
                   else if ( $g > 1 )
                   {
                        for ( $m=0; $m < $this->m_aGroupList['count']; $m++ )
                        {
                             if (  ( $this->m_aGroupList[$m]['infilter'] == 1 )  && ( $this->m_aGroupList[$l]['parent']  == $this->m_aGroupList[$m]['id']  ) )
                             {
                                 $this->m_sSelGroup[$g] .= '<option value="'.$this->m_aGroupList[$l]['id'].'" '.$sSelected.' >'. ($this->m_aGroupList[$l]['name']).'</option>';
                                 $this->m_aGroupList[$l]['infilter'] = 1;
                                 $m = $this->m_aGroupList['count'];
                             }
                        }
                   }
                   else
                   {
                       $this->m_sSelGroup[$g] .= '<option value="'.$this->m_aGroupList[$l]['id'].'" '.$sSelected.' >'. ($this->m_aGroupList[$l]['name']).'</option>';
                       $this->m_aGroupList[$l]['infilter'] = 1;
                   }
               }

            }
            $this->m_sSelGroup[$g] .= '</select>';

       }
}


 function setBufferList ( $aBufferList , $iBufId )
 {
      $this->m_sBufComment = "";

        $this->m_sSelBuffer  = '<select id="Bufid" name="Bufid"  >';

        $sSelected = "";


       if ( $iBufId < 0 ) $this->m_sSelBuffer .= '<option value="-1" selected >---</option>';
       else $this->m_sSelBuffer .= '<option value="-1" >---</option>';

      for ( $l=0 ; $l < $aBufferList['count']; $l++ )
      {
         $sSelected = "";

        if ( $iBufId > -1 )
        {
            if ( $iBufId == $aBufferList[$l]['JNR'] )
            {  $sSelected = " selected ";
               $this->m_sBufComment =  $aBufferList[$l]['COMMENT'];
            }
        }

        $this->m_sSelBuffer .= '<option value="'.$aBufferList[$l]['JNR'].'" '.$sSelected.' >'. ($aBufferList[$l]['COMMENT']).'</option>';
      }
      $this->m_sSelBuffer .= '</select>';


 }


 function  setOrderBufferList   ( $aBufferList , $iOrdBufId )
 {
      $this->m_iShowOrderBuf = 1;

        $this->m_sSelOrdBuffer  = '<select id="OrdBufid" name="OrdBufid"  >';

        $sSelected = "";


       if ( $iOrdBufId < 0 ) $this->m_sSelOrdBuffer .= '<option value="-1" selected >---</option>';
       else $this->m_sSelOrdBuffer .= '<option value="-1" >---</option>';

      for ( $l=0 ; $l < $aBufferList['count']; $l++ )
      {
         $sSelected = "";

        if ( $iOrdBufId > -1 )
        {
            if ( $iOrdBufId == $aBufferList[$l]['JNR'] )
            {  $sSelected = " selected ";

            }
        }

        $this->m_sSelOrdBuffer .= '<option value="'.$aBufferList[$l]['JNR'].'" '.$sSelected.' >'. ($aBufferList[$l]['COMMENT']).'</option>';
      }
      $this->m_sSelOrdBuffer .= '</select>';


 }


  function getHTML ( $lang, $aReq, $sScriptPHP )
  {
    $sHtml = '<p><form action="'.$sScriptPHP.'" >
      <table border="1" cellpadding="3" cellspacing="0">
     <tr><td>'.$lang->Kood.':</td><td> <input type="text" name="code" value="'.((isset($aReq['code'] ))?$aReq['code']:"").'" length="20"> </td><td></td></tr>
     <tr><td>'.$lang->Ribakood.':</td><td> <input type="text" name="barcode" value="'.((isset($aReq['barcode'] ))?$aReq['barcode']:"").'" length="20"> </td><td></td></tr>';

     if( $this->m_iShowSuplCode == 1 )  $sHtml .= $this->getSupCodeHTML ( $lang, $aReq );

     $sHtml .= '<tr><td>'.$lang->Nimetus.':</td><td> <input type="text" name="pname" value="'.((isset($aReq['pname'] ))?$aReq['pname']:"").'" length="20"> </td><td></td></tr>';



     $sHtml .= '<tr><td>'.$lang->Grupp.':</td><td>'.$this->m_sSelGroup[0].'</td>
     <td><input id="cb_multilevel" name="cb_multilevel" type="checkbox" '.$this->m_sCBmultilevelChecked.' >multilevel</td></tr>';

            for ( $g = 1; $g < $this->m_iGLlevels ; $g++ )
            {
                $sHtml .= '<tr><td>'.$lang->SubGrupp.' '.$g.':</td><td>'.$this->m_sSelGroup[$g].'</td>
                  <td></td></tr>';

            }

     $sHtml .= '<tr><td>'.$lang->Ladu.':</td><td>'.$this->m_sSelStock.'</td><td><input type="submit" name="Otsi" value="'.$lang->Otsi.'"></td></tr>';


     $sHtml .= '<tr><td><a href="buflist.php" >'.$lang->Buffer.'</a>:</td><td>'.$this->m_sSelBuffer.'</td><td><input type="submit" name="OtsiBuf" value="'.$lang->Otsi.' ('.$lang->Buffer.')"></td></tr>';

    if ( $this->m_iShowOrderBuf == 1 )

     $sHtml .= '<tr><td>'.$lang->Buffer.':</td><td>'.$this->m_sSelOrdBuffer.'</td><td> </td></tr>';


     $sHtml .= '<tr><td>'.$lang->Limit.':</td><td> <input type="text" name="limit" value="'.$this->m_iLimit.'" length="20"> </td><td></td></tr>';


     $sHtml .= '</table></form></p>';

     if( $this->m_iShowAddInventLink == 1 )   $sHtml .= $this->getAddInvHTML ( $lang, $aReq );


     return $sHtml;
  }


  function getSupCodeHTML ( $lang, $aReq )
  {
      $sSChtml = '<tr><td>'.$lang->prcodes.':</td><td><input type="hidden" name="sbysupcode" value="1"> <input type="text" name="supcode" value="'.((isset($aReq['supcode'] ))?$aReq['supcode']:"").'" length="20"> </td><td></td></tr>';
      return $sSChtml;
  }



  function getAddInvHTML ( $lang, $aReq )
  {
     $this->m_sWhere = "";



     if  ( ( isset ($aReq['code']) ) && ( strlen ( $aReq['code'] )>0 ) )
     {
         $this->m_sWhere .= " and a.REFERENCE like '%".$aReq['code']."%' ";

         $this->m_sInvParam .= "&code=".$aReq['code'];
     }

     if  ( ( isset ($aReq['barcode']) ) && ( strlen ( $aReq['barcode'] )>0 ) )
     {
         $this->m_sWhere .= " and a.CODE like '%".$aReq['barcode']."%' ";

         $this->m_sInvParam .= "&barcode=".$aReq['barcode'];
     }

     if  ( ( isset ($aReq['pname']) ) && ( strlen ( $aReq['pname'] )>0 ) )
     {
         $this->m_sWhere .= " and a.NAME like '%".$aReq['pname']."%' ";

         $this->m_sInvParam .= "&pname=".$aReq['pname'];
     }

     if ( ( isset ($aReq['supcode']) ) && ( strlen ( $aReq['supcode'] )>0 ) )
     {
         $this->m_sWhere .= " and a.ID IN ( SELECT  hk.ID FROM PRCODES hk WHERE hk.CODE like '%".$aReq['supcode']."%' AND hk.CODELIST=0  ) ";

         $this->m_sInvParam .= "&sbysupcode=1&supcode=".$aReq['supcode'] ;
     }




     for ( $g=2; $g>-1; $g-- )
     {

       if  ( ( isset ($aReq['Group'.$g.'id']) ) && ( strlen ( $aReq['Group'.$g.'id'] )>0 ) && ( $aReq['Group'.$g.'id']!='0' )  )
       {
         if ( $this->m_sCBmultilevelChecked == "checked" )
         {
              $iSubGroup1Couunt = 0;
              $iSubGroup2Couunt = 0;

              for ( $l=0; $l < $this->m_aGroupList['count']; $l++ )
              {
                   if ( $this->m_aGroupList[$l]['parent'] == $aReq['Group'.$g.'id']  )
                   {
                      $aSubCategory1[ $iSubGroup1Couunt ] = $this->m_aGroupList[$l]['id'];
                      $iSubGroup1Couunt++;
                   }
              }

              for ( $i=0; $i < $iSubGroup1Couunt; $i++ )
              {
                  for ( $l=0; $l < $this->m_aGroupList['count']; $l++ )
                  {
                      if ( $this->m_aGroupList[$l]['parent'] ==  $aSubCategory1[ $i ]  )
                      {
                          $aSubCategory2[ $iSubGroup2Couunt ] = $this->m_aGroupList[$l]['id'];
                          $iSubGroup2Couunt++;
                      }
                  }
              }

             $this->m_sWhere .= " and a.CATEGORY in ( '".$aReq['Group'.$g.'id']."'";
             for ( $i=0; $i < $iSubGroup1Couunt; $i++ )  $this->m_sWhere .= ",'".$aSubCategory1[$i]."'";
             for ( $i=0; $i < $iSubGroup2Couunt; $i++ )  $this->m_sWhere .= ",'".$aSubCategory2[$i]."'";
             $this->m_sWhere .= " ) ";

              $this->m_sInvParam .= '&Group'.$g.'id='.$aReq['Group'.$g.'id'].'&multilev=1';

         }
         else
         {
           $this->m_sWhere .= " and a.CATEGORY ='".$aReq['Group'.$g.'id']."' ";
           $this->m_sInvParam .= '&Group'.$g.'id='.$aReq['Group'.$g.'id'].'&multilev=0';
         }
          $g = -1;
        }
     }

     if  ( ( isset ($aReq['Bufid']) ) && ( strlen ( $aReq['Bufid'] )>0 ) )
     {
        $iBufJNR = $aReq['Bufid'];
        $sParamBufJNR = $aReq['Bufid'];

        if ( isset ($aReq['OtsiBuf']) )
        {
           $this->m_sWhere .= " and a.ID IN ( SELECT PRODUCT FROM BUFROWS WHERE BJNR = ".$iBufJNR." ) ";

           $this->m_sInvParam .= "&Bufid=".$iBufJNR."&OtsiBuf=".$aReq['OtsiBuf'];
        }
     }
     else
     {
        $iBufJNR = -1;
        $sParamBufJNR = "0";
     }


      if  (  $this->m_sLocation != "-1" )  $sHtml = '<p> <a href="addinvent.php?'.$this->m_sInvParam.'">'.$lang->addinv.'</a> &nbsp;'.$lang->voi;
      else     $sHtml = '<p> ';

      $sHtml .= '&nbsp;&nbsp; <a href="addbuffer.php?Bufid='.$sParamBufJNR.'&'.$this->m_sInvParam.'"  target="_blank" >'.$lang->addbuf.'&nbsp;&quot;'. ($this->m_sBufComment).'&quot;</a></p>'  ;

      return $sHtml;
  }


   function getGroupsWhere ( $aReq )
   {
      $sGroupWhere = "";

      for ( $g=4; $g>-1; $g-- )
      {

        if  ( ( isset ($aReq['Group'.$g.'id']) ) && ( strlen ( $aReq['Group'.$g.'id'] )>0 ) && ( $aReq['Group'.$g.'id']!='0' )  )
        {
          if ( $this->m_sCBmultilevelChecked == "checked" )
          {
               $iSubGroup1Couunt = 0;
               $iSubGroup2Couunt = 0;

               for ( $l=0; $l < $this->m_aGroupList['count']; $l++ )
               {
                    if ( $this->m_aGroupList[$l]['parent'] == $aReq['Group'.$g.'id']  )
                    {
                       $aSubCategory1[ $iSubGroup1Couunt ] = $this->m_aGroupList[$l]['id'];
                       $iSubGroup1Couunt++;
                    }
               }

               for ( $i=0; $i < $iSubGroup1Couunt; $i++ )
               {
                   for ( $l=0; $l < $this->m_aGroupList['count']; $l++ )
                   {
                       if ( $this->m_aGroupList[$l]['parent'] ==  $aSubCategory1[ $i ]  )
                       {
                           $aSubCategory2[ $iSubGroup2Couunt ] = $this->m_aGroupList[$l]['id'];
                           $iSubGroup2Couunt++;
                       }
                   }
               }

              $sGroupWhere .= " and P.CATEGORY in ( '".$aReq['Group'.$g.'id']."'";
              for ( $i=0; $i < $iSubGroup1Couunt; $i++ )  $sGroupWhere .= ",'".$aSubCategory1[$i]."'";
              for ( $i=0; $i < $iSubGroup2Couunt; $i++ )  $sGroupWhere .= ",'".$aSubCategory2[$i]."'";
              $sGroupWhere .= " ) ";


          }
          else
          {
            $sGroupWhere .= " and P.CATEGORY ='".$aReq['Group'.$g.'id']."' ";
          }
           $g = -1;
         }
      }

    
       return $sGroupWhere;
   }


    function getGroupsHtml (  $lang )
    {
        $sHtml = '<tr><td>'.$lang->Grupp.':</td><td colspan="2">'.$this->m_sSelGroup[0].'</td>
           <td><input id="cb_multilevel" name="cb_multilevel" type="checkbox" '.$this->m_sCBmultilevelChecked.' >multilevel</td></tr>';

             for ( $g = 1; $g < $this->m_iGLlevels ; $g++ )
             {
                 $sHtml .= '<tr><td>'.$lang->SubGrupp.' '.$g.':</td><td colspan="2">'.$this->m_sSelGroup[$g].'</td>
                   <td></td></tr>';

             }

       return $sHtml;

    }

    function getGroupsHiddenForm ()
    {
       $sHtml =   '<input type="hidden" name="fgrlevels" value="'.$this->m_iGLlevels.'" >';
       $sHtml .= '<input type="hidden" name="fcb_multilevel" value="'.(($this->m_sCBmultilevelChecked == "checked")?'on':'off').'" >';

       for ( $g = 0; $g < $this->m_iGLlevels ; $g++ )
       {
          $sHtml .=  '<input type="hidden" name="fGroup'.$g.'id" value="" >';
       }

      return $sHtml;
    }

}

?>
