<?php

include('config.php');

// open a connection the API as a stream.

// Your authentication ID/token (obtained in your SmartyStreets account)
$authId = urlencode("authId");
$authToken = urlencode("authToken");

$addresses = array(
    array(
        "street" => $_POST['street'],
        "city"   => $_POST['city'],
        "state"  => $_POST['state'],
        "candidates" => 1
    )
);

// LiveAddress API expects JSON input by default, but you could send XML
// if you set the Content-Type header to "text/xml".
$post = json_encode($addresses);

// Create the stream context (like metadata)
$context = stream_context_create(
    array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-Type: application/x-www-form-urlencoded\r\n"
                ."Content-Length: ".strlen($post)."\r\n",
            "content" => $post
        )
    )
);

// Do the request
$page = file_get_contents("https://api.smartystreets.com/street-address/?auth-id={$authId}&auth-token={$authToken}", false, $context);

// Show results
print_r($page);

$pageArr = json_decode($page, true);

if (!empty($pageArr)){

    $sqlQuery = "INSERT INTO `address_validated` (`delivery_line_1`, `city`, `state_abbreviation`, `zipcode`)
                 VALUES ('{$pageArr[0]['delivery_line_1']}', '{$pageArr[0]['components']['city_name']}', '{$pageArr[0]['components']['state_abbreviation']}', '{$pageArr[0]['components']['zipcode']}');";

    $result    = $mysqli->query($sqlQuery);
    $insert_id = $mysqli->insert_id;

    $sqlQuery = "INSERT INTO `address_input` (`delivery_line_1`, `city`, `state_abbreviation`, `address_validated_id`)
                 VALUES ('{$addresses[0]['street']}', '{$addresses[0]['city']}', '{$addresses[0]['state']}', '{$insert_id}');";

    $result = $mysqli->query($sqlQuery);

    $mysqli->close();

}

?>
