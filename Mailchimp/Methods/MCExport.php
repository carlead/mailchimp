<?php

namespace Carlead\MailchimpBundle\Mailchimp\Methods;

use Carlead\MailchimpBundle\Mailchimp\RestClient;

class MCExport extends RestClient {

    protected $url = 'export/1.0/';

    /**
     * Dump members of a list
     * @link http://apidocs.mailchimp.com/export/1.0/list.func.php Read mailchimp api docs
     * @param array $options
     * @param string $listId
     * @return array
     */
    public function DumpList($options = array(), $listId = false) {
        $api = $this->url . 'list/';
        if (!$listId)
            $listId = $this->listId;
        $payload = array_merge(array('id' => $this->listId), $options);
        $data = $this->requestMonkey($api, $payload, true);
        if (empty($data) || !isset($data))
            return $data;
        $result = preg_split('/$\R?^/m', $data);

        $headerArray = json_decode($result[0]);
        unset($result[0]);

        $data = array();
        foreach ($result as $value) {
            $data[] = array_combine($headerArray, json_decode($value));
        }

        return $data;
    }

    /**
     * Exports/dumps all Subscriber Activity for the requested campaign
     * 
     * @link http://apidocs.mailchimp.com/export/1.0/campaignsubscriberactivity.func.php campaignSubscriberActivity method
     * @param int $id
     * @param array $options
     * @return array
     */
    public function campaignSubscriberActivity($id, $options = array()) {
        $api = $api = $this->url . 'campaignSubscriberActivity/';

        $payload = array_merge(array('id' => $id), $options);
        $data = $this->requestMonkey($api, $payload, true);
        
        // If json_decode doesn't seem to work when there are separated objects
        if ($jData = json_decode($data,true)) {
            return $jData;
        }
        // We combine them into one object
        $data = preg_replace('/(}\s{)/',',',$data);
        return json_decode($data,true);
    }

}
