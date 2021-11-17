<?php
    require_once '../funcont.php';
    require_once 'payslip.php';

    $kassaOrder = new KassaOrder();

    $aIN =  array( 0 );


    $aIN['ordnr'] = 2584;
    $aIN['custname'] = 'J. Tomilina';
    $aIN['invnr'] = '20070021';
    $aIN['invdate'] = '08.07.2020';
    $aIN['paid'] = '160,50';

    $aIN['paydate'] = $aIN['invdate'];






    echo $kassaOrder->getLink ( $aIN );

?>
