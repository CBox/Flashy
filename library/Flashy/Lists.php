<?php

class Flashy_Lists {

    public function __construct(Flashy $master) {
        $this->master = $master;
    }

    /**
     * Subscribe contact to list
     * @param struct $subscriber
     *     - email string required valid email address.
     *     - phone string of subscriber phone number.
     *     - first_name string of recipient phone number.
     *     - last_name string text message that will be sent
     *     - source string contact source.
     * @return array of structs 
     *     - return[] struct the sending results for a single recipient
     *         - status string "success" or failed
     *         - errors array error list
     *         - subscriber array if the subscription created successfully
     */
    public function subscribe($list_id, $subscriber) {
        $_params = array("subscriber" => $subscriber);
        return $this->master->call('lists/' . $list_id .'/subscribe', $_params);
    }
}