<?php

require_once __DIR__ . '/AppConf.php';
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/lib/requests/Requests.php';
require_once __DIR__ . '/utils/Constants.php';
require_once __DIR__ . '/utils/Utils.php';

$channel = 'PDA05-C001';

function pagoNequi($telefono,$value) { // CHECK
    $restEndpoint = "/payments/v2/-services-paymentservice-unregisteredpayment";
    $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);

    $appCfg = new AppConf;
    $authController = new AuthController;

    $headers = array(
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => $authController->getToken(true),
        'x-api-key' => $appCfg->getApiKey()
    );

    $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

    $body = json_encode(array(
      "RequestMessage"  => array(
        "RequestHeader"  => array (
          "Channel" => 'PDA05-C001',
          "RequestDate" => gmdate("Y-m-d\TH:i:s\\Z"),
          "MessageID" => $messageId,
          "ClientID" => $appCfg->getClientId(),
          "Destination"=> array(
          "ServiceName"=> "PaymentsService", //Servicio que se quiere consumir
          "ServiceOperation"=> "unregisteredPayment", //Operación del servicio a consumir
          "ServiceRegion"=> "C001", //Región a la que pertenece el servicio, para panamá P001
          "ServiceVersion"=> "1.2.0" //Versión del servicio
          )
          ),
        "RequestBody"  => array (
          "any" => array (
            "unregisteredPaymentRQ" => array (
              "phoneNumber" => $telefono,
              "code" =>  "900053280", //NIT del comercio "900053280"900.053.280-8
              "value" => $value
              )
          )
        )
      )
    ));

    $request = Requests::post($endpoint, $headers, $body);

    if (
        isset($request->status_code) && $request->status_code == 200
        && isset($request->body) && !empty($request->body)
    ) {
        try {
            $response = json_decode($request->body);
            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    } else {
        throw new Exception('Unable to connect to Nequi, please check the information sent.');
    }
}

/**
 * Encapsula el consumo del servicio de validacion de cliente del API y retorna la respuesta del servicio
 */
function validarpagoNequi($transactionId) { // CHECK
  $restEndpoint = "/payments/v2/-services-paymentservice-getstatuspayment";

  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);

  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
    "RequestMessage"  => array(
      "RequestHeader"  => array (
        "Channel" => 'PDA05-C001',
        "RequestDate" => gmdate("Y-m-d\TH:i:s\\Z"),
        "MessageID" => $messageId,
        "ClientID" => $appCfg->getClientId(),
        "Destination"=> array(
        "ServiceName"=> "PaymentsService", //Servicio que se quiere consumir
        "ServiceOperation"=> "getStatusPayment", //Operación del servicio a consumir
        "ServiceRegion"=> "C001", //Región a la que pertenece el servicio, para panamá P001
        "ServiceVersion"=> "1.0.0" //Versión del servicio
        )
        ),
      "RequestBody"  => array (
        "any" => array (
        "getStatusPaymentRQ" => array(
        "codeQR" => $transactionId //Código del pago sea QR o transactionId
        )
        )
      )
    )
  ));

  $request = Requests::post($endpoint, $headers, $body);

  if (
      isset($request->status_code) && $request->status_code == 200
      && isset($request->body) && !empty($request->body)
  ) {
      try {
          $response = json_decode($request->body);
          return $response;
      } catch (Exception $e) {
          throw $e;
      }
  } else {
      throw new Exception('Unable to connect to Nequi, please check the information sent.');
  }
}

function reversarpagoNequi($telefono,$valor,$transactionId) {
  $restEndpoint = "/payments/v2/-services-reverseservices-reversetransaction";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);

  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
    "RequestMessage" => array(
      "RequestHeader" => array(
        "Channel" => 'PDA05-C001',
        "RequestDate"=> gmdate("Y-m-d\TH:i:s\\Z"),
          "MessageID" => $messageId,
          "ClientID" => $appCfg->getClientId(),
        "Destination" =>  array(
          "ServiceName" => "ReverseServices",
          "ServiceOperation" => "reverseTransaction",
          "ServiceRegion" => "C001",
          "ServiceVersion" => "1.0.0"
        )
      ),
      "RequestBody"  => array(
        "any"  => array(
          "reversionRQ"  => array(
            "phoneNumber" => $telefono,
            "value" => $valor,
            "code" => "900053280",
            "messageId" => $transactionId,
            "type" => "payment"
          )
        )
      )
    )
  ));



  $request = Requests::post($endpoint, $headers, $body);

  if (
      isset($request->status_code) && $request->status_code == 200
      && isset($request->body) && !empty($request->body)
  ) {
      try {
          $response = json_decode($request->body);
          return $response;
      } catch (Exception $e) {
          throw $e;
      }
  } else {
      throw new Exception('Unable to connect to Nequi, please check the information sent.');
  }
}

/**
 * Encapsula el consumo del servicio de validacion de cliente del API y retorna la respuesta del servicio
 */
function validateClient($phoneNumber, $value) { // CHECK
  $restEndpoint = "/agents/v2/-services-clientservice-validateclient";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);
  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
    'RequestMessage' => array(
        'RequestHeader' => array(
            'Channel' => 'MF-001',
            'RequestDate' => '2020-01-14T10:26:12.654Z',
            'MessageID' => '1234567890',
            'ClientID' => $appCfg->getClientId(),
            'Destination' => array(
                'ServiceName' => 'RechargeService',
                'ServiceOperation' => 'validateClient',
                'ServiceRegion' => 'C001',
                'ServiceVersion' => '1.4.0'
            )
        ),
        'RequestBody' => array(
            'any' => array(
                'validateClientRQ' => array(
                    // 'phoneNumber' => '399876464300', // Reemplace por este número para experimentar un error
                    'phoneNumber' => $phoneNumber,
                    'value' => $value
                )
            )
        )
    )
));



  $request = Requests::post($endpoint, $headers, $body);

  if (
      isset($request->status_code) && $request->status_code == 200
      && isset($request->body) && !empty($request->body)
  ) {
      try {
          $response = json_decode($request->body);
          return $response;
      } catch (Exception $e) {
          throw $e;
      }
  } else {
      throw new Exception('Unable to connect to Nequi, please check the information sent.');
  }
}

/**
 * Encapsula el consumo del servicio de nuevaSuscripcion del API y retorna la respuesta del servicio
 */
function nuevaSuscripcion($phoneNumber) { // CHECK
  $restEndpoint = "/subscriptions/v2/-services-subscriptionpaymentservice-newsubscription";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);
  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
  "RequestMessage" => array(
    "RequestHeader" => array(
      "Channel" => 'PDA05-C001',
      "RequestDate" => gmdate("Y-m-d\TH:i:s\\Z"),
        "MessageID" => $messageId,
        "ClientID" => $appCfg->getClientId(),
      "Destination" => array(
        "ServiceName" => "SubscriptionPaymentService",
        "ServiceOperation" => "newSubscription",
        "ServiceRegion" => "C001",
        "ServiceVersion" => "1.0.0"
      ),
    ),
    "RequestBody" => array(
      "any" => array(
        "newSubscriptionRQ" => array(
          "phoneNumber" => $phoneNumber,
          "code" => "900053280", //"900053280"
          "name" => "alter"
        )
      )
    )
  )
));



$request = Requests::post($endpoint, $headers, $body);

if (
    isset($request->status_code) && $request->status_code == 200
    && isset($request->body) && !empty($request->body)
) {
    try {
        $response = json_decode($request->body, true);
        return $response;
    } catch (Exception $e) {
        throw $e;
    }
} else {
    throw new Exception('Unable to connect to Nequi, please check the information sent.');
}
}

/**
 * Encapsula el consumo del servicio de validacion de cliente del API y retorna la respuesta del servicio
 */
function pagoNequiAutomatico($telefono,$value,$token) { // CHECK falta una pruebita con apk de prueba
  $restEndpoint = "/subscriptions/v2/-services-subscriptionpaymentservice-automaticpayment";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);
  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
  "RequestMessage" => array(
    "RequestHeader"=> array(
      "Channel" => 'PDA05-C001',
      "RequestDate"=> gmdate("Y-m-d\TH:i:s\\Z"),
        "MessageID" => $messageId,
        "ClientID" => $appCfg->getClientId(),
      "Destination"=> array(
        "ServiceName"=> "SubscriptionPaymentService",
        "ServiceOperation" => "automaticPayment",
        "ServiceRegion" => "C001",
        "ServiceVersion" => "1.0.0"
      ),
    ),
    "RequestBody"=> array(
      "any"=> array(
        "automaticPaymentRQ"=> array(
          "phoneNumber"=> $telefono,
          "code"=> "900053280", //"900053280"
          "value"=> $value,
          "token"=> $token
            )
          )
        )
      )
    ));



    $request = Requests::post($endpoint, $headers, $body);

    if (
        isset($request->status_code) && $request->status_code == 200
        && isset($request->body) && !empty($request->body)
    ) {
        try {
            $response = json_decode($request->body);
            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    } else {
        throw new Exception('Unable to connect to Nequi, please check the information sent.');
    }
}

  /**
 * Encapsula el consumo del servicio de validacion de cliente del API y retorna la respuesta del servicio
 */

function validarSuscripcion($telefono,$token){ // CHECK
  $restEndpoint = "/subscriptions/v2/-services-subscriptionpaymentservice-getsubscription";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);
  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
    "RequestMessage" => array(
      "RequestHeader" => array(
        "Channel" => 'PDA05-C001',
        "RequestDate" => "2017-06-21T20:26:12.654Z",
        "MessageID" => "1234567890",
        "ClientID" => $appCfg->getClientId(),
        "Destination"  => array(
          "ServiceName" => "SubscriptionPaymentService",
          "ServiceOperation" => "getubscription",
          "ServiceRegion" => "C001",
          "ServiceVersion" => "1.0.0"
        )
      ),
      "RequestBody" => array(
        "any" => array(
          "getSubscriptionRQ" => array(
            "phoneNumber" => $telefono,
            "code" => "900053280", //900053280
            "token" => $token
          )
        )
      )
    )
  ));



  $request = Requests::post($endpoint, $headers, $body);

  if (
    isset($request->status_code) && $request->status_code == 200
    && isset($request->body) && !empty($request->body)
  ) {
    try {
        $response = json_decode($request->body, true);
        return $response;
    } catch (Exception $e) {
        throw $e;
    }
  } else {
        throw new Exception('Unable to connect to Nequi, please check the information sent.');
  }
}
  /**
 * Encapsula el consumo del servicio de validacion de cliente del API y retorna la respuesta del servicio
 */

function cancelarTransaccion($telefono,$valor,$messageid2){
  //echo "IDCliente: $clientId Telefono: ".$telefono." Valor: ".$valor." IDReferencia: ".$messageid; die();
  $restEndpoint = "/subscriptions/v2/-services-reverseservices-reversetransaction";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 10);
  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
  "RequestMessage" => array(
    "RequestHeader" => array(
      "Channel" => 'PDA05-C001',
      "RequestDate"=> gmdate("Y-m-d\TH:i:s\\Z"),
        "MessageID" => $messageId,
        "ClientID" => $appCfg->getClientId(),
      "Destination" =>  array(
        "ServiceName" => "ReverseServices",
        "ServiceOperation" => "reverseTransaction",
        "ServiceRegion" => "C001",
        "ServiceVersion" => "1.0.0"
      )
    ),
    "RequestBody"  => array(
      "any"  => array(
        "reversionRQ"  => array(
          "phoneNumber" => $telefono,
          "value" => $valor,
          "code" => "900053280",
          "messageId" => $messageid2,
          "type" => "automaticPayment"
        )
      )
    )
  )
));



$request = Requests::post($endpoint, $headers, $body);

if (
    isset($request->status_code) && $request->status_code == 200
    && isset($request->body) && !empty($request->body)
) {
    try {
        $response = json_decode($request->body);
        return $response;
    } catch (Exception $e) {
        throw $e;
    }
} else {
    throw new Exception('Unable to connect to Nequi, please check the information sent.');
}
}

function validarpagoSuscripcion($transactionId){
  //echo "IDCliente: $clientId Telefono: ".$telefono." Valor: ".$valor." IDReferencia: ".$messageid; die();
  $restEndpoint = "/subscriptions/v2/-services-subscriptionpaymentservice-getstatuspayment";
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 10);
  $appCfg = new AppConf;
  $authController = new AuthController;

  $headers = array(
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $authController->getToken(true),
      'x-api-key' => $appCfg->getApiKey()
  );

  $endpoint = $appCfg->getApiBasePath() . $restEndpoint;

  $body = json_encode(array(
    "RequestMessage" => array(
      "RequestHeader"=> array(
        "Channel" => 'PDA05-C001',
        "RequestDate"=> gmdate("Y-m-d\TH:i:s\\Z"),
          "MessageID" => $messageId,
          "ClientID" => $appCfg->getClientId(),
        "Destination" => array(
          "ServiceName" => "PaymentsService",
          "ServiceOperation" => "getStatusPayment",
          "ServiceRegion" => "C001",
          "ServiceVersion" => "1.0.0"
        )
        ),
      "RequestBody" => array(
        "any" => array(
          "getStatusPaymentRQ" => array(
            "codeQR" => $transactionId
          )
        )
      )
    )
  ));



$request = Requests::post($endpoint, $headers, $body);

if (
    isset($request->status_code) && $request->status_code == 200
    && isset($request->body) && !empty($request->body)
) {
    try {
        $response = json_decode($request->body);
        return $response;
    } catch (Exception $e) {
        throw $e;
    }
} else {
    throw new Exception('Unable to connect to Nequi, please check the information sent.');
}
}

?>
