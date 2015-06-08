<?php
namespace Models;

use Libraries\Database;
use Libraries\DBFlex\API;
use Libraries\DBFlex\DataSet;
use Libraries\eWAY\CreateDirectPaymentRequest;
use Libraries\eWAY\LineItem;
use Libraries\eWAY\RapidAPI;

class InvoiceModel extends BaseModel
{
    private $ewayKey;
    private $ewayPassword='';
    private $username = '';
    private $password = '';
    private $envirSandbox=true;
    private $appId;
    private $dbflexUrl = '';
    public function __construct()
    {
        parent::__construct();
        $this->database = new Database();
        $settingModel = new SettingModel();
        $settings = $settingModel->getSettings();
        if(isset($settings['dbflex_user'])) {
            $this->username = $settings['dbflex_user'];
        }
        if(isset($settings['dbflex_url'])) {
            $this->dbflexUrl = $settings['dbflex_url'];
        }

        if(isset($settings['dbflex_pass'])) {
            $this->password = $settings['dbflex_pass'];
        }

        if(isset($settings['eway_key'])) {
            $this->ewayKey = $settings['eway_key'];
        }

        if(isset($settings['eway_pass'])) {
            $this->ewayPassword = $settings['eway_pass'];
        }


        if(isset($settings['eway_appid'])) {
            $this->appId = $settings['eway_appid'];
        }

        if(isset($settings['eway_envir'])) {
            if($settings['eway_envir']==1) {
                $this->envirSandbox = true;
            }else{
                $this->envirSandbox = false;
            }
        }
    }

    public function listModel()
    {
        try
        {
            $api = new API($this->dbflexUrl, $this->appId, array("trace" => true));

            $api->login( $this->username,$this->password);

            $sql = "SELECT  * FROM [Transaction] WHERE [FETCH] <> 1";
            $result = $api->Query($sql);

            $api->Logout();
            if(!isset($result->Rows)) {
                return array();
            }

            return $result->Rows;

        }
        catch(Exception $e)
        {
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
            foreach ( $ErrorArray as $error ) {
                $error = $service->getMessage($error);
                $lblError .= $error . "<br />\n";;
            }
            echo 'Get Transaction is Failed: '.$transactionID."\n";
            echo 'Message:'.$lblError."\n";
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
        echo 'Begin Payment'."\n";
        $request = new CreateDirectPaymentRequest();

        $request->Customer->Reference = isset($invoice['CustomerReference']) ? $invoice['CustomerReference'] : '' ;
        $request->Customer->Title = isset($invoice['Title']) ? $invoice['Title'] : '' ;
        $request->Customer->FirstName = isset($invoice['FirstName']) ? $invoice['FirstName'] : '' ;
        $request->Customer->LastName = isset($invoice['LastName']) ? $invoice['LastName'] : '' ;
        $request->Customer->CompanyName = isset($invoice['CompanyName']) ? $invoice['CompanyName'] : '' ;
        $request->Customer->JobDescription = isset($invoice['JobDescription']) ? $invoice['JobDescription'] : '' ;
        $request->Customer->Street1 = isset($invoice['Street']) ? $invoice['Street'] : '' ;
        $request->Customer->City = isset($invoice['City']) ? $invoice['City'] : '' ;
        $request->Customer->State = isset($invoice['State']) ? $invoice['State'] : '' ;
        $request->Customer->PostalCode =  isset($invoice['PostCode']) ? $invoice['PostCode'] : '' ;
        $request->Customer->Country = isset($invoice['Country']) ? $invoice['Country'] : '' ;
        $request->Customer->Email = isset($invoice['Email']) ? $invoice['Email'] : '' ;
        $request->Customer->Phone = isset($invoice['Phone']) ? $invoice['Phone'] : '' ;
        $request->Customer->Mobile = isset($invoice['Mobile']) ? $invoice['Mobile'] : '' ;
        $request->Customer->Comments = isset($invoice['Comments']) ? $invoice['Comments'] : '' ;
        $request->Customer->Fax = isset($invoice['Fax']) ? $invoice['Fax'] : '' ;
        $request->Customer->Url = isset($invoice['Website']) ? $invoice['Website'] : '' ;

        $request->Customer->CardDetails->Name = isset($invoice['CardHolder']) ? $invoice['CardHolder'] : '' ;
        $request->Customer->CardDetails->Number = isset($invoice['CardNumber']) ? $invoice['CardNumber'] : '' ;

        if(isset($invoice['ExpiryDate']) && $invoice['ExpiryDate'] instanceof \DateTime) {
            $month = $invoice['ExpiryDate']->format("m");
            $year = $invoice['ExpiryDate']->format("y");
            $request->Customer->CardDetails->ExpiryMonth = $month;
            $request->Customer->CardDetails->ExpiryYear = $year;
        }

        if(isset($invoice['ValidFromDate'])  && $invoice['ValidFromDate'] instanceof \DateTime) {
            $month = $invoice['ValidFromDate']->format("m");
            $year = $invoice['ValidFromDate']->format("y");
            $request->Customer->CardDetails->StartMonth = $month;
            $request->Customer->CardDetails->StartYear = $year;
        }

        $request->Customer->CardDetails->IssueNumber = isset($invoice['IssueNumber']) ? $invoice['IssueNumber'] : '' ;
        $request->Customer->CardDetails->CVN = isset($invoice['CVN']) ? $invoice['CVN'] : '' ;

        // Populate values for ShippingAddress Object.
        // This values can be taken from a Form POST as well. Now is just some dummy data.
        $request->ShippingAddress->FirstName = isset($invoice['FirstName']) ? $invoice['FirstName'] : '' ;
        $request->ShippingAddress->LastName = isset($invoice['LastName']) ? $invoice['LastName'] : '' ;
        $request->ShippingAddress->Street1 = isset($invoice['Street']) ? $invoice['Street'] : '' ;
        $request->ShippingAddress->Street2 = "";
        $request->ShippingAddress->City =  isset($invoice['City']) ? $invoice['City'] : '' ;
        $request->ShippingAddress->State = isset($invoice['State']) ? $invoice['State'] : '' ;
        $request->ShippingAddress->Country = isset($invoice['Country']) ? $invoice['Country'] : '' ;
        $request->ShippingAddress->PostalCode = isset($invoice['PostCode']) ? $invoice['PostCode'] : '' ;
        $request->ShippingAddress->Email = isset($invoice['Email']) ? $invoice['Email'] : '' ;
        $request->ShippingAddress->Phone = isset($invoice['Phone']) ? $invoice['Phone'] : '' ;

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
        $request->Payment->TotalAmount = isset($invoice['Amount']) ? $invoice['Amount'] : '' ;
        $request->Payment->InvoiceNumber =isset($invoice['InvoiceNumber']) ? $invoice['InvoiceNumber'] : '' ;
        $request->Payment->InvoiceDescription = isset($invoice['InvoiceDescription']) ? $invoice['InvoiceDescription'] : '' ;
        $request->Payment->InvoiceReference = isset($invoice['InvoiceReference']) ? $invoice['InvoiceReference'] : '' ;
        $request->Payment->CurrencyCode = isset($invoice['CurrencyCode']) ? $invoice['CurrencyCode'] : '' ;

        $request->Method = 'ProcessPayment';
        $request->TransactionType = isset($invoice['TransactionType']) ? $invoice['TransactionType'] : '' ;

        $eway_params = array();

        if ($this->envirSandbox) {
            $eway_params['sandbox'] = true;
        }

        $service = new RapidAPI($this->ewayKey, $this->ewayPassword, $eway_params);
        $result = $service->DirectPayment($request);

        if (isset($result->Errors)) {
            // Get Error Messages from Error Code.
            $ErrorArray = explode(",", $result->Errors);
            $lblError = "";
            foreach ( $ErrorArray as $error ) {
                $error = $service->getMessage($error);
                $lblError .= $error . "<br />\n";;
            }
            echo 'Payment is Failed: '.$invoice['Id']."\n";
            echo 'Message:'.$lblError."\n";
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
            array($transaction['dbflex_id'],\PDO::PARAM_INT)
        );
        return $this->database->execute($data);
    }

    public function checkDBflexID($dbflex_id)
    {
        $sql = 'SELECT COUNT(*) as Total FROM transactions WHERE dbflex_id =?';
        $this->database->setQuery($sql);
        $data = array(
            array($dbflex_id,\PDO::PARAM_INT)
        );
        $row = $this->database->loadRow($data);
        if(isset($row->Total) && $row->Total > 0) {
            return true;
        }
        return false;
    }

    public function checkTransactionID($dbflex_id)
    {
        $sql = 'SELECT transaction_id FROM transactions WHERE dbflex_id =?';
        $this->database->setQuery($sql);
        $data = array(
            array($dbflex_id,\PDO::PARAM_INT)
        );
        $row = $this->database->loadRow($data);
        if(isset($row->transaction_id) && !empty($row->transaction_id)) {
            return true;
        }

        return false;
    }

    public  function updateTransaction($transaction)
    {
        $sql = 'UPDATE transactions SET transaction_id=? WHERE dbflex_id=?';
        $this->database->setQuery($sql);
        $data = array(
            array($transaction['transaction_id'],\PDO::PARAM_INT),
            array($transaction['dbflex_id'],\PDO::PARAM_INT)
        );
        return $this->database->execute($data);
    }

    public function payments($invoices)
    {

        foreach($invoices as $invoice) {
            // enable fetch=1
        /*    $this->update(array(
               'Id' => $invoice['Id'],
                'Fetch' => true
            ));*/

            if(!$this->checkDBflexID($invoice['Id'])) {
                // insert database
                $insertDB = $this->insertTransaction(array('dbflex_id'=>$invoice['Id']));
            }

            if($this->checkTransactionID($invoice['Id'])) {
                continue;
            }

            $result = $this->payment($invoice);

           /* $params = array(
                'Id' => $invoice['Id'],
                'Fetch' => true,
                'Status' => true
            );*/

            if($result['status'] == false) {
               // $params['Status'] = false;
               // $this->update($params);
                continue;
            }

            $resultUpdate = $this->updateTransaction(array(
                'transaction_id' => $result['data']['TransactionID'],
                'dbflex_id' => $invoice['Id']
            ));

            if(!$resultUpdate) {
                continue;
            }

           // $params['TransactionID'] = $result['data']['TransactionID'];
            //$this->update($params);
        }

        return true;
    }

    public function update($params)
    {
        if(!isset($params['Id'])) {
            return false;
        }

        $api = new API($this->dbflexUrl, $this->appId, array("trace" => true));

        $api->login($this->username,$this->password);

        $arrKeys = array();
        foreach($params as $key=>$item) {
            if($key!="Id") {
                $arrKeys[] = $key;
            }
        }

        $ds = $api->Retrieve("Transaction", $arrKeys, array($params['Id']));
        foreach($params as $key=>$item) {
            if($key!="Id") {
                $ds->Rows[0][$key] = $item;
            }
        }

        $api->Update('Transaction',$ds);

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
            array(1,\PDO::PARAM_INT),
            array($id,\PDO::PARAM_INT)
        );
        return $this->database->execute($data);
    }

    public function updateLastTime()
    {
        $time = time();
        $sql = 'UPDATE settings SET `value`=? WHERE `key`=?';
        $this->database->setQuery($sql);
        $data = array(
            array($time,\PDO::PARAM_STR),
            array('lastmodified',\PDO::PARAM_STR)
        );

        return $this->database->execute($data);
    }

    public function updateTransactions()
    {
        $transactions = $this->getListTransactionsUpdate();
        foreach($transactions as $item) {
            $resultTransactions = $this->getTransaction($item->transaction_id);
            if($resultTransactions['status'] == false){
                $this->updateStatusTransaction($item->id);
                continue;
            }

            $result = $this->update(array(
                'Id' => $item->dbflex_id,
                'Fetch' => true,
                'Status' => $resultTransactions['TransactionStatus']
            ));

            if($result) {
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
            array('lastmodified',\PDO::PARAM_STR)
        );
       $result = $this->database->loadRow($data);

        if($result== false ) {
            return false;
        }
        $lastmodified = $result->value;
        echo 'LastModified:'.date('Y-m-d H:i:s', $lastmodified)."\n";
        $sql = 'SELECT `value` FROM `settings` WHERE `key`=?';
        $this->database->setQuery($sql);
        $data = array(
            array('cronjob_interval',\PDO::PARAM_STR)
        );
        $result = $this->database->loadRow($data);
        if($result== false ) {
            return false;
        }
        $timeInterval = $result->value;
        $time=time();
        echo 'Current Time:'.date('Y-m-d H:i:s', $time)."\n";
        $timesum = $lastmodified + ($timeInterval*60);
        if($timesum<$time) {
            return true;
        }
        return false;
    }

}