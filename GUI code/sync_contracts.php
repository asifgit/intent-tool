<?php

	$curl_request = 'curl -H "xos-username: xosadmin@opencord.org" -H "xos-password: tWCwPIMLEaZwvdySSTzU" -X POST --data-binary @src/TOSCA/IBN-slices.yml.j2 http://220.149.42.106:9001/xos-tosca//run'; 

	$curl = curl_init('http://220.149.42.106:9001/xos-tosca//run');

	curl_setopt($curl, CURLOPT_POST, 1);

	curl_setopt(
		$curl, 
		CURLOPT_HTTPHEADER, 
		array(
			'xos-username: xosadmin@opencord.org', 
			'xos-password: tWCwPIMLEaZwvdySSTzU'
		)
	);

	$result = curl_exec($curl);

	if($result){
		echo 'hi';
	}
	else{
		echo 'bye';
	}

	/*if(isset($_POST['snssai'])){
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

	}*/

?>