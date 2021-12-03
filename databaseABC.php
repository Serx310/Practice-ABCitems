<?php

class myDB {


   var $m_mysqli = null;
   var $m_row = 0;
   var $m_sth = null;

   var $tbl_prfx = "";

      function __construct ( $phost="", $pusername="", $ppassword = "", $pdatabase="", $preffix="" )
       {
	         $this->m_mysqli = new mysqli($phost, $pusername, $ppassword, $pdatabase );
           if (!$this->m_mysqli->set_charset("utf8")) {
                  echo "db error utf8:".
                  $this->m_mysqli->error;

                  }

           $this->tbl_prfx = $preffix;
      }


     function setQuery( $sql )
     {
        $this->m_sth = $this->m_mysqli->query( $sql  );
     }


     function GetStockList   ( $iParam = 0, $sVal = '0')
  {

    if ( $iParam == 1 ) $sSql = "SELECT ID, NAME FROM LOCATIONS WHERE ID = '".$sVal."'; ";
    else  $sSql = "SELECT ID, NAME FROM LOCATIONS ORDER BY NAME";

   //  echo $sSql;

     $aRet = Array ( );

     $iCount = 0;

    $this->m_sth = $this->m_mysqli->query( $sSql );

     while  ( $row = $this->m_sth->fetch_assoc()  )
     {
        $aRet[$iCount]['id']     =   $row['ID'];
        $aRet[$iCount]['name']   =   $row['NAME'];

        $iCount ++;
     }

     $aRet['count']  =  $iCount;


    return $aRet;

  }

  function GetGroupList( $mode = 0, $param = '' )
        {

             if ( $mode == 0 ) $sSqlParam = "order by NAME";
             else if ( $mode == 1 ) $sSqlParam = "where UPPER(NAME) = ".$this->MyVarchar( strtoupper($param ) )." order by NAME " ;
             else $sSqlParam = "order by NAME";


            $sSql = "SELECT ID, NAME, PARENTID FROM CATEGORIES ". $sSqlParam;



           $aRet = Array ( );

           $iCount = 0;

          $this->m_sth = $this->m_mysqli->query( $sSql );

           while  ( $row = $this->m_sth->fetch_assoc()  )
           {
              $aRet[$iCount]['id']     =   $row['ID'];
              $aRet[$iCount]['name']   =   $row['NAME'];
              $aRet[$iCount]['parent']   =   $row['PARENTID'];
              $aRet[$iCount]['infilter']   =  0;

              if ( !isset( $aRet[$iCount]['parent']) )  $aRet[$iCount]['level']  = 0;
              else $aRet[$iCount]['level']  = -1;

              $iCount ++;
           }

           $aRet['count']  =  $iCount;



              $iLevelToSet = 1;

             do
             {
                 $bNeedSetLevel  = false;

                 for ( $i = 0; $i < $iCount; $i++ )
                 {

                    if ( $aRet[$i]['level'] == -1 )
                    {
                         $bNeedSetLevel  = true;

                         $grParent = $aRet[$i]['parent'];

                         for ( $k = 0; $k < $iCount ; $k++  )
                         {
                             if (  ( $aRet[$k]['level']  == ( $iLevelToSet - 1 ) )  &&  ( $aRet[$k]['id'] == $grParent ) )
                             {
                                 $aRet[$i]['level']  =  $iLevelToSet;
                                 $k = $iCount ;
                             }
                         }
                    }
                 }


                 $iLevelToSet ++;



                 if ( $iLevelToSet > 10 ) $bNeedSetLevel  = false;

             }
             while ( $bNeedSetLevel ) ;

           $aRet['levels']  =  $iLevelToSet;



          return $aRet;

        }


        function GetBuffer ( $iOrderBy = 1 )
     {
         $iCount = 0;

          $aRet['count'] =  $iCount;

          $sSql = "SELECT JNR, COMMENT, ( SELECT COUNT(*) FROM BUFROWS where BJNR = JNR ) as MYROWS  FROM BUFFERS order by ".$iOrderBy." ";



          $this->m_sth = $this->m_mysqli->query( $sSql );

         while  ( $row = $this->m_sth->fetch_assoc()  )
         {
            $aRet[$iCount]['JNR']          =   $row['JNR'];
            $aRet[$iCount]['COMMENT']     =   $row['COMMENT'];
            $aRet[$iCount]['MYROWS']        =   $row['MYROWS'];

            $iCount ++;
         }

          $aRet['count'] =  $iCount;

           return $aRet;
     }

     function GetKaubad ( $id, $iSI, $sWhere = "",  $sOrderBy = "", $sLocation="0",  $iBufJnr=-1, $iShowPlace=0 , $iShowBron=0, $iShowOrder=0,  $iOrderBufId=-1 , $iLimit = 200 )
     {

        if ( $iLimit > 0 ) $sSqlLimit = " LIMIT ".$iLimit." ";
        else $sSqlLimit = "";

        if  ( $iBufJnr < 0 )
        {
           $sSqlBufVal = " ";
           $sSqlBufJoin = " ";
        }
        else
        {
           $sSqlBufVal = ", b.UNITS as BUFUNITS ";
           $sSqlBufJoin = "left join BUFROWS b on b.PRODUCT = a.ID and b.BJNR = ".$iBufJnr." ";
        }

        if  ( $iShowPlace == 1) $sSqlPlace = ",(CONVERT( ExtractValue ( a.ATTRIBUTES , '/properties//entry[@key=\"koht\"]' ) USING utf8)) as PLACE" ;
        else  $sSqlPlace = ",'' as PLACE ";

        if  ( $iShowBron == 1)
        {
            $sSqlBron = ", r.CUSTOFFER , r.SUPORDER " ;
            if ( $sLocation == "-1" )   $sBronJoin = " LEFT JOIN RESERVCURRENT r ON r.PRODUCT = a.ID AND r.LOCATION = '0' ";
            else  $sBronJoin = " LEFT JOIN RESERVCURRENT r ON r.PRODUCT = a.ID AND r.LOCATION = '".$sLocation."' ";
        }
        else
        {
           $sSqlBron = ", 0 , 0 ";
           $sBronJoin = " ";
        }


         if ( $sLocation == "-1" )   $sSqlUnits = "( SELECT SUM( CAST( UNITS AS DECIMAL(10,4) ) ) FROM STOCKCURRENT WHERE PRODUCT = a.ID ) AS STOCKUNITS" ;
         else   $sSqlUnits = "( SELECT SUM( CAST( UNITS AS DECIMAL(10,4) ) ) FROM STOCKCURRENT WHERE PRODUCT = a.ID AND LOCATION = '".$sLocation."' ) AS STOCKUNITS" ;


         if ( $iShowOrder == 1 )
         {
            if ( $sLocation == "-1" )  $sSqlMinMax = ",( SELECT SUM( CAST( STOCKSECURITY AS DECIMAL(10,4) ) ) FROM STOCKLEVEL WHERE PRODUCT = a.ID ) AS STMIN, ( SELECT SUM( CAST( STOCKMAXIMUM AS DECIMAL(10,4) )  ) FROM STOCKLEVEL WHERE PRODUCT = a.ID ) AS STMAX ";
            else  $sSqlMinMax = ",( SELECT  STOCKSECURITY FROM STOCKLEVEL WHERE PRODUCT = a.ID and LOCATION = '". $sLocation."' ) AS STMIN, ( SELECT STOCKMAXIMUM FROM STOCKLEVEL WHERE PRODUCT = a.ID and LOCATION = '". $sLocation."' ) AS STMAX ";

            if ( $iOrderBufId == -1 )  $sSqlMinMax .= ", 0 ";
            else  $sSqlMinMax .= ", (  SELECT ob.UNITS from BUFROWS ob where ob.PRODUCT = a.ID and ob.BJNR = ".$iOrderBufId." ) AS TOORDER ";
         }
         else
         {
            $sSqlMinMax = ", 0, 0, 0 ";
         }



         // $sSql =  "SELECT a.ID, a.REFERENCE, a.CODE, a.NAME, a.PRICEBUY, a.PRICESELL, a.CATEGORY, a.TAXCAT, a.ATTRIBUTESET_ID, a.STOCKCOST, a.STOCKVOLUME, a.ISCOM, a.ISSCALE, a.ATTRIBUTES, t.RATE, c.NAME as CATEGORYNAME, ".$sSqlUnits." ". $sSqlBron.$sSqlBufVal.$sSqlPlace.$sSqlMinMax ;
         // $sSql .= ", ( SELECT LINENO FROM RETSEPT WHERE RETSEPT_PRODUCT = a.ID LIMIT 1 ) as RETSITEM, ";
         // $sSql .= " (CONVERT( ExtractValue ( a.ATTRIBUTES , '/properties//entry[@key=\"pant\"]' ) USING utf8)) as PANTPLU, ";
         // $sSql .= " (CONVERT( ExtractValue ( a.ATTRIBUTES , '/properties//entry[@key=\"koef\"]' ) USING utf8)) as PANTKOEF,  u.UNIT AS UNAME ";
         // $sSql .= " FROM PRODUCTS a  ";
         // $sSql .= "left join TAXES t on t.CATEGORY = a.TAXCAT ";
         // $sSql .= "left join UNITS u on u.PRODUCT = a.ID AND u.ISDEFAULT= 1 ";
         // $sSql .= "left join CATEGORIES c on c.ID = a.CATEGORY ".$sSqlBufJoin.$sBronJoin;



            $sSql =  " SELECT a.ID, a.REFERENCE, a.CODE, a.NAME, a.PRICEBUY, a.PRICESELL, a.CATEGORY, a.TAXCAT, a.ATTRIBUTESET_ID, a.STOCKCOST, a.STOCKVOLUME, a.ATTRIBUTES, " ;
            $sSql .=     "( SELECT c.NAME from CATEGORIES c WHERE c.ID = a.CATEGORY) as CATEGORYNAME, ";
            $sSql .=     "( SELECT SUM( CAST( UNITS AS DECIMAL(10,4) ) ) FROM STOCKCURRENT WHERE PRODUCT = a.ID ) AS STOCKUNITS ,(CONVERT( ExtractValue ( a.ATTRIBUTES , '/properties//entry[@key=\"koht\"]' ) USING utf8)) as PLACE, ";
            $sSql .=    " ( SELECT h.CODE FROM PRCODES h WHERE h.ID = a.ID and h.CODELIST = 3 LIMIT 1 ) as HANKIJAKOOD, ";
            $sSql .=     "(SELECT i.CODE from PRCODES i where i.ID = a.ID and i.CODELIST = 3) as IMAGECODE , ";
            $sSql .=     "( SELECT q.LONGDESC from PRODUCTS_MSG q where q.PRODUCT = a.ID and q.JNR =1 ) as ProdDescription, ";
            $sSql .=     "( Select t.RATE from TAXES t WHERE t.CATEGORY = a.TAXCAT) as RATE ";
            $sSql .=     "FROM PRODUCTS a ";
          //  $sSql .=     "order by a.NAME LIMIT 200 ";




         if      ( $iSI == 0 ) { if ( isset($id) ) $sSql .= " where a.ID = '".$id."' "; }
         else if ( $iSI == 1 ) {  $sSql .= " where a.CODE = '".$id."' ";  }
         else if ( $iSI == 2 ) {  $sSql .= " where a.REFERENCE = '".$id."' ";  }
         else if ( $iSI == 3 ) {  $sSql .= $sWhere;  }

         if ( ( $iSI == 3 ) && (strlen( $sOrderBy ) > 5  ))   $sSql .=  $sOrderBy;
         else $sSql .= "order by CATEGORYNAME, a.NAME";

         $sSql .= $sSqlLimit;

     echo $sSql.'<br>';
       $iCount = 0;

       $this->m_sth = $this->m_mysqli->query( $sSql );

         while  ( $row = $this->m_sth->fetch_assoc()  )
         {
            $aRet[$iCount]['ID']          =   $row['ID'];
            $aRet[$iCount]['REFERENCE']   =   $row['REFERENCE'];
            $aRet[$iCount]['CODE']        =   $row['CODE'];
            $aRet[$iCount]['NAME']        =   $row['NAME'];
            $aRet[$iCount]['PRICEBUY']    =   $row['PRICEBUY'];
            $aRet[$iCount]['PRICESELL']   =   $row['PRICESELL'];
            $aRet[$iCount]['CATEGORY']    =   $row['CATEGORY'];
            $aRet[$iCount]['TAXCAT']      =   $row['TAXCAT'];
            $aRet[$iCount]['HANKIJAKOOD']      =   $row['HANKIJAKOOD'];
            $aRet[$iCount]['ProdDescription']      =   $row['ProdDescription'];
            $aRet[$iCount]['ATTRIBUTESET_ID']    =   $row['ATTRIBUTESET_ID'];
            $aRet[$iCount]['STOCKCOST']     =   $row['STOCKCOST'];
            $aRet[$iCount]['STOCKVOLUME']   =   $row['STOCKVOLUME'];
            $aRet[$iCount]['ATTRIBUTES']    =   $row['ATTRIBUTES'];
            $aRet[$iCount]['RATE']          =   $row['RATE'];
            $aRet[$iCount]['CATEGORYNAME']  =   $row['CATEGORYNAME'];
            $aRet[$iCount]['UNITS']         =   $row['STOCKUNITS'];
            $aRet[$iCount]['IMAGECODE']         =   $row['IMAGECODE'];


            if  ( $iShowPlace == 1)  $aRet[$iCount]['PLACE']    =   $row['PLACE'];
            else $aRet[$iCount]['PLACE']    ='';
            $iCount ++;
         }

          $aRet['count'] =  $iCount;

      return $aRet;
     }

     function GetImage($itemId){

        $sSql = "SELECT IMAGE FROM PRODUCTS where ID =".$this->MyVarchar($itemId);

        $this->m_sth = $this->m_mysqli->query( $sSql );

       if  ( $row = $this->m_sth->fetch_assoc()  )
       {
          file_put_contents('saal.jpg', $row['IMAGE']);
       }

     }

     function GetImgBLOB($itemId){

        $sSql = "SELECT IMAGE FROM PRODUCTS where ID =".$this->MyVarchar($itemId);

        $this->m_sth = $this->m_mysqli->query( $sSql );

       if  ( $row = $this->m_sth->fetch_assoc()  )
       {
          return $row['IMAGE'];
       }

     }


     function close (  ) {  $this->m_mysqli->close(  ); }

}
