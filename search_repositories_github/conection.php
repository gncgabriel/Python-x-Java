<?php
function executaQuery($query, $token)
{

    
    $ch = curl_init('https://api.github.com/graphql');
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'user-agent: index.php',
            'Content-Lenght: 9999999999999'
        ),
        CURLOPT_POSTFIELDS => json_encode($query)
    ));

    // Send the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch)["http_code"];

    if ($response === FALSE) {
        die(curl_error($ch));
    }

    $responseData = json_decode($response, TRUE);

    if ($httpCode != 200) {
        if ($httpCode == 401) {
            echo "\r\n(401) - Erro no token de acesso: " . $responseData['message'];
            die;
        } else if ($httpCode == 403) {
            echo "\r\nErro ($httpCode) - " . $responseData['message'];
            sleep(2);
        } else if ($httpCode == 502) {
            echo "\r\nErro ($httpCode) - " . $responseData['errors'][0]['message'];
            sleep(2);
        } else {
            echo "\r\nErro ($httpCode) - ";
            var_dump($responseData);
        }
    }

    return $responseData;
}
