<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="content/svg/policy-icon.png">

    <title>Intent System - Graph</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/form-validation.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- dagre-layout (header-part) -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <link href="cytoscape/css/style.css" rel="stylesheet" />

    <!-- for testing with local version of cytoscape.js -->
    <script src="cytoscape/js/cytoscape.min.js"></script>

    <script src="https://cdn.rawgit.com/cpettitt/dagre/v0.7.4/dist/dagre.min.js"></script>
    <script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-dagre/1.5.0/cytoscape-dagre.js"></script>

  </head>

  <body class="bg-light">

    <h1 id="top-message">...</h1>
    <div id="cy"></div>
    <!-- Load application code at the end to ensure DOM is loaded -->
    <!-- <script src="cytoscape/js/code.js"></script>   -->

    <?php

      $servername = "127.0.0.1";
      $username = "root";
      $password = "";
      $dbname = "vocabulary-store";

      $nodesToDraw = "";
      $nodeLinksToDrawHelper = "";
      $nodeLinksToDraw = "";

      // Create connection
      $conn2 = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if($conn2->connect_error) {
          die("Connection failed: " . $conn2->connect_error);
      }
      else{
        $contractId = $_GET["id"];

        $sql1 =  "SELECT cont.`id`, cont.`name`, cont.`s_nssai`,  " 
              . "arch.`architecture_name` AS arch_name, " 
              . "modArch.`node_name` AS mod_name, modArch.`id` AS mod_id " 
              . "FROM `xontracts` AS cont "
              . "INNER JOIN architectures_supported AS arch ON cont.`arch_id` = arch.`id` " 
              . "INNER JOIN modules_architecture AS modArch ON arch.`id` = modArch.`arch_id` " 
              . "WHERE cont.`id`=" . $contractId . " "
              . "ORDER BY cont.`id`";

        $resultGraph1 = $conn2->query($sql1);

        if ($resultGraph1->num_rows > 0) {
            // output data of each row
            while($row = $resultGraph1->fetch_assoc()) {
              $nodesToDraw .= "{ data: { id: '" . $row['mod_name'] ."' } }, ";
              $nodeLinksToDrawHelper .= $row['mod_id'] . ",";
              //echo "<br>" . $row['name'] . "<br>" . $row['s_nssai'] . "<br>" . $row['arch_name'] . "<br>" . $row['mod_name'] . "<br>";
            }
            $nodeLinksToDrawHelper = substr($nodeLinksToDrawHelper, 0, strlen($nodeLinksToDrawHelper)-1);
            $sql2 =  "SELECT "
                  .     "`id`, "
                  .     "(SELECT node_name FROM modules_architecture WHERE id = `mod_id`) AS mod_name, "
                  .     "(SELECT node_name FROM modules_architecture WHERE id = `relation_id`) AS rel_mod_name, "
                  .     "`mod_id`, "
                  .      "`relation_id`, `link_specs` "
                  .   "FROM `modules_relations` "
                  .    "WHERE `mod_id` IN (" . $nodeLinksToDrawHelper . ")";
            
            $resultGraph2 = $conn2->query($sql2);

            if ($resultGraph2->num_rows > 0) {
              // output data of each row
              while($row2 = $resultGraph2->fetch_assoc()) {

                $src_mod  = $row2['mod_name'];
                $dest_mod = $row2['rel_mod_name'];

                $nodeLinksToDraw .= "{ data: { source: '" . $src_mod . "', target: '" . $dest_mod . "' } },";
              }
            }

        } else {
            $msg = "The architecture selected has no modules defined by the administrator";
            echo  "<script type='text/javascript'> "
              .     "document.getElementById('top-message').innerText = '" . $msg . "';"
              .   " </script>";
        }
      }
    ?>

    <?php

      /*$nodesToDraw = "{ data: { id: 'n0' } },";*/

      /*$nodeLinksToDraw = "{ data: { source: 'UE', target: 'eNB' } },
                          { data: { source: 'eNB', target: 'UE' } },";*/

      echo "<script type='text/javascript'>

          var cy = window.cy = cytoscape({
            container: document.getElementById('cy'),

            boxSelectionEnabled: false,
            autounselectify: true,

            layout: {
              name: 'dagre'
            },

            style: [
              {
                selector: 'node',
                style: {
                  'content': 'data(id)',
                  'text-opacity': 0.8,
                  'text-valign': 'center',
                  'text-halign': 'right',
                  'background-color': '#11479e'
                }
              },

              {
                selector: 'edge',
                style: {
                  'curve-style': 'bezier',
                  'width': 1,
                  'target-arrow-shape': 'triangle',
                  'line-color': '#9dbaea',
                  'target-arrow-color': '#9dbaea'
                }
              }
            ],

            elements: {
              nodes: ["
                . $nodesToDraw . 
              "],
              edges: ["
                . $nodeLinksToDraw . 
              "]
            },
          });
        </script>";

    ?>

</body></html>