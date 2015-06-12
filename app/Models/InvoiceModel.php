<?php
namespace Models;

use Libraries\Database;
use Libraries\DBFlex\API;
use Libraries\DBFlex\DataSet;
use Libraries\eWAY\CreateDirectPaymentRequest;
use Libraries\eWAY\LineItem;
use Libraries\eWAY\RapidAPI;
use Models\MappingModel;

class InvoiceModel extends BaseModel
{
    private $ewayKey;
    private $ewayPassword = '';
    private $username = '';
    private $password = '';
    private $envirSandbox = true;
    private $appId;
    private $dbflexUrl = '';
    private $model;

    private $settingModel;

    public function __construct()
    {
        parent::__construct();
        $this->database = new Database();
        $this->settingModel = new SettingModel();
        $this->model = new MappingModel();
        $settings =  $this->settingModel->getSettings();
        if (isset($settings['dbflex_user'])) {
            $this->username = $settings['dbflex_user'];
        }
        if (isset($settings['dbflex_url'])) {
            $this->dbflexUrl = $settings['dbflex_url'];
        }

        if (isset($settings['dbflex_pass'])) {
            $this->password = $settings['dbflex_pass'];
        }

        if (isset($settings['eway_key'])) {
            $this->ewayKey = $settings['eway_key'];
        }

        if (isset($settings['eway_pass'])) {
            $this->ewayPassword = $settings['eway_pass'];
        }


        if (isset($settings['eway_appid'])) {
            $this->appId = $settings['eway_appid'];
        }

        if (isset($settings['eway_envir'])) {
            if ($settings['eway_envir'] == 1) {
                $this->envirSandbox = true;
            } else {
                $this->envirSandbox = false;
            }
        }
    }

    public function listModel()
    {

        try {

            $mappings = $this->model->getMaps();
            $mappingResult = array();
            foreach ($mappings as $item) {
                $mappingResult[$item->keymap] = $item->valuemap;
            }
            $fetch = $mappingResult['Fetch'];
            $where = "[" . $fetch . "]" . " =" . " true";

            $setting = $this->model->getSetting();
            $table = $setting->value;

            $api = new API($this->dbflexUrl, $this->appId, array("trace" => true));

            $api->login($this->username, $this->password);

            $sql = "SELECT  * FROM [" . $table . "] WHERE " . $where;

            $result = $api->Query($sql);

            $api->Logout();
            if (!isset($result->Rows)) {
                return array();
            }

            return $result->Rows;

        } catch (Exception $e) {
            echo $e->getMessage();
            $api->dumpRequest();
            $api->dumpResponse();
            return array();
        }
    }

    public function getTransaction($transactionID)
    {
        $eway_params = array();
        if ($this->envirSandbox) {
            $eway_params['sandbox'] = true;
        }
        $service = new RapidAPI($this->ewayKey, $this->ewayPassword, $eway_params);
        $result = $service->TransactionQuery($transactionID);
        if (isset($result->Errors) && !empty($result->Errors)) {
            // Get Error Messages from Error Code.
            $ErrorArray = explode(",", $result->Errors);
            $lblError = "";
            foreach ($ErrorArray as $error) {
                $error = $service->getMessage($error);
                $lblError .= $error . "<br />\n";;
            }
            echo 'Get Transaction is Failed: ' . $transactionID . "\n";
            echo 'Message:' . $lblError . "\n";
            return array(
                'status' => false,
                'error_codes' => $ErrorArray,
                'message' => $lblError
            );
        }

        return array(
            'status' => true,
            'TransactionStatus' => $result->Transactions[0]->TransactionStatus
        );
    }

    public function payment($invoice)
    {
        echo 'Begin Payment' . "\n";
        $request = new CreateDirectPaymentRequest();
        $mappings = $this->model->getMaps();
        $mappingResult = array();
        foreach ($mappings as $item) {
            $mappingResult[$item->keymap] = $item->valuemap;
        }

        $request->Customer->Reference = isset($invoice[$mappingResult['Customer.Reference']]) && !empty($invoice[$mappingResult['Customer.Reference']]) ? $invoice[$mappingResult['Customer.Reference']] : null;
        $request->Customer->Title = isset($invoice[$mappingResult['Customer.Title']]) && !empty($invoice[$mappingResult['Customer.Title']]) ? $invoice[$mappingResult['Customer.Title']] : null;
        $request->Customer->FirstName = isset($invoice[$mappingResult['Customer.FirstName']]) && !empty($invoice[$mappingResult['Customer.FirstName']]) ? $invoice[$mappingResult['Customer.FirstName']] : null;
        $request->Customer->LastName = isset($invoice[$mappingResult['Customer.LastName']]) && !empty($invoice[$mappingResult['Customer.LastName']]) ? $invoice[$mappingResult['Customer.LastName']] : '';
        $request->Customer->CompanyName = isset($invoice[$mappingResult['Customer.CompanyName']]) && !empty($invoice[$mappingResult['Customer.CompanyName']]) ? $invoice[$mappingResult['Customer.CompanyName']] : null;
        $request->Customer->JobDescription = isset($invoice[$mappingResult['Customer.JobDescription']]) && !empty($invoice[$mappingResult['Customer.JobDescription']]) ? $invoice[$mappingResult['Customer.JobDescription']] : null;
        $request->Customer->Street1 = isset($invoice[$mappingResult['Customer.Street1']]) && !empty($invoice[$mappingResult['Customer.Street1']]) ? $invoice[$mappingResult['Customer.Street1']] : null;
        $request->Customer->City = isset($invoice[$mappingResult['Customer.City']]) && !empty($invoice[$mappingResult['Customer.City']])  ? $invoice[$mappingResult['Customer.City']] : null;
        $request->Customer->State = isset($invoice[$mappingResult['Customer.Title']]) && !empty($invoice[$mappingResult['Customer.Title']])  ? $invoice[$mappingResult['Customer.Title']] : null;
        $request->Customer->PostalCode = isset($invoice[$mappingResult['Customer.PostalCode']]) && !empty($invoice[$mappingResult['Customer.PostalCode']]) ? $invoice[$mappingResult['Customer.PostalCode']] : null;
        $request->Customer->Country = isset($invoice[$mappingResult['Customer.Country']])  && !empty($invoice[$mappingResult['Customer.Country']]) ? $invoice[$mappingResult['Customer.Country']] : null;
        $request->Customer->Email = isset($invoice[$mappingResult['Customer.Email']])  && !empty($invoice[$mappingResult['Customer.Email']]) ? $invoice[$mappingResult['Customer.Email']] : null;
        $request->Customer->Phone = isset($invoice[$mappingResult['Customer.Phone']])   && !empty($invoice[$mappingResult['Customer.Phone']]) ? $invoice[$mappingResult['Customer.Phone']] : null;
        $request->Customer->Mobile = isset($invoice[$mappingResult['Customer.Mobile']])    && !empty($invoice[$mappingResult['Customer.Mobile']])  ? $invoice[$mappingResult['Customer.Mobile']] : null;
        $request->Customer->Comments = isset($invoice[$mappingResult['Customer.Comments']]) && !empty($invoice[$mappingResult['Customer.Comments']])  ? $invoice[$mappingResult['Customer.Comments']] : null;
        $request->Customer->Fax = isset($invoice[$mappingResult['Customer.Fax']]) && !empty($invoice[$mappingResult['Customer.Fax']])  ? $invoice[$mappingResult['Customer.Fax']] : '';
        // $request->Customer->Url = isset($invoice[$mappingResult['Customer.Url']]) ? $invoice[$mappingResult['Customer.Url']] : '' ;
        $request->Customer->CardDetails->Name = isset($invoice[$mappingResult['Customer.CardDetails.Name']]) && !empty($invoice[$mappingResult['Customer.CardDetails.Name']]) ? $invoice[$mappingResult['Customer.CardDetails.Name']] : null;
        $request->Customer->CardDetails->Number = isset($invoice[$mappingResult['Customer.CardDetails.Number']]) && !empty($invoice[$mappingResult['Customer.CardDetails.Number']]) ? $invoice[$mappingResult['Customer.CardDetails.Number']] : null;

        if (isset($invoice['ExpiryDate']) && $invoice['ExpiryDate'] instanceof \DateTime) {
            $month = $invoice['ExpiryDate']->format("m");
            $year = $invoice['ExpiryDate']->format("y");
            $request->Customer->CardDetails->ExpiryMonth = $month;
            $request->Customer->CardDetails->ExpiryYear = $year;
        }

        if (isset($invoice['ValidFromDate']) && $invoice['ValidFromDate'] instanceof \DateTime) {
            $month = $invoice['ValidFromDate']->format("m");
            $year = $invoice['ValidFromDate']->format("y");
            $request->Customer->CardDetails->StartMonth = $month;
            $request->Customer->CardDetails->StartYear = $year;
        }

        $request->Customer->CardDetails->IssueNumber = isset($invoice[$mappingResult['Customer.CardDetails.IssueNumber']]) && !empty($invoice[$mappingResult['Customer.CardDetails.IssueNumber']])  ? $invoice[$mappingResult['Customer.CardDetails.IssueNumber']] : null;
        $request->Customer->CardDetails->CVN = isset($invoice[$mappingResult['Customer.CardDetails.CVN']]) && !empty($invoice[$mappingResult['Customer.CardDetails.CVN']]) ? $invoice[$mappingResult['Customer.CardDetails.CVN']] : null;

        // Populate values for ShippingAddress Object.
        // This values can be taken from a Form POST as well. Now is just some dummy data.
        $request->ShippingAddress->FirstName = isset($invoice[$mappingResult['ShippingAddress.FirstName']]) && !empty($invoice[$mappingResult['ShippingAddress.FirstName']]) ? $invoice[$mappingResult['ShippingAddress.FirstName']] : null;
        $request->ShippingAddress->LastName = isset($invoice[$mappingResult['ShippingAddress.LastName']]) && !empty($invoice[$mappingResult['ShippingAddress.LastName']]) ? $invoice[$mappingResult['ShippingAddress.LastName']] : null;
        $request->ShippingAddress->Street1 = isset($invoice[$mappingResult['ShippingAddress.Street1']]) && !empty($invoice[$mappingResult['ShippingAddress.Street1']]) ? $invoice[$mappingResult['ShippingAddress.Street1']] : null;
        $request->ShippingAddress->Street2 = "";
        $request->ShippingAddress->City = isset($invoice[$mappingResult['ShippingAddress.City']]) && !empty($invoice[$mappingResult['ShippingAddress.City']]) ? $invoice[$mappingResult['ShippingAddress.City']] : null;
        $request->ShippingAddress->State = isset($invoice[$mappingResult['ShippingAddress.State']]) && !empty($invoice[$mappingResult['ShippingAddress.State']]) ? $invoice[$mappingResult['ShippingAddress.State']] : null;
        $request->ShippingAddress->Country = isset($invoice[$mappingResult['ShippingAddress.Country']])  && !empty($invoice[$mappingResult['ShippingAddress.Country']]) ? $invoice[$mappingResult['ShippingAddress.Country']] : null;
        $request->ShippingAddress->PostalCode = isset($invoice[$mappingResult['ShippingAddress.PostalCode']]) && !empty($invoice[$mappingResult['ShippingAddress.PostalCode']]) ? $invoice[$mappingResult['ShippingAddress.PostalCode']] : null;
        $request->ShippingAddress->Email = isset($invoice[$mappingResult['ShippingAddress.Email']])  && !empty($invoice[$mappingResult['ShippingAddress.Email']]) ? $invoice[$mappingResult['ShippingAddress.Email']] : null;
        $request->ShippingAddress->Phone = isset($invoice[$mappingResult['ShippingAddress.Phone']]) && !empty($invoice[$mappingResult['ShippingAddress.Phone']]) ? $invoice[$mappingResult['ShippingAddress.Phone']] : null;

        $request->ShippingAddress->ShippingMethod = "LowCost";
        $item1 = new LineItem();
        $item1->SKU = "SKU1";
        $item1->Description = "Description1";
        $item2 = new LineItem();
        $item2->SKU = "SKU2";
        $item2->Description = "Description2";
        $request->Items->LineItem[0] = $item1;
        $request->Items->LineItem[1] = $item2;

        // Populate values for Payment Object

        $request->Payment->InvoiceDescription = isset($invoice[$mappingResult['Payment.InvoiceDescription']]) && !empty($invoice[$mappingResult['Payment.InvoiceDescription']]) ? $invoice[$mappingResult['Payment.InvoiceDescription']] : null;
        $request->Payment->TotalAmount = isset($invoice[$mappingResult['Payment.TotalAmount']])  && !empty($invoice[$mappingResult['Payment.TotalAmount']]) ? $invoice[$mappingResult['Payment.TotalAmount']] : null;
        $request->Payment->InvoiceNumber = isset($invoice[$mappingResult['Payment.InvoiceNumber']])  && !empty($invoice[$mappingResult['Payment.InvoiceNumber']]) ? $invoice[$mappingResult['Payment.InvoiceNumber']] : null;
        $request->Payment->InvoiceReference = isset($invoice[$mappingResult['Payment.InvoiceReference']])   && !empty($invoice[$mappingResult['Payment.InvoiceReference']]) ? $invoice[$mappingResult['Payment.InvoiceReference']] : null;
        $request->Payment->CurrencyCode = isset($invoice[$mappingResult['Payment.CurrencyCode']])   && !empty($invoice[$mappingResult['Payment.CurrencyCode']]) ? $invoice[$mappingResult['Payment.CurrencyCode']] : '';

        $setting = $this->settingModel->getFactorSetting();

        if($setting!=null) {
            $request->Payment->TotalAmount = $request->Payment->TotalAmount*$setting->value;
        }

        $request->Method = 'ProcessPayment';
        $request->TransactionType = 'Purchase';

        $eway_params = array();

        if ($this->envirSandbox) {
            $eway_params['sandbox'] = true;
        }

        $service = new RapidAPI($this->ewayKey, $this->ewayPassword, $eway_params);
        $result = $service->DirectPayment($request);
        //var_dump($result);die();
        if (isset($result->Errors)) {
            // Get Error Messages from Error Code.
            $ErrorArray = explode(",", $result->Errors);
            $lblError = "";
            foreach ($ErrorArray as $error) {
                $error = $service->getMessage($error);
                $lblError .= $error . "<br />\n";;
            }
            echo 'Payment is Failed: ' . $invoice['Id'] . "\n";
            echo 'Message:' . $lblError . "\n";
            return array(
                'status' => false,
                'error_codes' => $ErrorArray,
                'message' => $lblError
            );
        }

        echo "Finish Payment\n";

        if (isset($result->TransactionStatus) && $result->TransactionStatus && (is_bool($result->TransactionStatus) || $result->TransactionStatus != "false")) {
            return array(
                'status' => true,
                'data' => array(
                    'TransactionID' => $result->TransactionID
                )
            );
        } else {
            return array(
                'status' => false
            );
        }

    }

    public function insertTransaction($transaction)
    {

        $sql = 'INSERT INTO transactions(dbflex_id) VALUES(?)';
        $this->database->setQuery($sql);
        $data = array(
            array($transaction['dbflex_id'], \PDO::PARAM_INT)
        );
        return $this->database->execute($data);
    }

    public function checkDBflexID($dbflex_id)
    {
        $sql = 'SELECT COUNT(*) as Total FROM transactions WHERE dbflex_id =?';
        $this->database->setQuery($sql);
        $data = array(
            array($dbflex_id, \PDO::PARAM_INT)
        );
        $row = $this->database->loadRow($data);
        if (isset($row->Total) && $row->Total > 0) {
            return true;
        }
        return false;
    }

    public function checkTransactionID($dbflex_id)
    {
        $sql = 'SELECT transaction_id FROM transactions WHERE dbflex_id =?';
        $this->database->setQuery($sql);
        $data = array(
            array($dbflex_id, \PDO::PARAM_INT)
        );
        $row = $this->database->loadRow($data);
        if (isset($row->transaction_id) && !empty($row->transaction_id)) {
            return true;
        }

        return false;
    }

    public function updateTransaction($transaction)
    {
        $sql = 'UPDATE transactions SET transaction_id=? WHERE dbflex_id=?';
        $this->database->setQuery($sql);
        $data = array(
            array($transaction['transaction_id'], \PDO::PARAM_INT),
            array($transaction['dbflex_id'], \PDO::PARAM_INT)
        );
        return $this->database->execute($data);
    }

    public function payments($invoices)
    {

        foreach ($invoices as $invoice) {

            if (!$this->checkDBflexID($invoice['@id'])) {
                // insert database
                $insertDB = $this->insertTransaction(array('dbflex_id' => $invoice['@id']));
            }

            if ($this->checkTransactionID($invoice['@id'])) {
                continue;
            }

            $result = $this->payment($invoice);

            if ($result['status'] == false) {
                continue;
            }

            $resultUpdate = $this->updateTransaction(array(
                'transaction_id' => $result['data']['TransactionID'],
                'dbflex_id' => $invoice['@id']
            ));

            if (!$resultUpdate) {
                continue;
            }

        }

        return true;
    }

    public function update($params)
    {
        if (!isset($params['Id'])) {
            return false;
        }

        $setting = $this->model->getSetting();
        $table = $setting->value;

        $api = new API($this->dbflexUrl, $this->appId, array("trace" => true));

        $api->login($this->username, $this->password);

        $arrKeys = array();

        foreach ($params as $key => $item) {
            if ($key != "Id") {
                $arrKeys[] = $key;
            }
        }

        $ds = $api->Retrieve($table, $arrKeys, array($params['Id']));

        foreach ($params as $key => $item) {
            if ($key != "Id") {
                $ds->Rows[0][$key] = $item;
            }
        }

        $api->Update($table, $ds);

        $api->Logout();


        return true;

    }

    public function getListTransactionsUpdate()
    {
        $sql = 'SELECT * FROM transactions WHERE transaction_id<>"" AND status<>1';
        $this->database->setQuery($sql);
        return $this->database->loadAllRows();
    }

    public function updateStatusTransaction($id)
    {
        $sql = ' UPDATE transactions SET status=? WHERE id=?';
        $this->database->setQuery($sql);
        $data = array(
            array(1, \PDO::PARAM_INT),
            array($id, \PDO::PARAM_INT)
        );
        return $this->database->execute($data);
    }

    public function updateLastTime()
    {
        $time = time();
        $sql = 'UPDATE settings SET `value`=? WHERE `key`=?';
        $this->database->setQuery($sql);
        $data = array(
            array($time, \PDO::PARAM_STR),
            array('lastmodified', \PDO::PARAM_STR)
        );

        return $this->database->execute($data);
    }

    public function updateTransactions()
    {
        $transactions = $this->getListTransactionsUpdate();
        foreach ($transactions as $item) {
            $resultTransactions = $this->getTransaction($item->transaction_id);
            if ($resultTransactions['status'] == false) {
                $this->updateStatusTransaction($item->id);
                continue;
            }

            $mappings = $this->model->getMaps();
            $mappingResult = array();
            foreach ($mappings as $map) {
                $mappingResult[$map->keymap] = $map->valuemap;
            }

            $data = array(
                'Id' => $item->dbflex_id,
                $mappingResult['Fetch'] => false,
                $mappingResult['Status'] => $resultTransactions['TransactionStatus'] == true ? "Paid" : "Not Paid",
                $mappingResult['TransactionID'] => $item->transaction_id
            );

            $result = $this->update($data);

            if ($result) {
                $this->updateStatusTransaction($item->id);
                continue;
            }

        }

        return true;
    }

    public function checkScheduleTime()
    {

        $sql = 'SELECT `value` FROM `settings` WHERE `key`=?';
        $this->database->setQuery($sql);
        $data = array(
            array('lastmodified', \PDO::PARAM_STR)
        );
        $result = $this->database->loadRow($data);

        if ($result == false) {
            return false;
        }
        $lastmodified = $result->value;
        echo 'LastModified:' . date('Y-m-d H:i:s', $lastmodified) . "\n";
        $sql = 'SELECT `value` FROM `settings` WHERE `key`=?';
        $this->database->setQuery($sql);
        $data = array(
            array('cronjob_interval', \PDO::PARAM_STR)
        );
        $result = $this->database->loadRow($data);
        if ($result == false) {
            return false;
        }
        $timeInterval = $result->value;
        $time = time();
        echo 'Current Time:' . date('Y-m-d H:i:s', $time) . "\n";
        $timesum = $lastmodified + ($timeInterval * 60);
        if ($timesum < $time) {
            return true;
        }
        return false;
    }

}