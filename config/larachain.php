<?php

return [

    /**
     * Pretty self-explanatory, but for those of you who just
     * don't get it, it is the URL to the Blockchain.info API.
     */
    'api_url' => 'https://blockchain.info/',

    /**
     * When creating temporary gateway addresses, if no target
     * wallet is specified, this will be used by default.
     */

    'default_wallet' => '',

    /**
     * In case of having an API key, you can specify it here,
     * basically it allows you to bypass the API request limits.
     *
     * @link https://blockchain.info/es/api/api_create_code
     */

    'api_code' => '',

    /**
     * Default callback URL, basically Blockchain will contact
     * that address after a successful deposit into a gateway
     * address.
     * 
     * @link https://blockchain.info/es/api/api_receive
     */

    'callback_url' => '',

    /**
     * Callback secret authentication token, used to verify
     * callback requests and make sure that they come from
     * Blockchain's API.
     * 
     * @link https://blockchain.info/es/api/api_receive
     */

    'secret_token' => 'SomeRandomString'

];