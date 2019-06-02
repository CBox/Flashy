<?php

class Flashy_Account {

    public function __construct(Flashy $master)
    {
        $this->master = $master;
    }

    /**
     * Get account info
     * @return array
     *     - return[]
     *         - success boolean true / false
     *         - errors array error list
     *         - account array
     */
    public function info()
    {
        $_params = array();

        $account = $this->master->call('account/info', $_params);

        return $account;
    }

    /**
     * Get account info
     * @return array
     *     - return[]
     *         - success boolean true / false
     *         - errors array error list
     *         - account array
     */
    public function connect($platform, $profile = null)
    {
        $_params = array("platform" => $platform, "profile" => $profile);

        $account = $this->master->call('platforms/connect', $_params);

        return $account;
    }
}