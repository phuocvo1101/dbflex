<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="public/css_js/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="public/css_js/css/dashboard.css" rel="stylesheet">



</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top >
      <div class="container-fluid">
<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">TRADEDOUBLER</a>
</div>
<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#">azzarev Tradedoubler User</a></li>

    </ul>
</div>
</div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- menu left -->
        <div class="col-sm-2 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="index.php?controller=dashboard&action=index"><i class="fa fa-dashboard"></i><span class="hidden-minibar">  Dashboard<span></a></li>
                <li><a href="index.php?controller=report&action=index"><i class="fa fa-comments"></i>  Reports</a></li>
                <li><a href="index.php?controller=product&action=index"><i class="fa fa-comments"></i>  Products</a></li>
            </ul>
        </div>
        <!-- end menuleft -->
        <!-- content -->abc
        {$content}
        <!-- end content -->
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="public/css_js/js/bootstrap.min.js"></script>
</body>
</html>
