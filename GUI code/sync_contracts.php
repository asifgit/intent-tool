<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="content/svg/policy-icon.png">

      <title>Intent System</title>

      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="css/form-validation.css" rel="stylesheet">

      <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
  </head>

  <body class="bg-light">

    <h1 id="top-message">...</h1>
    <div id="cy"></div>
    <!-- Load application code at the end to ensure DOM is loaded -->
    <!-- <script src="cytoscape/js/code.js"></script>   -->

    <?php

      $endpoint = "http://117.17.102.171:8080/servlet/REST";

      $curl = curl_init($endpoint);
      curl_setopt($curl, CURLOPT_POST, 1);

      $result = curl_exec($curl);

      if($result){
        header('Location: index.php');
      }
      else{
        echo  '<div class="container">'
          .     '<div class="row">' 
          .       '<div class="col-md-10 offset-1">'
          .         '<div class="alert alert-danger" role="alert" style="margin-top: 100px;">'
          .           '<h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i> Error</h4>'
          .           '<ul>'
          .             '<li>' . 'Could not sync the contracts. Please try again' . '</li>'
          .           '</ul>'
          .           '<hr>'
          .           '<p class="mb-0">' 
          .             '<ul><a href="index.php" class="alert-link">' 
          .               '<i class="fa fa-arrow-circle-left"></i> Go back' 
          .             '</a></ul>' 
          .           '</p>'
          .         '</div>'
          .       '</div>'
          .     '</div>'
          .   '</div>';
      }
    ?>

</body></html>