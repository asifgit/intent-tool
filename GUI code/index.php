<!DOCTYPE html>
<html lang="en"><head>
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        Intent System&emsp;&emsp;&emsp;&emsp;
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contracts.php">Contracts</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="content/svg/policy-icon.png" alt="" width="72" height="72">
        <h2>System Contracts</h2>
        <p class="lead">This application allows the end user to define high level contracts.</p>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <?php

            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "vocabulary-store";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else{

              $sql =  "SELECT COUNT(*) AS number_of_contracts FROM `xontracts` ";
              $result1 = $conn->query($sql);

              if($result1->num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                  echo  '<h4 class="d-flex justify-content-between align-items-center mb-3">' 
                    .     '<span class="text-muted">Contracts</span>' 
                    .     '<span class="text-muted" title="Sync all contracts">' 
                    .       '<form action="sync_contracts.php">'
                    .         '<button class="btn fa fa-refresh fa-md text-muted" ></button>' 
                    .       '</form>'
                    .     '</span>'
                    .     '<span class="badge badge-info badge-pill">' . $row['number_of_contracts'] . '</span>'
                    .   '</h4>';
                }
              }
              else{
                echo  '<h4 class="d-flex justify-content-between align-items-center mb-3">' 
                  .     '<span class="text-muted">Contracts</span>' 
                  .     '<span class="badge badge-info badge-pill">0</span>'
                  .   '</h4>';
              }

              $sql =  "SELECT cont.`id`, cont.`name`, cont.`arch_id`, cont.`s_nssai`, cont.`uprate`, cont.`downrate`, cont.`unit`, arch.`architecture_name`, cont.`is_synced` " 
                    . "FROM `xontracts` AS cont "
                    . "INNER JOIN architectures_supported AS arch ON cont.`arch_id` = arch.`id` " 
                    . "ORDER BY cont.`id`";
              $result2 = $conn->query($sql);

              echo '<ul class="list-group mb-3">';

              if ($result2->num_rows > 0) {
                  // output data of each row
                  while($row = $result2->fetch_assoc()) {
                      $iconClass = ($row['is_synced']==1?'fa-check-square text-success':'fa-refresh text-warning');
                      $iconTitle = ($row['is_synced']==1?'synced':'to be synced');

                      echo  '<li class="list-group-item d-flex justify-content-between lh-condensed">' 
                        .     '<div>'
                        .       '<h6 class="my-0"><a href="graph.php?id=' . $row['id'] . '">' . $row['name'] . ' (' . $row['architecture_name'] . ')</a></h6>' 
                        .       '<small class="text-muted">' 
                        .         'QoS:' . (($row['s_nssai']==127)?"Custom":$row['s_nssai'])
                        .         ', uprate:' . $row['uprate'] 
                        .         ', downrate:' . $row['downrate'] 
                        .       '</small>' 
                        .     '</div>' 
                        .     '<span class="text-muted">' 
                        .       '<i class="fa fa-lg ' . $iconClass . '" title="' . $iconTitle . '"></i>' 
                        .     '</span>' 
                        .   '</li>';
                      //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                  }
              } else {
                  echo  '<li class="list-group-item d-flex justify-content-between lh-condensed">' 
                    .     '<div>'
                    .       '<h6 class="my-0">No contracts found.</h6>' 
                    .     '</div>'
                    .   '</li>';
              }

              echo '</ul>';

              $conn->close();
            }
          ?>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Contract Information</h4>
          <form class="needs-validation" novalidate="" action="post_contract.php" method="POST">
            <div class="row">
              <div class="col-md-12 mb-6">
                <label for="orchestrator">Orchestrator</label>
                <select class="custom-select d-block w-100" id="orchestrator" name="orchestrator" required="">
                  <option value="">Select...</option>
                  <option value="1">M-CORD</option>
                  <option value="2">OSM</option>
                </select>
                <div class="invalid-feedback">
                  Please select an orchestrator.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7 mb-3">
                <label for="name">Contract name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="xyz" required="">
                <div class="invalid-feedback">
                  Contract name is required.
                </div>
              </div>
              <div class="col-md-5 mb-3">
                <label for="architecture">Architecture</label>
                <select class="custom-select d-block w-100" id="architecture" name="architecture" required="">
                  <option value="">Choose...</option>
                  <?php

                    $servername = "127.0.0.1";
                    $username = "root";
                    $password = "";
                    $dbname = "vocabulary-store";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    else{
                      
                      $sql =  "SELECT `id`, `architecture_name`, `description`, `modules` FROM `architectures_supported` " 
                            . "ORDER BY `architecture_name`";
                      $result3 = $conn->query($sql);

                      if ($result3->num_rows > 0) {
                          // output data of each row
                          while($row = $result3->fetch_assoc()) {
                              $archSelected = ($row['architecture_name']=='LTE'?'selected="selected" ':'');
                              echo  '<option value="' . $row['id'] . '" ' . $archSelected . ' >' 
                                .     $row['architecture_name']
                                .   '</option>';
                              //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                          }
                      }
                      
                      $conn->close();
                    }
                  ?>
                </select>
                <div class="invalid-feedback">
                  Please select an architecture.
                </div>
              </div>
                <?php

                  $servername = "127.0.0.1";
                  $username = "root";
                  $password = "";
                  $dbname = "vocabulary-store";

                  // Create connection
                  $conn = new mysqli($servername, $username, $password, $dbname);

                  // Check connection
                  if($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                  }
                  else{
                    
                    $sql =  "SELECT `id`, `name`, `snssai`, `uprate`, `downrate` FROM `snssais_supported` " 
                          . "ORDER BY `snssai`";
                    $result4 = $conn->query($sql);

                    if ($result4->num_rows > 0) {
                        // output data of each row
                      echo  '<div class="col-12 mb-3">'
                        .     '<label for="snssai">QoS Network Slices '
                        .       '<span style="font-size: 13px;">(uprates/downrates in MBs)</span>'
                        .     '</label><br>';
                        while($row = $result4->fetch_assoc()) {
                            $checkedVal = ($row['snssai']==1?'checked="true" ':'');
                            echo  '<div class="col-md-6 custom-control custom-control-inline custom-checkbox snssaiChkBx" style="margin: 0px; max-width: 48%;"> '
                                .   '<input class="custom-control-input" type="checkbox" ' 
                                .       ' id="snssai' . $row['snssai'] . '" ' 
                                .       ' name="snssai[]" value="' . $row['snssai'] . '" ' . $checkedVal . ' /> '
                                .   '<label class="custom-control-label" for="snssai' . $row['snssai'] . '">' 
                                .       $row['name'] . ' <i style="font-size: 13px;">(uprate: ' . $row['uprate'] . ', downrate: ' . $row['downrate'] . ')</i>' 
                                .   '</label> '
                                . '</div>';
                        }
                      echo  '</div>';
                    }

                    echo  '<div class="col-12 mb-3" style="margin-bottom: 0.2rem !important;">'
                    .       '<div class="col-md-6 custom-control custom-control-inline custom-checkbox customSnssaiChkBx" style="margin: 0px; max-width: 48%;"> '
                    .         '<input class="custom-control-input" type="checkbox" id="cSnssai" name="cSnssai" /> '
                    .         '<label class="custom-control-label" for="cSnssai">' 
                    .           'Custom QoS Network Slice' 
                    .         '</label> '
                    .       '</div>'
                    .     '</div>';

                    echo  '<div style="height:50px;"><div class="col-12 mb-3" id="customSliceDiv" style="display: none;">'
                    .       '<div class="form-group row">'
                    .         '<label for="cUprate" class="col-md-2" style="margin:0.3rem 0 0.3rem 0;" >'
                    .           'Uprate:'
                    .         '</label>'
                    .        '<input type="number" min="1" max="100" value="5" class="form-control col-md-4" id="cUprate" name="cUprate" placeholder="custom uprate">'
                    .         '<label for="cDownrate" class="col-md-2" style="margin:0.3rem 0 0.3rem 0;" >'
                    .           'Downrate:'
                    .         '</label>'
                    .        '<input type="number" min="1" max="100" value="10" class="form-control col-md-4" id="cDownrate" name="cDownrate" placeholder="custom downrate">'
                    .       '</div>'
                    .     '</div></div>';
                    
                    $conn->close();
                  }
                ?>
              <!-- <div class="col-md-2 mb-3">
                <label>Unit</label>
                <div class="custom-control custom-radio">
                  <input type="radio" id="MB" name="unit" class="custom-control-input" value="MB" checked="checked">
                  <label class="custom-control-label" for="MB">MB</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="KB" name="unit" value="KB" class="custom-control-input">
                  <label class="custom-control-label" for="KB">KB</label>
                </div>
              </div>
              <div class="col-md-5 mb-3">
                <label for="uprate">Uprate <span style="font-size: 13px;">(if S-NSSAI not selected)</span></label>
                <input type="text" class="form-control" id="uprate" name="uprate" value="10" placeholder="value between 2-50" readonly="" required>
                <div class="invalid-feedback">
                  Uprate is required.
                </div>
              </div>
              <div class="col-md-5 mb-3">
                <label for="downrate">Downrate <span style="font-size: 13px;">(if S-NSSAI unselected)</span></label>
                <input type="text" class="form-control" id="downrate" name="downrate" value="20" placeholder="value between 2-100" readonly="true" required>
                <div class="invalid-feedback">
                  Downrate is required.
                </div>
              </div> -->
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Submit your intent</button>
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">© 2019 NCL - Intent System</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="http://220.149.42.102/ncl427/">Affiliation</a></li>
          <li class="list-inline-item"><a href="http://220.149.42.102/ncl427/#profile-asif">Developer</a></li>
          <li class="list-inline-item"><a href="http://www.jejunu.ac.kr/">Institution</a></li>
        </ul>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/holder.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();

      //$(".list-group li").last().fadeOut();
      $("ul.list-group li").last().attr("style", "display: none !important;" );
      setTimeout(function(){
        $("ul.list-group li").last().removeAttr("style");
        $("ul.list-group li").last().attr("style", "background-color: cornsilk;" );
        setTimeout(function(){
          $("ul.list-group li").last().removeAttr("style");
        }, 200);
      }, 150);
      //console.log($("ul.list-group li").last());

      $(function(){
        var requiredCheckboxes = $('.snssaiChkBx :checkbox[required]');
        requiredCheckboxes.change(function(){
            if(requiredCheckboxes.is(':checked')) {
                requiredCheckboxes.removeAttr('required');
            } else {
                requiredCheckboxes.attr('required', 'required');
            }
        });
      });

      $('#cSnssai').click(function(){
        toggleCustomSnssai();
      });

      function toggleCustomSnssai(){
        if($('#cSnssai').is(':checked')){
          $('#customSliceDiv').show();
        } else{
          $('#customSliceDiv').hide();
        }
      }

      function replaceCustomQoSWithText(){
        /*var replaced = $("body").html().replace('QoS:127','QoS:C');
        $("body").html(replaced);*/
      }

      $("body").ready(function(){
        replaceCustomQoSWithText();
        toggleCustomSnssai();
      });

    </script>
  

</body></html>