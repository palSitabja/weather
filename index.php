<?php
include 'country.php';
$error="";
$weather_details="";
$nwserror="";
if($_POST['city']){
    $city_name=str_replace(' ','%20',$_POST['city']);
    $ch = curl_init();
    //print_r($_POST) ;
    if($city_name=="uttarpara"){
      curl_setopt($ch,CURLOPT_URL,"http://api.apixu.com/v1/forecast.json?key=21dfc4c52b724398ac744026182106&q=22.67,88.35&days=7");
    }elseif ($city_name=="hindmotor" || $city_name=="Hindmotor") {
      curl_setopt($ch,CURLOPT_URL,"http://api.apixu.com/v1/forecast.json?key=21dfc4c52b724398ac744026182106&q=22.69,88.33&days=7");
    }else{
    curl_setopt($ch,CURLOPT_URL,"http://api.apixu.com/v1/forecast.json?key=21dfc4c52b724398ac744026182106&q=".$city_name."&days=7");
    }
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $json_output=curl_exec($ch);
    $weather = json_decode($json_output,true);
    //print_r($weather);
    //if(!$weather['error']) {
    if (!(array_key_exists('error',$weather ))) {
        $weather_details="Weather in ".$_POST['city']." is ".$weather['current']['condition']['text'].".";
        $coord="Longitude: ".$weather['location']['lon']."   and   Latitude: ".$weather['location']['lat']."<br></br>Region: ".$weather['location']['region']." | Country: ".$weather['location']['country']."<br><br>Local Time: ".$weather['location']['localtime'];
        $temp="Temperature in Celcious: ".$weather['current']['temp_c']."&degC <br></br>"."Temperature in Farenhite: ".$weather['current']['temp_c'];
        $wind="Wind Speed: ".$weather['current']['wind_kph']." km/h<br></br>Wind Flow Angle: ".$weather['current']['wind_degree']."&deg<br></br> Wind Direction: ".$weather['current']['wind_dir'].".";
        $pressure="<br></br>Air Pressure: ".$weather['current']['pressure_mb']." mb<br></br>Precipitation: ".$weather['current']['precip_mm']." mm.";
        $cloud="<br></br>Temperature feels like: ".$weather['current']['feelslike_c']."&degC <br></br> Visibility: " .$weather['current']['vis_km']." km";
        $sun="Sunrise: ".$weather['forecast']['forecastday']['0']['astro']['sunrise']." | Sunset: ".$weather['forecast']['forecastday']['0']['astro']['sunset']."<br></br>Moonrise: ".$weather['forecast']['forecastday']['0']['astro']['moonrise']."| Moonset: ".$weather['forecast']['forecastday']['0']['astro']['moonset'];
        $forecastday=$weather['forecast']['forecastday']['1']['date'];
        $photo=$weather['current']['condition']['icon'];
        $code=array_search($weather['location']['country'],$countries);
        //echo $code;
        //for($i=1;$i<7;$i++){
        $url = "https://newsapi.org/v2/top-headlines?country=".$code."&apiKey=6e9ee8a5b6714a2f8bdc82d8365f7d05";
        $news=json_decode(file_get_contents($url),true);
        if($news['totalResults']==0){
          $nwserror="No news available for your searched area !!";
        }

        //print_r($news);
        //}
    }else{
         $error=" oops!! Your city name doesn't exist in DataBase";
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Monoton|Chewy|Lobster|Avro|Prompt|Great+Vibes|Satisfy|Audiowide|Acme|Righteous|Concert+One|Permanent Marker" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Weather</title>
  <style media="screen">
    body{
      margin: 0;
      padding: 0;
      perspective: 1px;
      height: 100%;
      overflow-y: scroll;
      overflow-x: hidden;
      /*background: linear-gradient(to top left, #c9ffbf,#ffafbd);*/
    }
      .jumbotron{
        padding-top: 0px;
        background-repeat:no-repeat;
      background-position:center center;
       background-attachment: fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      height: 760px;
      }
      /*.card {
        margin: 0 auto;
        float: none;
        margin-bottom: 10px;
      }*/
    .card-deck{
      padding: 40px 60px 40px 60px;
    }
    #heading{
      margin-top: 80px;
      color:white;
      font-family:'Chewy', cursive;
      font-size: 60px;
      text-shadow: 4px 4px 2px black;
    }
    #location{
      background-color:rgba(0, 0, 0, 0.2);
      color:white;
      height:50px;

    }
    #info{
      font-family: 'Righteous', cursive;
    }
    #forecastCard{
      padding: 40px 40px 40px 40px;
    }
    #news{
      padding-top: 150px;
      background-image: url("news1.jpg");
    }
    #forecasthead{
      padding-top: 150px;
      background-image: url("forecast3.jpg");
    }
    #forecastfont{
      font-family: 'Acme', sans-serif;
    }
    #brand{
    	font-family:'Audiowide', cursive;
      	font-size:50px;
      	margin-right:400px;

    }
    #grad1:hover{
      background: linear-gradient(to top left, #abbaab,#ffffff);
      color: white;
    }
    #grad2:hover{
      background: linear-gradient(to top left, #556270,#ff6b6b);
      color: white;
    }
    #grad3:hover{
      background: linear-gradient(to top left, #70e1f5,#ffd194);

    }
  /*  #weather{

      background-image: url("Evening.jpg");
    }*/
    .progress-bar1 {
  position: relative;
  height: 100px;
  width: 100px;
  margin:0 auto;
  }

  .progress-bar1 div {
  position: absolute;
  height: 100px;
  width: 100px;
  border-radius: 50%;
  }

  .progress-bar1 div span {
  position: absolute;
  color: white;
  font-family: Arial;
  font-size: 25px;
  line-height: 75px;
  height: 75px;
  width: 75px;
  left: 12.5px;
  top: 12.5px;
  text-align: center;
  border-radius: 50%;
  background-color: #44484B;
  }

  .progress-bar1 .background { background-color: #b3cef6; }

  .progress-bar1 .rotate {
  clip: rect(0 50px 100px 0);
  background-color: #4b86db;
  }

  .progress-bar1 .left {
  clip: rect(0 50px 100px 0);
  opacity: 1;
  background-color: #b3cef6;
  }

  .progress-bar1 .right {
  clip: rect(0 50px 100px 0);
  transform: rotate(180deg);
  opacity: 0;
  background-color: #4b86db;
  }
  .arrow{
        position: relative;
        font-size: 80px;
        text-align: center;

        animation: bouncearrow 1s infinite;
        color: white;
      }
  @-webkit-keyframes bouncearrow{
  0%{top: 0px;}
  50%{top: 20px; color: #000000;}
  100%{top: 0px;}
  }

@keyframes bouncearrow{
  0%{top: 0px;}
  50%{top: 20px; color: #000000;}
  100%{top: 0px;}
  }

  @keyframes
  toggle {  0% {
  opacity: 0;
  }
  100% {
  opacity: 1;
  }
  }


  </style>
  </head>
  <body>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	  <div class="modal-dialog" role="document">
  	    <div class="modal-content">
  	      <div class="modal-header">
  	        <h5 class="modal-title" id="exampleModalLabel">About</h5>
  	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  	          <span aria-hidden="true">&times;</span>
  	        </button>
  	      </div>
  	      <div class="modal-body text-center">
            <img class="mx-auto rounded-circle shadow-lg" style="width:80px;" src="dp.jpg" alt="Card image cap">
  	        <br></br><p class="shadow-lg">Created by: <b style="font-family: 'Satisfy', cursive; font-size: 20px;">Sitabja Pal</b>
  	        <h5>Contact:</h5><a href="sitabjapal03@gmail.com" target="_blank">sitabjapal03@gmail.com</a><br></br><a href="https://www.linkedin.com/in/sitabja-p-702019b5/" target="_blank">https://www.linkedin.com/in/sitabja-p-702019b5/</a><br></br>
  	        <h5>API used: </h5><a href="https://www.apixu.com/api.aspx" target="_blank">www.apixu.com/api</a><br></br>
            <a href="https://newsapi.org/" target="_blank">https://newsapi.org</a><br></br>
             <h5>Photo Source: </h5><a href="https://www.pexels.com/" target="_blank">https://www.pexels.com/</a><br></br>
  	      </div>
  	      <div class="modal-footer">
  	        <button type="button" class="btn btn-secondary shadow-lg" data-dismiss="modal">Close</button>
  	      </div>
  	    </div>
  	  </div>
  	</div>
<div id="weather" class="jumbotron jumbotron-fluid">
  <nav class="navbar navbar-expand-lg navbar-dark">
  <a id="brand" style="" class="navbar-brand" href="#">Weather</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto nav nav-tab container" role="tablist">
      <li class="nav-item bg-dark shadow-lg">
        <a class="nav-link" href="#forecastfont">Current</a>
      </li>
      <li class="nav-item bg-dark shadow-lg">
        <a class="nav-link" href="#forecasthead">Forecast</a>
      </li>
      <li class="nav-item bg-dark shadow-lg">
        <a class="nav-link" href="#news">News</a>
      </li>
    </ul>
    <span style="" class="navbar-text">
    <button style="font-size: 20px;" type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
  About
</button>
  </span>
  </div>
</nav>
  <div class="container text-center">
    <div class="page-header">
      <h1 style="" id="heading" class="display-4 container">What's the Weather</h1>
    </div><br></br>
     <div class="text-center col-md-12">
       <form class="form-group" method="post">
         <div class="form-group mb-2">
           <p id="info" style="color: white ;font-size:25px;text-shadow: 2px 2px 4px black;">Enter your city</p>
           <div class="text-center">
              <input type="text" class="form-control form-control-lg shadow-lg" name="city" id="location" placeholder="London,Kolkata etc.">
            </div>

         </div>

  <button id="submitbtn" type="submit" class="btn btn-light mb-2 btn-lg shadow-lg">Enter</button>
</form>
     </div>
  </div>

<?php
if ($weather_details) {
echo '
<div class="arrow"><a style="text-decoration: none;" class="arrow" href="#forecastfont">&#x21E3;</a></div>
</div>
<div class="card text-center">
  <h1 style="color:white;" id="forecastfont" class="card-header  bg-dark">Current weather</h1>

  <div class="card-body">
    <img class="mx-auto" style="width:120px;" src='.$weather['forecast']['forecastday']['0']['day']['condition']['icon'].' alt="Card image cap">
    <h1 style="font-size:200px;font-family:Concert One, cursive;text-shadow: 9px 9px 12px grey;" class="card-title shadow"><img class="mx-auto" style="width:80px;" src="fog.png" alt="Card image cap"></span>'.$weather['current']['temp_c'].'&deg<small>C</small></h1>
    <h4 id="info" class="card-text"><i class="material-icons">toys</i> '.$weather['current']['wind_kph'].' KM/h | '.$weather['current']['wind_degree'].'&deg | '. $weather['current']['wind_dir'].'</h4>
    <h4 id="info" >'.$weather_details.'</h4>
    <table class="table">
    <tbody>
    <tr>
      <td colspan="3"><img class="mx-auto" style="width:80px;" src="place.png" alt="Card image cap"><h4 id="info">'.$coord.'</h4></td>
    </tr>
  </tbody>
</table>
</div>
</div>
<div class="card-deck text-center">
  <div class="card  shadow-lg">
    <div id="grad1" class="card-body">
      <h5 class="card-title"><img class="mx-auto" style="width:80px;" src="pressure.png" alt="Card image cap"></h5>
      <p id="info" class="card-text">'.$pressure.'</p>
    </div>
  </div>
  <div class="card  shadow-lg">
    <div id="grad1" class="card-body">
      <h5 class="card-title"><img class="mx-auto" style="width:80px;" src="temp.png" alt="Card image cap"></h5>
      <p id="info" class="card-text">'.$cloud.'</p>
    </div>
  </div>
  <div class="card shadow-lg">
    <div id="grad1" class="card-body">
      <h5 class="card-title"><img class="mx-auto" style="width:80px;" src="sun.png" alt="Card image cap"></h5>
      <p id="info" class="card-text"><br></br>'.$sun.'</p>
    </div>
  </div>
</div>
<div class="card-deck text-center">

  <div class="shadow-lg card">
    <div id="grad1" class="card-body">
    <h5 class="card-title"><img class="mx-auto" style="width:80px;" src="humidity.png" alt="Card image cap"></h5>
    <div class="col-md-4">
    <div class=" progress-bar1" data-percent='.$weather['current']['humidity'].' data-duration="1000" data-color="#FFFFFF,#3498DB"></div>
  </div>
  <h4 style="text-shadow: 4px 4px 4px grey;">HUMIDITY</h4>
  </div>
  </div>

  <div class="shadow-lg card">
    <div id="grad1" class="card-body">
    <h5 class="card-title"><img class="mx-auto" style="width:80px;" src="cloud.png" alt="Card image cap"></h5>
    <div class="col-md-4">
    <div class=" progress-bar1" data-percent='.$weather['current']['cloud'].' data-duration="1000" data-color="#FFFFFF,#FDBA04"></div>
  </div>
  <h4 style="text-shadow: 4px 4px 4px grey;">CLOUD</h4>
  </div>
  </div>
  <div class="shadow-lg card">
  <div id="grad1" class="card-body">
  <h5 class="card-title"><img class="mx-auto" style="width:80px;" src="UV.png" alt="Card image cap"></h5>
  <div class="col-md-4">
  <div class="progress-bar1" data-percent='.$weather['forecast']['forecastday']['0']['day']['uv'].' data-duration="1000" data-color="#FFFFFF,#ef3b0e"></div>
  </div>
  <h4 style="text-shadow: 4px 4px 4px grey;">UV</h4>
  </div>
  </div>
  </div>
  <div id="forecasthead" class="jumbotron jumbotron-fluid ">
  	<div style="margin-top:300px;" class="arrow"><a style="text-decoration: none;" class="arrow" href="#forecast">&#x21E3;</a></div>
  </div>
<div id="forecast" class="card-deck  text-center">';

  for($i=1;$i<4;$i++){
      echo '
     <div id="grad2" class="card shadow p-3 mb-3 rounded" id="forecastCard">
     <h5 style="" class="card-header shadow-lg">'.$weather['forecast']['forecastday'][$i]['date'].'</h5>
       <img class="mx-auto" style="width:80px;" src="'.$weather['forecast']['forecastday'][$i]['day']['condition']['icon'].'" alt="Card image cap">
       <div  class="card-body">
        <h1 id="forecastfont" style="font-size=100px;" class="card-text shadow-sm">'.$weather['forecast']['forecastday'][$i]['day']['maxtemp_c'].'/'.$weather['forecast']['forecastday'][$i]['day']['mintemp_c'].'&degC</h1>
         <p id="forecastfont" style="" class="card-text">'.$weather['forecast']['forecastday'][$i]['day']['condition']['text'].'</p>

         <p id="forecastfont" style="" class="card-text">HU: '.$weather['forecast']['forecastday'][$i]['day']['avghumidity'].' | % UV: '.$weather['forecast']['forecastday'][$i]['day']['uv'].'</p>
       </div>
     </div>';
    }
echo '
 </div>
 <div class="card-deck text-center">
';
   for($i=4;$i<7;$i++){
     echo '
      <div id="grad2" class="card shadow p-3 mb-3 rounded" id="forecastCard">
      <h5 style="" class="card-header shadow-lg">'.$weather['forecast']['forecastday'][$i]['date'].'</h5>
        <img class="mx-auto" style="width:80px;" src="'.$weather['forecast']['forecastday'][$i]['day']['condition']['icon'].'" alt="Card image cap">
        <div  class="card-body">
         <h1 id="forecastfont" style="font-size=100px;" class="card-text shadow-sm">'.$weather['forecast']['forecastday'][$i]['day']['maxtemp_c'].'/'.$weather['forecast']['forecastday'][$i]['day']['mintemp_c'].'&degC</h1>
          <p id="forecastfont" style="" class="card-text">'.$weather['forecast']['forecastday'][$i]['day']['condition']['text'].'</p>
          <p id="forecastfont" style="" class="card-text">HU: '.$weather['forecast']['forecastday'][$i]['day']['avghumidity'].'% | UV: ';

          if($weather['forecast']['forecastday'][$i]['day']['uv'] != 39960){echo $weather['forecast']['forecastday'][$i]['day']['uv'].'</p>';}
            else {echo 'Data Not available</p>';}
            echo
        '</div>
      </div>';
     }
echo
  '</div>
  <div style="text-decoration: none;" id="news" class="jumbotron jumbotron-fluid">
  	<div style="margin-top:300px;" class="arrow"><a class="arrow" href="#newscard">&#x21E3;</a></div>
  </div>
  <div id="newscard" class="card-deck">
';
if($nwserror == ""){
  for($i=0;$i<4;$i++){
     echo'
     <div id="grad3"  class="card shadow p-3 mb-5 bg-white rounded" id="">
     <img class="card-img-top" src="'.$news['articles'][$i]['urlToImage'].'" alt="Card image cap">
     <h5 class="card-title shadow-lg">'.$news['articles'][$i]['title'].'</h5>
       <div  class="card-body">
         <p class="card-text">'.$news['articles'][$i]['description'].'</p>
         <p class="card-text">'.$news['articles'][$i]['source']['name'].'</p>
       </div>
       <div class="card-footer">
       <a href="'.$news['articles'][$i]['url'].'" class="card-link">Read Full Article</a>
       </div>
     </div>';
    }
    echo '
</div>
<div class="card-deck">
';
for($i=4;$i<=7;$i++){
echo '
   <div id="grad3" class="card shadow p-3 mb-5 bg-white rounded" id="">
   <img class="card-img-top" src="'.$news['articles'][$i]['urlToImage'].'" alt="Card image cap">
   <h5 class="card-title shadow-lg">'.$news['articles'][$i]['title'].'</h5>
     <div class="card-body">
       <p class="card-text">'.$news['articles'][$i]['description'].'</p>
       <p class="card-text">'.$news['articles'][$i]['source']['name'].'</p>
     </div>
     <div class="card-footer">
     <a href="'.$news['articles'][$i]['url'].'" class="card-link">Read Full Article</a>
     </div>
   </div>
   ';
  }
echo '
</div>
<div class="card-deck">
';
for($i=8;$i<=11;$i++){
echo '
   <div id="grad3" class="card shadow p-3 mb-5 bg-white rounded" id="">
   <img class="card-img-top " src="'.$news['articles'][$i]['urlToImage'].'" alt="Card image cap">
   <h5 class="card-title shadow-lg">'.$news['articles'][$i]['title'].'</h5>
     <div class="card-body">
       <p class="card-text">'.$news['articles'][$i]['description'].'</p>
       <p class="card-text">'.$news['articles'][$i]['source']['name'].'</p>
     </div>
     <div class="card-footer">
     <a href="'.$news['articles'][$i]['url'].'" class="card-link">Read Full Article</a>
     </div>
   </div>
   ';
  }

 echo '
</div>';}else {
  echo '<div style="width:200px;" class="alert alert-danger container text-center" role="alert">'.$nwserror.'</div></div>';
}
}  else if ($error) {
    echo '<div style="width:200px;" class="alert alert-danger container text-center" role="alert">'.$error.'</div></div>';
  }
?>
<script type="text/javascript">
    $('#submitbtn').click(function(event){
          if ($('#location').val()=="") {
            event.preventDefault();
          alert("Enter a proper city name");
        }
    });
        var date=new Date();
    var time = date.getHours();
    if (time>=5 && time<=7) {
      $("#weather").css({"background-image":"url('morning.jpg')"});
    }if (time>=8 && time<=11) {
      $("#weather").css({"background-image":"url('front1.jpg')"});
    }else if(time>=12 && time<=15) {
      $("#weather").css({"background-image":"url('front2.jpg')"});
    }else if(time>=16 && time<=20) {
      $("#weather").css({"background-image":"url('front3.jpeg')"});
    }else if(time>=21 && time<=23) {
      $("#weather").css({"background-image":"url('front4.jpeg')"});
    }else if(time>=24 || time<=4 || time>=1) {
      $("#weather").css({"background-image":"url('night.jpg')"});
    }
    </script>
    <script src="jQuery-plugin-progressbar.js"></script>
    <script>
    $(".progress-bar1").loading();
    </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>
