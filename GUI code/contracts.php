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
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">Contracts <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">

      <div class="row py-5 text-center">
        <table class="table table-hover table-striped">
          <caption>
            Contracts list
            <span class="pull-right" style="margin-right: 33px;">
              <a class="badge badge-dark" href="delete_graph.php?id=0&name=DeleteAll">
                delete-all
              </a>
            </span>
          </caption>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="text-left">Name</th>
              <th scope="col">S-NSSAI</th>
              <th scope="col">Uprate</th>
              <th scope="col">Downrate</th>
              <th scope="col">Status</th>
              <th scope="col">View</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
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

                $sql =  "SELECT cont.`id`, cont.`name`, cont.`arch_id`, cont.`s_nssai`, cont.`uprate`, cont.`downrate`, cont.`unit`, arch.`architecture_name`, cont.`is_synced` " 
                      . "FROM `xontracts` AS cont "
                      . "INNER JOIN architectures_supported AS arch ON cont.`arch_id` = arch.`id` " 
                      . "ORDER BY cont.`id`";
                $result2 = $conn->query($sql);

                if ($result2->num_rows > 0) {
                    // output data of each row
                    $ijk = 0;
                    while($row = $result2->fetch_assoc()) {
                        $iconClass = ($row['is_synced']==1?'fa-check-square text-success':'fa-refresh text-warning');
                        $iconTitle = ($row['is_synced']==1?'synced':'to be synced');
                        echo  '<tr>'
                          .     '<th scope="row">' . ++$ijk . '</th>'
                          .     '<td class="text-left">' . $row['name'] . '</td>'
                          .     '<td>' . (($row['s_nssai']==127)?"Custom":$row['s_nssai']) . '</td>'
                          .     '<td>' . $row['uprate'] . '</td>'
                          .     '<td>' . $row['downrate'] . '</td>'
                          .     '<td>' 
                          .       '<i class="fa fa-sm ' . $iconClass . '" title="' . $iconTitle . '"></i>'
                          .     '</td>'
                          .     '<td><a class="badge badge-light" href="graph.php?id=' . $row['id'] . '">graph</a></td>'
                          .     '<td>'
                          .       '<a class="badge badge-danger" href="delete_graph.php?id=' . $row['id'] . '&name=' . $row['name'] . '">'
                          .         'delete</a></td>'
                          .   '</tr>';
                        /*echo  '<li class="list-group-item d-flex justify-content-between lh-condensed">' 
                          .     '<div>'
                          .       '<h6 class="my-0"><a href="graph.php?id=' . $row['id'] . '">' . $row['name'] . ' (' . $row['architecture_name'] . ')</a></h6>' 
                          .       '<small class="text-muted">' 
                          .         's-nssai:' . $row['s_nssai'] 
                          .         ', uprate:' . $row['uprate'] 
                          .         ', downrate:' . $row['downrate'] 
                          .       '</small>' 
                          .     '</div>' 
                          .     '<span class="text-muted">' 
                          .       '<i class="fa fa-check-square fa-lg text-success"></i>' 
                          .     '</span>' 
                          .   '</li>';*/
                    }
                } else {
                    echo  '<tr>'
                      .     '<td colspan="7"><h6 class="my-0">No contracts found.</h6></td>'
                      .   '</tr>';
                }

                $conn->close();
              }
            ?>
          </tbody>
        </table>
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


    </script>
  

</body></html>