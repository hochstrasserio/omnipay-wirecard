<?php
namespace Omnipay\Wirecard\Message;

/**
 * Wirecard Purchase Request
 */
class PurchaseRequest extends DataStorageRequest
{
    public function getData()
    {
    	$this->validate('customerId','secret','paymentType','amount','currency');

        $data = parent::getData();

        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['language'] = $this->getLanguage();
        $data['orderDescription'] = $this->getOrderDescription();
        $data['successUrl'] = $this->getSuccessUrl();
        $data['failureUrl'] = $this->getFailureUrl();
        $data['cancelUrl'] = $this->getCancelUrl();
        $data['serviceUrl'] = $this->getServiceUrl();
        $data['confirmUrl'] = $this->getConfirmUrl();

        if ($this->getPendingUrl()) {
            $data['pendingUrl'] = $this->getPendingUrl();
        }

        if ($this->getFinancialInstitution()) {
            $data['financialInstitution'] = $this->getFinancialInstitution();
        }

        if ($this->getBankCountry()) {
            $data['bankCountry'] = $this->getBankCountry();
        }

        if ($this->getBankAccount()) {
            $data['bankAccount'] = $this->getBankAccount();
        }

        if ($this->getBankNumber()) {
            $data['bankNumber'] = $this->getBankNumber();
        }

        if ($this->getPayerPayboxNumber()) {
            $data['payerPayboxNumber'] = $this->getPayerPayboxNumber();
        }

        if ($this->getUsername()) {
            $data['username'] = $this->getUsername();
        }

        if ($this->getParameter('basketAmount')) {
            $data['basketAmount'] = $this->getParameter('basketAmount');
        }

        if ($this->getParameter('basketCurrency')) {
            $data['basketCurrency'] = $this->getParameter('basketCurrency');
        }

        if ($this->getParameter('basketItems')) {
            $data['basketItems'] = $this->getParameter('basketItems');
        }

        for ($i = 1; $i <= $this->getParameter('basketItems'); $i++) {
            $data['basketItem'.$i.'ArticleNumber'] = $this->getParameter('basketItem'.$i.'ArticleNumber');
            $data['basketItem'.$i.'Quantity'] = $this->getParameter('basketItem'.$i.'Quantity');
            $data['basketItem'.$i.'UnitPrice'] = $this->getParameter('basketItem'.$i.'UnitPrice');
            $data['basketItem'.$i.'Tax'] = $this->getParameter('basketItem'.$i.'Tax');
            $data['basketItem'.$i.'Description'] = $this->getParameter('basketItem'.$i.'Description');
        }

        $this->getParameter('consumerEmail') and $data['consumerEmail'] = $this->getParameter('consumerEmail');

        # Billing details
        $this->getParameter('consumerBillingFirstName') and $data['consumerBillingFirstName'] = $this->getParameter('consumerBillingFirstName');
        $this->getParameter('consumerBillingLastName') and $data['consumerBillingLastName'] = $this->getParameter('consumerBillingLastName');
        $this->getParameter('consumerBillingAddress1') and $data['consumerBillingAddress1'] = $this->getParameter('consumerBillingAddress1');
        $this->getParameter('consumerBillingAddress2') and $data['consumerBillingAddress2'] = $this->getParameter('consumerBillingAddress2');
        $this->getParameter('consumerBillingCity') and $data['consumerBillingCity'] = $this->getParameter('consumerBillingCity');
        $this->getParameter('consumerBillingState') and $data['consumerBillingState'] = $this->getParameter('consumerBillingState');
        $this->getParameter('consumerBillingCountry') and $data['consumerBillingCountry'] = $this->getParameter('consumerBillingCountry');
        $this->getParameter('consumerBillingZipCode') and $data['consumerBillingZipCode'] = $this->getParameter('consumerBillingZipCode');
        $this->getParameter('consumerBillingPhone') and $data['consumerBillingPhone'] = $this->getParameter('consumerBillingPhone');

        # Shipping details
        $this->getParameter('consumerShippingFirstName') and $data['consumerShippingFirstName'] = $this->getParameter('consumerShippingFirstName');
        $this->getParameter('consumerShippingLastName') and $data['consumerShippingLastName'] = $this->getParameter('consumerShippingLastName');
        $this->getParameter('consumerShippingAddress1') and $data['consumerShippingAddress1'] = $this->getParameter('consumerShippingAddress1');
        $this->getParameter('consumerShippingAddress2') and $data['consumerShippingAddress2'] = $this->getParameter('consumerShippingAddress2');
        $this->getParameter('consumerShippingCity') and $data['consumerShippingCity'] = $this->getParameter('consumerShippingCity');
        $this->getParameter('consumerShippingState') and $data['consumerShippingState'] = $this->getParameter('consumerShippingState');
        $this->getParameter('consumerShippingCountry') and $data['consumerShippingCountry'] = $this->getParameter('consumerShippingCountry');
        $this->getParameter('consumerShippingZipCode') and $data['consumerShippingZipCode'] = $this->getParameter('consumerShippingZipCode');
        $this->getParameter('consumerShippingPhone') and $data['consumerShippingPhone'] = $this->getParameter('consumerShippingPhone');

        $data['consumerIpAddress'] = $this->getConsumerIpAddress();
        $data['consumerUserAgent'] = $this->getConsumerUserAgent();
        $data['requestFingerprintOrder'] = $this->getFingerprintOrder($data);
        $data['requestFingerprint'] = $this->getFingerprint($data);

        return $data;
    }

    public function getFingerprint($data) {
    	$fingerPrintSeed = '';
    	$fingerPrintSeed.=$this->getSecret();

    	foreach ($data as $key => $value)
    	{
    		$fingerPrintSeed .= $value;
    	}

    	return hash('sha512', $fingerPrintSeed);
    }

    public function getFingerprintOrder($data) {
    	$fingerPrintOrder = 'secret,';

    	foreach ($data as $key => $value)
    	{
    		$fingerPrintOrder .= $key.',';
    	}

    	$fingerPrintOrder.= 'requestFingerprintOrder';

    	return $fingerPrintOrder;
    }
}
