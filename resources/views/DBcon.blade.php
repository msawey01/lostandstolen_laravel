<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="icon" href="https://lostandstolen-iampocusoutlook.msappproxy.net/images/favicon.ico" type="image/ico">

    <title>Project Demo</title>
  </head>
  <body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
	       <h1 class="display-4">National Enabling Programme</h1>
	       <p class="lead">Lost and stolen database</p>
      </div>
    </div>

    <div class="container-fluid">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Item</th>
			<th scope="col">Crime Reference Number</th>
            <th scope="col">Description</th>
            <th scope="col">Date Found</th>
            <th scope="col">Location Found</th>
            <th scope="col">Collected By</th>
            <th scope="col">Date Collected</th>
          </tr>
        </thead>
        <tbody>

		<?php
			$user = 'remote';
			$pw = 'f@kePass1956';
			$db = 'mysql';
			$mysqli = new mysqli('40.71.5.113', $user, $pw, $db) or die("unable to connect");
			if (!$mysqli)
			{
				die("Connection failed: " . mysqli_connect_error());
			}

			$sql = "SELECT * FROM lostitem";
			$result = mysqli_query($mysqli, $sql);

			if ($result->num_rows > 0)
			{
				// output data of each row
				while($row = $result->fetch_assoc())
					{
						echo "<tr>\n";
						echo " <th scope='row'> ".$row["item"]."</th>\n";
						echo " <td> ".$row["crn"]."</td>\n";
						echo " <td> ".$row["description"]."</td>\n";
						echo " <td> ".$row["date_found"]."</td>\n";
						echo " <td> ".$row["location_found"]."</td>\n";
						echo " <td> ".$row["collected_by"]."</td>\n";
						echo " <td> ".$row["date_collected"]."</td>\n";
						echo "</tr>\n";
					}
			}
			else
			{
				echo " <td> </td>\n";
			}

			mysqli_close($mysqli);
				#echo "connection closed!";
		?>

        </tbody>
      </table>
    </div>

  </body>
</html>
