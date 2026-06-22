<?php

$data = [
    "customer_name" => "John Doe",
    "items" => [
        [
            "product_id" => 1,
            "quantity" => 2
        ]
    ]
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "POST",
        "content" => json_encode($data)
    ]
];

$context = stream_context_create($options);

$result = file_get_contents("http://oms.local/api/v1/orders", false, $context);

echo $result;