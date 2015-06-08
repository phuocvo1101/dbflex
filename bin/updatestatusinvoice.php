<?php
require_once realpath(dirname(__FILE__)) . '/../app/start.php';

echo "Begin Update Invoices\n";

$invoice = new \Models\InvoiceModel();
$return = $invoice->updateTransactions();

if(!$return) {
    echo 'Update was not successfull'."\n";
    exit();
}

echo "Finish Update Invoices\n";

echo 'Update was  successfull'."\n";
exit();
