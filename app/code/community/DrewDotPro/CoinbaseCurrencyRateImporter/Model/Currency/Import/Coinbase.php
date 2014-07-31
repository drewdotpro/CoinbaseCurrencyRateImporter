<?php

class DrewDotPro_CoinbaseCurrencyRateImporter_Model_Currency_Import_Coinbase extends Mage_Directory_Model_Currency_Import_Abstract
{
    protected $_url = 'https://coinbase.com/api/v1/currencies/exchange_rates';
    protected $_messages = array();
    protected $_rates = array();

    protected function _convert($currencyFrom, $currencyTo, $retry = 0)
    {

        $mageFilename = 'app/Mage.php';
        require_once $mageFilename;
        umask(0);
        Mage::app();


        try {
            if (!isset($this->_rates[$currencyFrom]) || !isset($this->_rates[$currencyTo])) {
                $curl = new Varien_Http_Adapter_Curl();
                $curl->setConfig(array(
                    'timeout' => 15 //Timeout in no of seconds
                ));
                $curl->write(Zend_Http_Client::GET, $this->_url, '1.0');
                $data = $curl->read();
                $curl->close();
                list($headers, $data) = explode("\r\n\r\n", $data, 2);
                $data = trim($data);
                if ($data === false) {
                    $this->_messages[] = Mage::helper('directory')->__('Cannot retrieve rate from %s.', $this->_url);
                    return null;
                }
                $parsedData = json_decode($data, true);
                if ($parsedData === false || !is_array($parsedData)) {
                    $this->_messages[] = Mage::helper('directory')->__('Cannot parse rate data from %s.', $this->_url);
                    return null;
                }
                foreach($parsedData as $rateDescription => $rate)
                {
                    if(strpos($rateDescription, 'btc_to_') === 0)
                    {
                        $currency = strtoupper(substr($rateDescription, strpos($rateDescription, "btc_to_") + 7));
                        $this->_rates[$currency] = floatval($rate);
                    }
                }
                $this->_rates["BTC"] = 1;

                if (!isset($this->_rates[$currencyFrom])) {
                    $this->_messages[] = Mage::helper('directory')->__('Cannot retrieve rate for %s.', $currencyFrom);
                    return null;
                }

                if (!isset($this->_rates[$currencyTo])) {
                    $this->_messages[] = Mage::helper('directory')->__('Cannot retrieve rate for %s.', $currencyTo);
                    return null;
                }
            }
            return (float)1 / $this->_rates[$currencyFrom] * $this->_rates[$currencyTo];
        } catch (Exception $e) {
            echo $e->getMessage();
        }



    }

}
