<?php

require_once __DIR__ . '/AppConf.php';
require_once __DIR__ . '/lib/requests/Requests.php';

function curl_request($url,$authentication){  

    $ch = curl_init($url);
    $options = array(
            CURLOPT_RETURNTRANSFER => true,         // return web page
            CURLOPT_HEADER         => false,        // don't return headers
            CURLOPT_FOLLOWLOCATION => false,         // follow redirects
           // CURLOPT_ENCODING       => "utf-8",           // handle all encodings
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 20,          // timeout on connect
            CURLOPT_TIMEOUT        => 20,          // timeout on response
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,
            CURLOPT_POST            => 1,            // i am sending post data
            CURLOPT_HTTPHEADER     => array(
                "Authorization: Basic $authentication",
                "Accept : application/json",
                "Content-Type: application/x-www-form-urlencoded"
            )

    );

    curl_setopt_array($ch,$options);
    $data = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    //echo $curl_errno;
    //echo $curl_error;
    curl_close($ch);
    return $data;
  }

Requests::register_autoloader();

class AuthController {
    private $appCfg;
    private $token;
    private $tokenType;
    private $tokenExpiresAt;

    public function __construct() {
        $this->appCfg = new AppConf;
    }

    private function auth() {
        try {
            $authorization = base64_encode($this->appCfg->getClientId() . ':' . $this->appCfg->getClientSecret());

            $headers = array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
                'Authorizationss' => $authorization
            );
            $endpoint = $this->appCfg->getAuthUri()."?grant_type=client_credentials";

            $request = curl_request($endpoint, $authorization);
            if (
                !empty($request)
            ) {
                $response = json_decode($request);

                $this->tokenExpiresAt = new DateTime();
                $this->tokenExpiresAt->add(new DateInterval('PT' . $response->expires_in . 'S'));
                $this->token = $response->access_token;
                $this->tokenType = $response->token_type;
            } else {
                throw new Exception('Unable to connect to Nequi, please check the information sent.');
            }
            
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getToken($full = false) {
        if (!$this->isValidToken()) {
            $this->auth();
        }

        return $full ? $this->tokenType . ' ' . $this->token : $this->token;
    }

    public function isValidToken() {
        if (!isset($this->tokenExpiresAt)) {
            return false;
        }

        return new DateTime() < $this->tokenExpiresAt;
    }
}

?>