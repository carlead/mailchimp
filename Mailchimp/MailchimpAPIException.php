<?php

namespace Carlead\MailchimpBundle\Mailchimp;

class MailchimpAPIException extends \Exception {

    public function __construct($data) {
        parent::__construct(sprintf('Mailchimp API error : [ %s ] %s , code = %s', $data['name'], $data['error'], $data['code']),$data['code']);
    }

}