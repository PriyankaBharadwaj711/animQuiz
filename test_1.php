<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      margin: 30px;
    }
    
    .topnav {
      overflow: hidden;
      background-color: #333;
      
    }
    
    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }
    
    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }
    
    .topnav a.active {
      background-color: #4CAF50;
      color: white;
    }
    </style>
    </head>
    <body>
    <div class = "container-fluid" style = "background-color : #f5f5f5 ; margin: 10px" >
      <div class = "row">
        <div class="col-md-12 col-centered">
    <br>   
    
        <div  style="background-color : White; margin:60px;">
            <div class="topnav">
                <a class="active" href="#home">Lifescreen Animated Tool</a>
            </div>
            <div style = "margin:30px;">
                <h3 style = "color:black">Dear '.$fname.' </h3>
                <h3 style = "color:black">Thank you for your participation.

                <p>Kindly click on the link below to change your password</p>
                <p><a href="http://localhost:8888/animquiz/forgot_password.php?id='.$encrypted.'&verison=2">Click here to verify your email address</a></p>
                        
                Have a great day!</h3>
            </div>
            <br>
            <br>
            </div>
          </div>
            
        </div>
        <br>
        <br>
        <br>
    </div>
    </body>
    </html>