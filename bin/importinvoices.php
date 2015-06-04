<?php
require_once realpath(dirname(__FILE__)) . '/../app/start.php';
require realpath(dirname(__FILE__)) . '/dbflexsettings.php';
$networkName = 'DBFlex';
//Retrieving the credentials for the network

$readOptions = true;
$optionsWithData = array('m');
$longOptionsWithData = array('month');
$month = '';
for ($i = 1; $i < count($argv); ++$i) {
    $arg = $argv[$i];
    if ($readOptions and
        strlen($arg) > 0 and
        $arg[0] == '-'
    ) {
        if (strlen($arg) > 1 and
            $arg[1] == '-'
        ) {
            $flag = substr($arg, 2);
            if (in_array($flag, $longOptionsWithData)) {
                $optionData = $argv[$i + 1];
                ++$i;
            }
            if ($flag == 'help') {
                help();
                exit();
            } else if ($flag == 'month') {
                $month = $optionData;
            }

        } else {
            $flag = substr($arg, 1, 1);
            $optionData = false;
            if (in_array($flag, $optionsWithData)) {
                if (strlen($arg) > 2) {
                    $optionData = substr($arg, 2);
                } else {
                    $optionData = $argv[$i + 1];
                    ++$i;
                }
            }
            if ($flag == 'h') {
                help();
                exit();
            } else if ($flag == 'm') {
                $month = $optionData;
            }
        }
    }

}

if($month=='') {
    $month=1;
}

$configName = strtolower($networkName);
$config = Zend_Registry::getInstance()->get('dbflexIni');

$configName = strtolower($networkName);
$credentials = $config->$configName->toArray();
$params = array();
$params['username'] = $credentials['user'];
$params['password'] = $credentials['password'];
$params['ewayKey'] = $credentials['ewayKey'];
$params['ewayPassword'] = $credentials['ewayPassword'];

$invoice = new \Models\InvoiceModel($params);
$invoices = $invoice->listModel();
echo "Total Records:". count($invoices)."\n";
//var_dump($invoices);die();
$return = $invoice->payments($invoices);

//$return = $invoice->insert($result);
if(!$return) {
    echo 'Import was not successfull'."\n";
    exit();
}

echo 'Import was  successfull'."\n";
exit();
//Path for the cookie located inside of COOKIES_BASE_DIR

function help()
{
    $argv = $_SERVER['argv'];
    echo "Usage: " . $argv[0] . " [OPTION]... [PART]","green";
    echo "\n";
    echo "Executes cronjobs.","green";
    echo "\n";
    echo "General options:","green";
    echo "\n";
    echo "  -h,--help          display this help and exit ","green";
    echo "\n";
    echo "  -m,--month          get data follow month ","green";
    echo "\n";

}
