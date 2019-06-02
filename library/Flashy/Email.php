<?php

class Flashy_Email {

    public function __construct(Flashy $master) {
        $this->master = $master;
    }

    /**
     * Send a new text message through Flashy
     * @param struct $message the information on the message to send
     *     - subject
     *     - template @string (template id from Flashy)
     *     - html @string (html template if template id not used)
     *     - from @array
     *          - name @string
     *          - email @string
     *     - to @array
     *          - name @string
     *          - email @string
     *     - vars @array use variables
     * @param string $send_at when this message should be sent as a UTC timestamp in YYYY-MM-DD HH:MM:SS format. If you specify a time in the past, the message will be sent immediately. An additional fee applies for scheduled email, and this feature is only available to accounts with a positive balance.
     * @return array of structs for each recipient containing the key "email" with the email address, and details of the message status for that recipient
     *     - return[] struct the sending results for a single recipient
     *         - status string the sending status of the recipient - either "sent", "queued", "scheduled", "rejected", "failed" or "invalid"
     *         - errors array the reason for the rejection if the recipient status is "rejected" - one of "hard-bounce", "soft-bounce", "spam", "unsub", "custom", "invalid-sender", "invalid", "test-mode-limit", or "rule"
     *         - id string the message's unique id
     */
    public function send($email, $async=false, $send_at=null) {
        $_params = array("email" => $email, "async" => $async, "send_at" => $send_at);
        return $this->master->call('email/send', $_params);
    }
}