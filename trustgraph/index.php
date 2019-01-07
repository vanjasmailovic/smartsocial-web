<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <title>Graf</title>

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <!-- JS file -->
        <script type="text/javascript" src="./scripts/d3/d3.js"></script>

        <script src="jquery.easy-autocomplete.min.js"></script> 
        <!-- CSS file-->
        <link type="text/css" rel="stylesheet" href="style.css">

        <link type="text/css" rel="stylesheet" href="easy-autocomplete.min.css"> 
        <link type="text/css" rel="stylesheet" href="easy-autocomplete.themes.min.css"> 
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            .eac-icon{
                  border-radius: 15%;
                  max-width: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">    
                    <input id="provider" type="text" class="form-control"/>

                <!--<input id="provider" /><button id="buttonUser" class="btn btn-default">Submit</button>-->
                </div>
                <div class="col-md-1">
                    <button id="buttonUser" class="btn btn-default">Submit</button>
                </div>
            </div>

            <div class="row">

                <div id="bpg" >
                    <div id="mainDiv">
                        <div id="svgDiv"></div>
                        <li id="houseButton" class="selected" style="visibility: hidden;"></li>
                        <div id="headerRight" style="width:350px; right:20px;">
                            <div class="hint">
                                <div id="totalDiv" style="color: #000; font-size:22px; font-weight:bold; margin-top:5px; font-family: Georgia; font-style:italic">
                                    $0
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="toolTip" class="tooltip" style="width:250px; height:120px; position:absolute;s">
                        <div id="header1" class="header2"></div>
                        <div class="header-rule"></div>
                        <div id="head" class="header"></div>
                        <div class="header-rule"></div>
                        <div  id="header2" class="header3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS file -->
        <script type="text/javascript" src="./scripts/political_influence.min.js"></script>   


        <script type="text/javascript">
            var jsonData;


            $("#provider").easyAutocomplete({
                url: "users_about.json",
                getValue: "name",
                list: {
                    match: {
                        enabled: true
                    }
                },
                template: {
                    type: "iconRight",
                    fields: {
                        iconSrc: "picture"
                    }
                }
            });

            $("#buttonUser").click(function () {
                console.log("oznaceni si");
                var rez = search($("#provider").val(), jsonData);
                console.log("prije:" + rez[0].uid);
                var url = "http://dstriga.tel.fer.hr:8080/api/api/ss/finit/" + rez[0].uid;
                console.log("prije:" + url);

                $.get(url, function (data, status) {
                }).always(function () {
                    location.reload();
                });
            });


            function search(searchText, jsonData) {
                var myRe = new RegExp('.*' + searchText.toLowerCase() + '.*');
                console.log("start");
                var rez = new Array();
                for (var i = 0; i < jsonData.length; i++) {
                    var myArray = myRe.exec(jsonData[i].name.toLowerCase());
                    if (myArray !== null) {
                        rez.push(jsonData[i]);
                        //console.log(jsonData[i].name + " ** " + myArray);
                    }

                }
                console.log("end");
                return rez;
            }

            // Load Data
            d3.json("users_about.json", function (data) {
                jsonData = data;
            });
        </script>
    </body>
</html>
