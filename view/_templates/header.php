<?php 
    if (!session_id()) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Gator Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL . 'public/css/style.css'?>"/>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  -->   
  <!-- JS -->

    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
  <!-- <link href="<?php echo URL; ?>css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Custom CSS -->
    <link href="<?php echo URL; ?>css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
 <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS FOR SEARCH VALIDATION -->
    <link href="<?php echo URL; ?>css/oh-snap.css" rel="stylesheet">


    <!-- JS -->

    <!-- JS FOR JQUERY VALIDATION -->
    <script src="<?php echo URL; ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo URL; ?>js/additional-methods.min.js"></script>
    
    <!-- JS FOR SEARCH VALIDATION -->
    <script src="<?php echo URL; ?>js/ohsnap.min.js"></script>
    <script src="<?php echo URL; ?>js/search-validation.js"></script>

    <!-- For Google Analytics -->
    <script src="<?php echo URL; ?>js/site-analytics.js"></script>
    <!--Slider components(Browse filters)-->
    <!--<link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--End slider components-->

</head>

<body>
 
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- add header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> <center>
            <a class="navbar-brand" href="<?php echo URL; ?>"><img width="50px" src="<?php echo URL; ?>img/logo.png">Gator Home</a></center>
        </div>
        <!-- add menu -->
        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo URL; ?>home">Home</a></li>
                <li><a href="<?php echo URL; ?>search">Search</a>
                </li>
                <li class="dropdown">
                <a href="#"
                class="dropdown-toggle"
                data-toggle="dropdown">
                Listings <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo URL; ?>post/create">Create Listing</a>
                    </li>
                    <li>
                        <a href="<?php echo URL; ?>post">Manage Listings</a>
                    </li>
                </ul>
            </li>
                <li><a href="<?php echo URL; ?>messages">Messages</a>
                </li>
                <li>
                <a href="<?php echo URL; ?>about">About</a>
                </li>
            </ul>

             <!--Login/Sign up Links -->
                <div class="login pull-right" style="padding-top: 15px; color: #eee">
                    <?php
                    if(isset($_SESSION['is_logged_in']) && isset($_SESSION['user_name'])) { ?>
                    <a style="color:#eee;" href="<?php echo URL; ?>profile"><?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?></a> /
                    <a style="color:#eee;" href="<?php echo URL; ?>logout/endUserSession">Logout</a>
                    <?php }
                    else { ?>
                    <a style="color:#eee;" href="<?php echo URL; ?>login">Login</a> /
                    <a style="color:#eee;" href="<?php echo URL; ?>register">Register</a>
                    <?php }
                    ?>
                    </div>
                   </li>
                </ul>
            </div>
            <!-- add search form -->
            <form class="navbar-form" role="search" align="center" action="<?php echo URL; ?>search/searchListings" method="get" id="form1">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter a zipcode/street" id="searchTextbox1" name="search" value="<?php if (isset($query)) echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>" pattern="^\s*[a-zA-Z0-9<>=]*$" title="Only letters and positive numbers allowed"/>
                    <span class="input-group-btn" style="padding: 0px;">
                        <button id="searchBtn" type="submit" class="btn btn-default">Go!</button>
                    </span>
                </div>
            </form>
            </div>
            <div id="ohsnap" align="center"></div>
        </div>
    </div>
</nav>

       <!-- Header Carousel -->
    <header id="myCarousel" class="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="fill jumbotron" style='background-image:url("<?php echo URL; ?>public/img/Banner.jpg");'>
            <div style="color:#33cccc;" align="center">
              <h3 style="background-color:#ffffff">Team 6 - SFSU/FAU/Fulda Software Engineering Project, Fall 2016. For Demonstration Only</h3>
            </div>
            </div>
        </div>
    </header>
</body>
</html>
