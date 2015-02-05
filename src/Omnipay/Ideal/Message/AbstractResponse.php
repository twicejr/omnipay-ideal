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

use DateTime;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Ideal\Exception\ErrorResponseException;

/**
 * iDeal Response
 */
abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return !$this->isErrorResponse() && isset($this->getData()->Acquirer) && $this->rootElementExists();
    }

    public function isErrorResponse()
    {
        return isset($this->getData()->Error);
    }

    public abstract function rootElementExists();

    public function getAcquirerID()
    {
        if ($this->isSuccessful()) return (string) $this->getData()->Acquirer->acquirerID;
        throw new ErrorResponseException();
    }

    public function getData() {
        return $this->data;
    }

    public function getCreateDateTime()
    {
        return $this->dateTimeFromData($this->getData()->createDateTimestamp);
    }

    public function getError() {
        if ($this->isErrorResponse()) return $this->getData()->Error;
        throw new InvalidResponseException();
    }

    public function getErrorCode() {
        return $this->getError()->errorCode;
    }

    public function getErrorMessage() {
        return $this->getError()->errorMessage;
    }

    public function getErrorDetail() {
        return $this->getError()->errorDetail;
    }

    public function getSuggestedAction() {
        return $this->getError()->suggestedAction;
    }

    public function getConsumerMessage() {
        return $this->getError()->consumerMessage;
    }

    protected function dateTimeFromData($data)
    {
        return new DateTime((string) $data);
    }
}
