<?php
try {
    $client = new SoapClient(null, [
        'uri' => "http://localhost/Version1-pizzas-webSeminar/SOAP-client/server.php",
        'location' => "http://localhost/Version1-pizzas-webSeminar/SOAP-client/server.php"
    ]);

    // Get pizzas
    $pizzas = $client->__soapCall("getPizzas", []);
    print_r($pizzas);

    // Get categories
    $categories = $client->__soapCall("getCategories", []);
    print_r($categories);

    // Get orders
    $orders = $client->__soapCall("getOrders", []);
    print_r($orders);
} catch (SoapFault $e) {
    echo "Error: {$e->getMessage()}";
}
