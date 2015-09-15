<?php

namespace Omnipay\Wirecard\Message;

use \Omnipay\Common\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest
{
    function getData()
    {
        return array();
    }

    function send()
    {
        return new Response($this, array('error' => null));
    }
}
