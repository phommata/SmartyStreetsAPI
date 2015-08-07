<?php

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SmartyStreets API</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Validate US address</h2>
    <form role="form" id="myForm" action="post_without_curl2-INPUT.php" method="POST">
        <div class="form-group">
            <label for="street">street:</label>
            <input type="text" class="form-control" id="street" name="street" placeholder="Enter street">
        </div>
        <div class="form-group">
            <label for="city">city:</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
        </div>
        <div class="form-group">
            <label for="state">state:</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="Enter state">
        </div>

        <button type="submit" class="btn btn-default">Submit</button>
    </form>

    <hr>

    <h4>Validated Addresses</h4>

    <table id="result" class="table table-striped table-bordered table-hover">
        <tr>
            <th>street</th>
            <th>city</th>
            <th>state</th>
            <th>zipcode</th>
        </tr>
    </table>
</div>

<script>
// Attach a submit handler to the form
$( "#myForm" ).submit(function( event ) {

    // Stop form from submitting normally
    event.preventDefault();

    // Send the data using post
    var posting = $.post( "smartystreets_API.php", $( "#myForm" ).serialize() );

    // Put the results in a div
    posting.done(function( data ) {

        data = JSON.parse(data);

        if (data.length !== 0){
            var $tr = $("<tr></tr>");
            $tr.append("<td>" + data[0].delivery_line_1 + "</td>");
            $tr.append("<td>" + data[0].components.city_name + "</td>");
            $tr.append("<td>" + data[0].components.state_abbreviation + "</td>");
            $tr.append("<td>" + data[0].components.zipcode + "</td>");

            $( "#result" ).append( $tr );
        }

    });

});
</script>

</body>
</html>
';
?>
