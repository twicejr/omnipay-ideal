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

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * iDeal Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }
    
    public function isRedirect()
    {
        $data = $this->getData();
        return isset($data->Issuer->issuerAuthenticationURL);
    }
    
    public function getRedirectUrl()
    {
        return $this->getData()->Issuer->issuerAuthenticationURL;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }
    
    public function getRedirectData()
    {
        return null;
    }
    
	public function rootElementExists(){
        return isset($this->getData()->Transaction) && isset($this->getData()->Issuer);
    }

    public function getIssuer() {
		if ($this->getData()->Issuer) return $this->getData()->Issuer;
		throw new ErrorResponseException();
	}

	public function getTransaction(){
		if ($this->getData()->Transaction) return $this->getData()->Transaction;
		throw new ErrorResponseException();
	}

	public function getIssuerAuthenticationURL() {
		return (string) $this->getIssuer()->issuerAuthenticationURL;
	}

	public function getTransactionID(){
		return (string) $this->getTransaction()->transactionID;
	}

	public function getTransactionCreateDateTime() {
		return $this->dateTimeFromData($this->getTransaction()->transactionCreateDateTimestamp);
	}

	public function getPurchaseID() {
		return (string) $this->getTransaction()->purchaseID;
	}
}
