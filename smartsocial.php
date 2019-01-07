<?php
$q = $_GET['q'];
//$q = "9abw1";
if (isset($q) && strlen($q) == 5) {
    $link = "http://smartsocial.eu:8080/SmartSocialAPI/api/ss/total_influence/" . $q;
    $ch = curl_init();
    // set url 
    curl_setopt($ch, CURLOPT_URL, $link);
    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string 
    $output = curl_exec($ch);
    // close curl resource to free up system resources 
    curl_close($ch);
    $error = "";
    if ($output == NULL) {
        $error = "(Error) Please try again later";
        header("Location: login.php?r=-1");
    } else {
        $jsonData = json_decode($output, true);
        if (isset($jsonData['id'])) {
            $social_influence = 0;
            $telco_influence = 0;
            $total_influence = 0;
            if (isset($jsonData['social_influence'])) {
                $social_influence = $jsonData['social_influence'];
            }
            if (isset($jsonData['telco_influence'])) {
                $telco_influence = $jsonData['telco_influence'];
            }
            if (isset($jsonData['total_influence'])) {
                $total_influence = $jsonData['total_influence'];
            }
        } else {
            header("Location: login.php?r=-1");
        }
    }
} else {
    header("Location: login.php?r=-1");
}

//http://dstriga.tel.fer.hr:8080/SmartSocialAPI/api/ss/total_influence/9abw1
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"    content="width=device-width, initial-scale=1.0">
        <meta name="description" content="SmartSocial">
        <meta name="author"      content="FER">

        <title>SmartSocial</title>

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
            .chart-center{
                max-width: 130px;
            }
        </style>
        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
        <script type='text/javascript'>
            google.load('visualization', '1', {packages: ['gauge']});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Telco', <?php echo $jsonData['telco_influence'] ?>],
                    ['Social', <?php echo $jsonData['social_influence'] ?>],
                    ['Total', <?php echo $jsonData['total_influence'] ?>]
                ]);

                var options = {
                    width: 400, height: 120,
                    redFrom: 85, redTo: 100,
                    yellowFrom: 60, yellowTo: 85,
                    minorTicks: 5
                };

                var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
                chart.draw(data, options);
                $("table").attr("align", "center");
            }
        </script>
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
                            <li class="active"><a href="login.php">Logout</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->			
                </div>	
            </nav>
        </header>
        <br>

    <main id="main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><span class="glyphicon glyphicon-user"></span>&nbsp;SmartSocial profile</div>
                        <div class="panel-body">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="pull-left">
									<?php if(isset($jsonData['facebook_id'])){?>
                                        <img src="http://graph.facebook.com/<?php echo $jsonData['facebook_id'] ?>/picture"/>
										<?php }?>
                                    </div>
                                    <div class="media-body">
									<?php if(isset($jsonData['name'])){?>
                                        <h4 class="media-heading"><?php echo $jsonData['name'] ?></h4>
										<?php }?>
                                        <br>
                                        <dl class="dl-horizontal">
											<?php if(isset($jsonData['phone_number'])){?>
                                            <dt><span class="glyphicon glyphicon-phone"></span></dt>
                                            <dd><?php echo $jsonData['phone_number']; ?></dd>
											<?php }?>
											<?php if(isset($jsonData['imei'])){?>
                                            <dt><span class="glyphicon">IMEI:</span></dt>
                                            <dd><?php echo $jsonData['imei']; ?></dd>
											<?php }?>
											<?php if(isset($jsonData['smss'])){?>
                                            <dt><span class="glyphicon glyphicon-envelope"></span></dt>
                                            <dd><?php echo $jsonData['smss']; ?> (SMSs)</dd>
											<?php }?>
											<?php if(isset($jsonData['calls'])){?>
                                            <dt><span class="glyphicon glyphicon-phone-alt"></span></dt>
                                            <dd><?php echo $jsonData['calls'] ?> (calls)</dd>
											<?php }?>
											<?php if(isset($jsonData['calls_duration'])){?>
                                            <dt><span class="glyphicon glyphicon-time"></span></dt>
                                            <dd><?php echo round($jsonData['calls_duration'] / 3600, 2); ?> (h)</dd>
											<?php }?>
											<?php if(isset($jsonData['incoming_calls'])){?>
                                            <dt><span class="glyphicon">Incoming calls:</span></dt>
                                            <dd><?php echo $jsonData['incoming_calls']; ?></dd>
											<?php }?>
											<?php if(isset($jsonData['incoming_calls_duration'])){?>
                                            <dt><span class="glyphicon">Incoming calls duration:</span></dt>
                                            <dd><?php echo round($jsonData['incoming_calls_duration'] / 3600, 2); ?> (h)</dd>
											<?php }?>
											<?php if(isset($jsonData['outgoing_calls'])){?>
                                            <dt><span class="glyphicon">Outgoing calls:</span></dt>
                                            <dd><?php echo $jsonData['outgoing_calls']; ?></dd>
											<?php }?>
											<?php if(isset($jsonData['outgoing_calls_duration'])){?>
                                            <dt><span class="glyphicon">Outgoing calls duration:</span></dt>
                                            <dd><?php echo round($jsonData['outgoing_calls_duration'] / 3600, 2); ?> (h)</dd>
											<?php }?>
											<?php if(isset($jsonData['number_of_posts'])){?>
											<dt><span class="glyphicon">Facebook posts:</span></dt>
                                            <dd><?php echo $jsonData['number_of_posts'] ?></dd>
											<?php }?>
											<br/>
											
                                            <dt><span class="glyphicon">Telco influence:</span></dt>
                                            <dd><?php echo $jsonData['telco_influence'] ?></dd>
                                            <dt><span class="glyphicon">Social influence:</span></dt>
                                            <dd><?php echo $jsonData['social_influence'] ?></dd>
                                            <dt><span class="glyphicon">Total influence:</span></dt>
                                            <dd><?php echo $jsonData['total_influence'] ?></dd>
																						
											
                                        </dl><br>
										You're more influental than <strong><?php echo $jsonData['score_influence'] ?>%</strong> of our users!<br/>
                                        <div class="progress">
  <div class="progress-bar progress-bar-danger progress-bar-striped active"  role="progressbar" aria-valuenow="<?php echo $jsonData['score_influence'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $jsonData['score_influence'] ?>%">
    <?php echo $jsonData['score_influence'] ?>%
  </div>
</div>
                                    </div>
                                </li>
                            </ul>

                            <div id='chart_div'></div>
                        </div>
                        <br>
                        <br>
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

    <footer id="underfooter">
        <div class="container">
            <div class="row">
                <div class="col-md-6 widget col-md-offset-6">
                    <div class="widget-body">
                        <p class="text-right">
                            Copyright &copy; 2014, University of Zagreb<br> 
                            <a href="https://www.fer.unizg.hr/en" rel="">Faculty of Electrical Engineering and Computing</a> </p>
                    </div>
                </div>

            </div> <!-- /row of widgets -->
        </div>
    </footer>

</body>
</html>
