<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"    content="width=device-width, initial-scale=1.0">
        <meta name="description" content="SmartSocial">
        <meta name="author"      content="FER">

        <title>Login</title>

        <link rel="shortcut icon" href="assets/images/icon-ss.png">

        <!-- Bootstrap -->
        <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Icons -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- Fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Alice|Open+Sans:400,300,700">
        <!-- Custom styles -->
        <link rel="stylesheet" href="assets/css/styles.css">

        <!--[if lt IE 9]> <script src="assets/js/html5shiv.js"></script> <![endif]-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="assets/js/template.js"></script>
        
        <style>
            .imgLogo{
                max-width: 130px;
            }
        </style>
    </head>
    <body>

        <header id="header">
            <div id="head" class="parallax" parallax-speed="2">
                <h1 id="logo" class="text-center">
                    <img class="img-circle" src="assets/images/logo-ss.png" alt="">
                    <span class="title">SmartSocial</span>
                </h1>
            </div>

            <nav class="navbar navbar-default navbar-sticky">
                <div class="container-fluid">

                    <div class="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="partners.html">Partners</a></li>
                            <li><a href="team.html">Team</a></li>
							<li><a href="faq.html">FAQ</a></li>
                            <li><a href="app.html">App</a></li>
                            <li class="active"><a href="login.php">Login</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->			
                </div>	
            </nav>
        </header>
        <br>

    <main id="main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-12 text-center">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <br>
                            <br>
                            <form action="smartsocial.php" method="get">
                                <div class="col-sm-12 col-md-10 col-md-offset-1 text-center">
                                    <div class="input-group input-group-lg">
                                        <input name="q" type="password" class="form-control" placeholder="Enter your password">
                                        <span class="input-group-btn">
                                            <input class="btn btn-action" type="submit" value="submit"/>
                                        </span>
                                    </div>
									<br>
									<p>Re-open your <a href="app.html">SmartSocial app</a> to get your password.</p>
                                </div>
                            </form>
                        </div>
						<?php if(isset($_GET['r'])){?>
								<strong>User profile not found!</strong>
							<?php }?>
                    </div>
                </div>
            </div>
        </div>	<!-- /container -->

    </main>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8 widget">
                    <h3 class="widget-title">Contact</h3>
                    <div class="widget-body">
                        <p>
                            <a href="mailto:smartsocial.unizg@gmail.com">smartsocial.unizg@gmail.com</a><br>
                            University of Zagreb, Faculty of Electrical Engineering and Computing<br><br>
                            <strong>Address:</strong> <br>Unska 3<br> 10000 Zagreb<br> Croatia
                        </p>	
                    </div>
                </div>
				
				<div class="col-md-2 widget">
                    <h3 class="widget-title">Privacy Policy</h3>
                    <div class="widget-body">
                        <p class="follow-me-icons">
                            <a href="/Privacy_Policy.pdf" target="_blank"><i class="fa fa-file-pdf-o fa-2"></i></a>
							<br/>
                        </p>
                    </div>
                </div>
				
                <div class="col-md-2 widget">
                    <h3 class="widget-title">Follow us</h3>
                    <div class="widget-body">
                        <p class="follow-me-icons">
                            <a href="https://www.facebook.com/SmartSocialInfluence" target="_blank"><i class="fa fa-facebook-square fa-2"></i></a>
                            <a href=""><i class="fa fa-twitter fa-2"></i></a>
							<br/>
                        </p>
                    </div>
                </div>


            </div> <!-- /row of widgets -->
        </div>
    </footer>

</body>
</html>
