<?php

namespace Omnipay\Wirecard;

use Omnipay\Common\AbstractGateway;

/**
 * Wirecard Gateway
 *
 * @link https://integration.wirecard.at/doku.php/wcs:frontend_init
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Wirecard';
    }

    public function getDefaultParameters()
    {
        return array(
            'customerId' => '',
        	'secret' => '',
        	'paymentType' => '',
        		
        );
    }
    
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }
    
    public function getSecret()
    {
    	return $this->getParameter('secret');
    }
    
    public function setSecret($value)
    {
    	return $this->setParameter('secret', $value);
    }
    
    public function getPaymentType()
    {
    	return $this->getParameter('paymentType');
    }
    
    public function setPaymentType($value)
    {
    	return $this->setParameter('paymentType', $value);
    }

    public function dataStorage(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\DataStorageRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\PurchaseRequest', $parameters);
    }

    /**
     * Just a dummy request for now, which will be always successful.
     *
     * Will have to figure out how to handle this, since Wirecard transfers any payment info
     * trough a separate server to server request, and not via the callback URLs.
     *
     * @param array $paramters Message parameters
     * @return Omnipay\Wirecard\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\CompletePurchaseRequest', $parameters);
    }
}
