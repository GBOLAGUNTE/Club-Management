<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
    <style type="text/css">
        .box{
            width: 250px;
            height:250px;
            border: 1px solid #000;
            float: left;
        }
        .myimg{
            width: 200px;
            height: 200px;
        }
    </style>
</head>
<body>
    <?php
    $url = "api.naijapoetry.com/api/Poetry/GetRecentPoets";

    // step 1: initialize curl
    $curlsession = curl_init();

    // step 2: set curl options using the function curl_setopt()
    curl_setopt($curlsession, CURLOPT_URL, $url);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, true); // return the string instead of printing it out
    curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false); // do not verify ssl ceftificate

    // step 3: execute the call function
    $response = curl_exec($curlsession);

    // check if there is any error
    if(curl_error($curlsession) == true){
        die("Error: ".curl_error($curlsession));
    }
    
    // step 4:
    curl_close($curlsession);

    //step 5: Do whatever you want with the response
    $poets = json_decode($response); // convert json string to object
    // echo "<pre>";
    // print_r($poets->data);
    // echo "</pre>";

   if (count($poets->data) > 0) {
    foreach ($poets->data as $key => $value){
        // get poet image url
        if (empty($value->poetImageUrl)) {
            $imageurl = "avatar.png";
        }else {
            $imageurl = "http://naijapoetry.com".$value->poetImageUrl;
        }

        $surname = $value->surname;
        $firstname = $value->firstname;

        $content = "<div class='box'>";
        $content .= "<img src='$imageurl' alt ='$firstname image' class='myimg'>";
        $content .= "<p>$firstname $surname</p>";
        $content .= "<div>";

        echo $content;
    }
   } 



    ?>
</body>
</html>