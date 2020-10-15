<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script defer src="/face-recognition/face-api.min.js"></script>
  <script defer src="/face-recognition/script.js"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      font-family: system-ui;
      align-items: center;
      background:#143142;
      overflow:hidden
    }


    video {
      width: 100%;
      height: 100vh;
      object-fit: cover;
      transform: scaleX(-1);      
      border-radius: 0px;      
    }

    p {
      margin-bottom: 0;
      margin-top: 0;
    }

    canvas {
      /* transform: rotateY(180deg); */
      display: none;
      position: absolute;      
    }

    #alert{
      position: absolute;
      bottom: 0px;
      left:50;      
      min-width: 700px;
      height: 150px;
      padding-top: 35px;
      opacity: 1;
      border-radius: 0px;
      border-radius: 0px;
      bottom: 0;
      overflow: hidden;
      background-image: url("/assets/images/Group 91.png");
      background-size: cover;      
      color: white;
    }

    #face{      
      height: 120px;
      width: 100%;
      margin-right: 20px;
    }

    #box{
      transition: all .2s;
      display: flex;
      justify-content: space-evenly;
      align-items: center;
      margin-top: 10px;
    }

        
    @media only screen and (max-width: 600px) {
      video {
        width: 100%;
        height: 100vh;
        margin-top: 0px;
        bottom: 0px;
        width: 100%;
      }

      #alert{
        bottom:0px;
        width: 120%;                
      }
    }
  </style>
</head>

<body>
  <video id="video" width="720" height="560" autoplay muted></video>
  <div id="alert">
    <div id="box">
        <div>
          <p >ID : <span id="nik"></span> </p>
          <p >Name : <span id="name"></span></p>
          <p >Gender : <span id="gender"></span></p>
          <p >Is late : <span id="late"></span></p>
          <p >Arrival time : <span id="time"></span></p>
          <p >Waktu pulang : <span id="waktu_pulang"></span></p>
        </div>
        <div style="margin-right: 20px;width: 150px;">            
          <img src="/assets/images/no-image.png" id="face" style="border-radius: 10px">    
        </div>
    </div>
  </div>
</body>

</html>