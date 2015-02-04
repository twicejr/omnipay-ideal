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
class FetchIssuersResponse extends AbstractResponse
{
    public function rootElementExists(){
        return isset($this->getData()->Directory);
    }

    public function getDirectory() {
        if ($this->isSuccessful()) return $this->getData()->Directory;
        throw new ErrorResponseException();
    }

    public function getIssuers() {
        $issuers = array();

        foreach ($this->getDirectory()->Country as $country) {
            foreach ($country->Issuer as $issuer) {
                $id = (string) $issuer->issuerID;
                $issuers[(string)$country->countryNames][$id] = (string) $issuer->issuerName;
            }
        }

        return $issuers;
    }
}
