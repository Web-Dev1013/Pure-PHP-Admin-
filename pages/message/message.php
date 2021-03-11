<?php
ob_start();
session_start();
?>
<!doctype html>
<html lang="en">

<head>
	<title>Survey Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
	<?php
	include("message_css.php");
	?>
</head>

<body>
	<div class="alert alert-success w-25 float-right ">
		<button type="button" class="close" data-dismiss="alert"></button>
		<strong> Success! </strong><br> <span class="notification">Successfully Created</span>
	</div>
	<div class="alert alert-danger w-25 float-right ">
		<button type="button" class="close" data-dismiss="alert"></button>
		<strong> Failed! </strong><br><span class="notification"> Please fill email field</span>
	</div>
	<div class="container-fluid">
		<div class="row mt-4">
			<div class="content text-dark">
				<div class="message text-center">
					<p class="h1 text-gold font-weight-bold">Thank You</p>
					<p class="h3 text-gold font-weight-bold">Thank you for your responses.</p>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://unpkg.com/autonumeric"></script>
<?php
include("message_js.php");
?>