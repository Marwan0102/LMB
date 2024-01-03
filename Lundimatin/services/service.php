<?php

class APIClient
{
    private $baseURL;
    private $username;
    private $password;
    private $token;

    public function __construct($baseURL, $username, $password)
    {
        $this->baseURL = $baseURL;
        $this->username = $username;
        $this->password = $password;
    }

    private function authenticate()
    {
        $url = $this->baseURL . "/api/auth";

        $data = array(
            "username" => $this->username,
            "password" => $this->password,
            "password_type" => 0,
            "code_application" => "webservice_externe",
            "code_version" => "1"
        );

        $headers = array(
            'Content-Type: application/json',
            'Accept: application/api.rest-v1+json',
        );

        $response = $this->makeRequest($url, 'POST', $data, $headers);

        $authResponse = json_decode($response, true);

        if ($authResponse && isset($authResponse["code"]) && $authResponse["code"] == 200 && isset($authResponse["datas"]["token"])) {
            $this->token = $authResponse["datas"]["token"];
        } else {
            echo "\nErreur d'authentification.";
        }
    }

    private function makeRequest($url, $method, $data = array(), $headers = array())
    {
        $curl = curl_init();

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => ($method == 'POST' || $method == 'PUT') ? json_encode($data) : http_build_query($data),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_CIPHER_LIST => 'AES128-SHA',
        );

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);

        return $response;
    }

    public function getClients($clientId = null, $params = array())
    {
        $this->authenticate();

        if (!$this->token) {
            return;
        }

        $urlClients = $this->baseURL . "/api/clients";

        if (!is_null($clientId)) {
            $urlClients .= '/' . urlencode($clientId);
        }

        if (!empty($params)) {
            $urlClients .= '?' . http_build_query($params);
        }

        $headersClients = array(
            'Content-Type: application/json',
            'Accept: application/api.rest-v1+json',
            'Authorization: Basic ' . base64_encode(":$this->token")
        );

        $responseClients = $this->makeRequest($urlClients, 'GET', array(), $headersClients);

        $clientsResponse = json_decode($responseClients, true);

        if ($clientsResponse && isset($clientsResponse["code"]) && $clientsResponse["code"] == 200) {
            return $clientsResponse["datas"];
        }
    }

    public function getClient($clientId)
    {
        $this->authenticate();

        if (!$this->token) {
            return;
        }

        $urlClient = $this->baseURL . "/api/clients/" . urlencode($clientId);

        $headersClient = array(
            'Content-Type: application/json',
            'Accept: application/api.rest-v1+json',
            'Authorization: Basic ' . base64_encode(":$this->token")
        );

        $responseClient = $this->makeRequest($urlClient, 'GET', array(), $headersClient);

        $clientResponse = json_decode($responseClient, true);

        if ($clientResponse && isset($clientResponse["code"]) && $clientResponse["code"] == 200) {
            return $clientResponse["datas"];
        }
    }

    public function updateClient($clientId, $data)
    {
        $this->authenticate();

        if (!$this->token) {
            return;
        }

        $urlUpdateClient = $this->baseURL . "/api/clients/" . urlencode($clientId);

        $headersUpdateClient = array(
            'Content-Type: application/json',
            'Accept: application/api.rest-v1+json',
            'Authorization: Basic ' . base64_encode(":$this->token")
        );

        $responseUpdateClient = $this->makeRequest($urlUpdateClient, 'PUT', $data, $headersUpdateClient);

        $updateClientResponse = json_decode($responseUpdateClient, true);

        if ($updateClientResponse && isset($updateClientResponse["code"]) && $updateClientResponse["code"] == 200) {
            return $updateClientResponse["datas"];
        }
    }
}

$apiClient = new APIClient("https://evaluation-technique.lundimatin.biz", "test_api", "api123456");
