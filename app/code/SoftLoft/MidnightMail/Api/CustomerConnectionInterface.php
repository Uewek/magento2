<?php

namespace SoftLoft\MidnightMail\Api;

interface CustomerConnectionInterface
{
    /**
     * Set mail send status
     *
     * @return CustomerConnectionInterface
     */
    public function setMailSend(): CustomerConnectionInterface;
}
