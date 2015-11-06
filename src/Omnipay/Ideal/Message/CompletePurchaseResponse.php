<?php

/*
 * This file is part of the Omnipay package.
 *
 * (c) Adrian Macneil <adrian@adrianmacneil.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omnipay\Ideal\Message;
use Omnipay\Ideal\Exception\ErrorResponseException;

/**
 * iDeal Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function rootElementExists(){
        return isset($this->getData()->Transaction);
    }

    public function isErrorResponse()
    {
        return $this->getData()->Transaction->status != 'Success';
    }
    
    public function getTransaction(){
        if ($this->isSuccessful()) return $this->getData()->Transaction;
        throw new ErrorResponseException();
    }

    //@todo: make this getTransactionReference? because... transactionID IS IDEAL REFERENCE!?
    public function getTransactionID(){
        return (string) $this->getTransaction()->transactionID;
    }

    public function getStatus(){
        return (string) $this->getTransaction()->status;
    }

    public function getStatusDateTime(){
        return $this->dateTimeFromData($this->getTransaction()->statusDateTimestamp);
    }

    public function getConsumerName(){
        return (string) $this->getTransaction()->consumerName;
    }

    public function getConsumerIBAN(){
        return (string) $this->getTransaction()->consumerIBAN;
    }

    public function getConsumerBIC(){
        return (string) $this->getTransaction()->consumerBIC;
    }

    public function getAmount(){
        return (string) $this->getTransaction()->Amount;
    }

    public function getCurrency(){
        return (string) $this->getTransaction()->Currency;
    }
}
