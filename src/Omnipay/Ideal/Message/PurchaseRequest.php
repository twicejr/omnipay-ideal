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
use Omnipay\Common\Message\RequestInterface;

/**
 * iDeal Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('issuer', 'amount', 'currency', 'returnUrl', 'purchaseId');

        $data = $this->getBaseData('AcquirerTrxReq');
        $data->Issuer->issuerID = $this->getIssuer();
        $data->Merchant->merchantID = $this->getMerchantId();
        $data->Merchant->subID = $this->getSubId();
        $data->Merchant->merchantReturnURL = $this->getReturnUrl();
        $data->Transaction->purchaseID = $this->getPurchaseId();
        $data->Transaction->amount = $this->getAmount();
        $data->Transaction->currency = $this->getCurrency();
        $data->Transaction->expirationPeriod = static::EXPIRATION_PERIOD;
        $data->Transaction->language = static::LANGUAGE;
        $data->Transaction->description = $this->getDescription();
        $data->Transaction->entranceCode = sha1(uniqid());

        return $data;
    }

    /** @return PurchaseResponse */
    public function parseResponse(RequestInterface $request, $data){
        return new PurchaseResponse($request, $data);
    }
}
