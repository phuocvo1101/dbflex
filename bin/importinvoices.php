<?php
require_once realpath(dirname(__FILE__)) . '/../app/start.php';



$invoice = new \Models\InvoiceModel();



$checkTime = $invoice->checkScheduleTime();

if(!$checkTime) {
    echo "Please wait new time.\n";
    exit();
}
$invoice->updateLastTime();
echo "Begin Import Invoices\n";

$invoices = $invoice->listModel();

echo "Total Records:". count($invoices)."\n";
$return = $invoice->payments($invoices);

if(!$return) {
    echo 'Import was not successfull'."\n";
    exit();
}

echo "Finish Import Invoices\n";

echo 'Import was  successfull'."\n";
exit();
