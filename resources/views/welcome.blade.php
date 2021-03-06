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
	  <div class="alert alert-success" role="alert">
	  	<h4 class="alert-heading">Login Successful!</h4>
	  	<hr>
	  	<p class="lead">
	  	  <a class="btn btn-success btn-lg" href="dbview/" role="button">View Database</a>
		  <a class="btn btn-success btn-lg" href="signin/" role="button">Edit Database</a>
		  <a class="btn btn-success btn-lg" href={{ env('LOGOUT_URI') }} role="button">Log Out</a>
		</p>
	  </div>

      </div>
    </div>
  </body>
</html>
