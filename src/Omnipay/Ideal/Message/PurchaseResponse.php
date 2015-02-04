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
class PurchaseResponse extends AbstractResponse
{
	public function rootElementExists(){
        return isset($this->getData()->Transaction) && isset($this->getData()->Issuer);
    }

    public function getIssuer() {
		if ($this->isSuccessful()) return $this->getData()->Issuer;
		throw new ErrorResponseException();
	}

	public function getTransaction(){
		if ($this->isSuccessful()) return $this->getData()->Transaction;
		throw new ErrorResponseException();
	}

	public function getIssuerAuthenticationURL() {
		return (string) $this->getIssuer()->issuerAuthenticationURL;
	}

	public function getTransactionID(){
		return (string) $this->getTransaction()->transactionID;
	}

	public function getTransactionCreateDateTimestamp() {
		return (string) $this->getTransaction()->transactionCreateDateTimestamp;
	}

	public function getPurchaseID() {
		return (string) $this->getTransaction()->purchaseID;
	}
}
