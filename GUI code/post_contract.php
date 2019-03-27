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
		<?php

			$servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "vocabulary-store";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else{

            	$name			= $_POST["name"];
				$architecture	= $_POST["architecture"];
				/*$snssai			= $_POST["snssai"];*/
				$snssai			= $_POST["snssai"];
				$unit			= 'MB';//$_POST["unit"];
				$isCustom		= $_POST["cSnssai"];
				$cUprate		= $_POST["cUprate"];
				$cDownrate		= $_POST["cDownrate"];

				$loopQueryOk = true;
				$customQueryOk = true;

				if(isset($_POST['snssai'])){
					if (is_array($_POST['snssai'])) {
						$ctr = 0;
						foreach($_POST['snssai'] as $value){
							$sql =	"INSERT INTO `xontracts` " 
			            		.		"(`name`, `arch_id`, `s_nssai`, `uprate`, `downrate`, `unit`) " 
			            		.	"VALUES " 
			            		.		"('".$name."-".(++$ctr)."','" .$architecture."','" .$value."', " 
			            		.			"(SELECT `uprate` FROM `snssais_supported` WHERE `snssai`=" . $value ." ), " 
			            		.			"(SELECT `downrate` FROM `snssais_supported` WHERE `snssai`=" . $value ." ), " 
			            		.			"'" .$unit."')";
			              	$result = $conn->query($sql);

			              	if ($result === TRUE) {
							    //echo "New record created successfully";
							    $loopQueryOk = true;
							} else{
								$loopQueryOk = false;
								echo	'<div class="container">'
							    	.		'<div class="row">' 
							    	.			'<div class="col-md-10 offset-1">'
							    	.				'<div class="alert alert-danger" role="alert" style="margin-top: 100px;">'
									.					'<h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i> Error</h4>'
									.					'<ul><li>' 
									.						$conn->error
									.					'</li></ul>'
									.					'<hr>'
									.					'<p class="mb-0">' 
									.						'<ul><a href="index.php" class="alert-link">' 
									.							'<i class="fa fa-arrow-circle-left"></i> Go back' 
									.						'</a></ul>' 
									.					'</p>'
									.				'</div>'
									.			'</div>'
									.		'</div>'
									.	'</div>';
							}
						}
					} else {
						// do nothing
					}
				}
				if($isCustom == 'on'){
					$customTxt = "";
					$sqlCustom =	"INSERT INTO `xontracts` " 
	            		.		"(`name`, `arch_id`, `s_nssai`, `uprate`, `downrate`, `unit`) " 
	            		.	"VALUES " 
	            		.		"('".$name.$customTxt."','".$architecture."','127','".$cUprate."','".$cDownrate."','".$unit."')";
	            	$resultCustom = $conn->query($sqlCustom);

	              	if ($resultCustom === TRUE) {
					    //echo "New record created successfully";
					    $customQueryOk = true;
					} else{
						$customQueryOk = false;
						echo	'<div class="container">'
					    	.		'<div class="row">' 
					    	.			'<div class="col-md-10 offset-1">'
					    	.				'<div class="alert alert-danger" role="alert" style="margin-top: 100px;">'
							.					'<h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i> Error</h4>'
							.					'<ul><li>' 
							.						$conn->error
							.					'</li></ul>'
							.					'<hr>'
							.					'<p class="mb-0">' 
							.						'<ul><a href="index.php" class="alert-link">' 
							.							'<i class="fa fa-arrow-circle-left"></i> Go back' 
							.						'</a></ul>' 
							.					'</p>'
							.				'</div>'
							.			'</div>'
							.		'</div>'
							.	'</div>';
					}

				}

            	$conn->close();

            	if($loopQueryOk && $customQueryOk){
            		header('Location: index.php');
            	} else{
            		// do nothing
            	}
            	
            }

		?>
	</body>
</html>