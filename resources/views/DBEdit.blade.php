<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="icon" href="https://lostandstolen-iampocusoutlook.msappproxy.net/images/favicon.ico" type="image/ico">

	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	<script>
/* 	 $(document).ready(function() {

	 $('#insert').hide(); //Initially form wil be hidden.

	  $('#insertButton').click(function() {
	   $('#insert').show();//Form shows on button click

	   });
	 });
 */	</script>

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
	  <p class="lead">Edit page</p>
	  <?php
		if (isset($_GET['error'])) {
			echo "<p>".$_GET["error"]."</p>";
		}
	  ?>
	  <a class="btn btn-success btn-lg" href="/" role="button">Return Home</a>
	  <a class="btn btn-danger btn-lg" role="button" id="deleteButton">Delete Selected</a>

 	  <script>
	    $(document).ready(function() {
			$('#someButton').click(function() {
				var names = [];
				$('#MyDiv input:checked').each(function() {
					names.push(this.name);
				});
				// now names contains all of the names of checked checkboxes
				// do something with it
			});
		});

		function deleteSelected() {
			alert("alert");
			if (confirm("Are you sure?")) {
				txt = "OK";
			} else {
				txt "no";
			}
		}
	  </script>
	      <div class="container-fluid">
      <table class="table table-hover">
        <thead>
          <tr>
		    <th scope="col"></th>
            <th scope="col">Item</th>
			<th scope="col">Crime Reference Number</th>
            <th scope="col">Description</th>
            <th scope="col">Date Found</th>
            <th scope="col">Location Found</th>
          </tr>
        </thead>
        <tbody>
		<form action="/dbinsert" method="post" id="insert">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<td><input type="submit" value="Add item"/></td>
			<td><input type="text" name="item" size="10" placeholder="Item"></td>
			<td/>
			<td><input type="text" name="description" placeholder="Name"></td>
			<td><input type="date" name="date found" placeholder="DD/MM/YYYY"></td>
			<td><input type="text" name="location found" placeholder="Location"></td>
		</form>
		<div id="items">
	  <?php
		$items = DB::table('lostitem')->get();

		foreach ($items->all() as $item)
		{
			echo "<tr>\n";
			echo "<td><input type=\"checkbox\" name=".$item->id."></td>";
			echo " <th scope='row'> ".$item->item."</th>\n";
			echo " <td> ".$item->crn."</td>\n";
			echo " <td> ".$item->description."</td>\n";
			echo " <td> ".$item->date_found."</td>\n";
			echo " <td> ".$item->location_found."</td>\n";
			echo "</tr>\n";
		}
	  ?>
	  </div>
	          </tbody>
      </table>
    </div>

    </div>

	<script>
	$("#deleteButton").click(function() {
				var n = $( "input:checked" );
	  			var names = [];
			$('input:checked').each(function() {
				names.push(this.name);
			});
		if(confirm("Are you sure you want to delete these items?")) {
			window.location = "/deleteSelected/" + names;
		}
	});
    </script>
  </body>

</html>
