<?php
namespace Models;

use Libraries\DBFlex\API;
use GuzzleHttp\Client;
use Libraries\eWAY\CreateDirectPaymentRequest;
use Libraries\eWAY\LineItem;
use Libraries\eWAY\RapidAPI;

class InvoiceModel extends BaseModel
{
    private $ewayKey='C3AB9C6G6ljG838l6xaSIJTf3cE/AoqfLasktjKrX5TgPTHSMfNY/HRsR8jaxkT3v2M9G6';
    private $ewayPassword='duyquang#112088';
    private $username = '';
    private $password = '';
    private $envirSandbox = true;
    public function __construct($params)
    {
        parent::__construct();
        if(isset($params['username'])) {
            $this->username = $params['username'];
        }
        if(isset($params['password'])) {
            $this->password = $params['password'];
        }

        if(isset($params['ewayPassword'])) {
            $this->ewayPassword = $params['ewayPassword'];
        }


        if(isset($params['envirSandbox'])) {
            $this->envirSandbox = $params['envirSandbox'];
        }
    }

    public function listModel()
    {
        try
        {

            $api = new API("tcguy.dbflex.net", 41016, array("trace" => true));

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

   /* public function listModel()
    {
        $client = new Client([]);
        $url = 'https://tcguy.dbflex.net/secure/api/v2/41016/transaction/select.json?Fetch=5';
        $response = $client->get(
            $url,
            array(
                'auth'=> array(
                    $this->username,
                    $this->password),
                'query' => array(
                    'Fetch' => 2
                )
            )
        );
        $stream = $response->getBody(true);
        $content = $stream->getContents();
        $result = json_decode($content,true);
       return $result;
    }*/

    public function payment($invoice)
    {
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

    public function payments($invoices)
    {

        foreach($invoices as $invoice) {
            $result = $this->payment($invoice);
            $params = array(
                'Id' => $invoice['Id'],
                'Fetch' => true,
                'Status' => true
            );

            if($result['status'] == false) {
                $params['Status'] = false;
                $this->update($params);
                continue;
            }
            $params['TransactionID'] = $result['data']['TransactionID'];
            $this->update($params);
        }

        return true;
    }

    public function update($params)
    {
        if(!isset($params['Id'])) {
            return false;
        }

        $url = 'https://tcguy.dbflex.net/secure/api/v2/41016/transaction/upsert.json';
        $client = new Client([
            'base_uri' => $url,
                'auth' => [
                    $this->username,
                    $this->password
                ]

        ]);

        $request = $client->post(
            $url,
            [
                'form_params' => $params
            ]

        );
        $stream = $request->getBody(true);
        $content = $stream->getContents();
        $result = json_decode($content,true);
        return $result;

    }

   /* public function insert($invoices)
    {
        foreach($invoices as $item) {
            $query = 'INSERT INTO invoices(transactionRemoteID,amount,currencyCode,invoiceNumber,invoiceReference,
                      invoiceDescription,title,customerReference,firtName,lastName,companyName,jobDescription,street,
                      city,state,postCode,country,email,phone,mobile,fax,website,comment,cardHolder,cardNumber,
                      expiryDate,validFormDate,issueNumber,cvn,transactionType,date)
                       VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $arrData = array(
                array($item['merchantId'],\PDO::PARAM_INT),
                array($item['date'],\PDO::PARAM_STR),
                array($item['unique_id_ordernumber'],\PDO::PARAM_STR),
                array($item['programma_name'],\PDO::PARAM_STR),
                array($item['programa_prepayment_status'],\PDO::PARAM_STR),
                array($item['time_of_visit'],\PDO::PARAM_STR),
                array($item['time_in_session'],\PDO::PARAM_STR),
                array($item['time_last_modified'],\PDO::PARAM_STR),
                array($item['evento_name'],\PDO::PARAM_STR),
                array($item['reason'],\PDO::PARAM_STR),
                array($item['site_name'],\PDO::PARAM_STR),
                array($item['elem_grafico_name'],\PDO::PARAM_STR),
                array($item['status'],\PDO::PARAM_STR),
                array($item['amount'],\PDO::PARAM_STR),
                array($item['commission'],\PDO::PARAM_STR),
                array($item['custom_id'],\PDO::PARAM_STR),
                array($item['date'],\PDO::PARAM_STR),
                array($item['unique_id_ordernumber'],\PDO::PARAM_STR),
                array($item['programma_name'],\PDO::PARAM_STR),
                array($item['programa_prepayment_status'],\PDO::PARAM_STR),
                array($item['time_of_visit'],\PDO::PARAM_STR),
                array($item['time_in_session'],\PDO::PARAM_STR),
                array($item['time_last_modified'],\PDO::PARAM_STR),
                array($item['evento_name'],\PDO::PARAM_STR),
                array($item['reason'],\PDO::PARAM_STR),
                array($item['site_name'],\PDO::PARAM_STR),
                array($item['elem_grafico_name'],\PDO::PARAM_STR),
                array($item['status'],\PDO::PARAM_STR),
                array($item['amount'],\PDO::PARAM_STR),
                array($item['commission'],\PDO::PARAM_STR),
                array($item['custom_id'],\PDO::PARAM_STR)
            );
            $this->database->setQuery($query);
            $this->database->execute($arrData);
        }
    }*/
}