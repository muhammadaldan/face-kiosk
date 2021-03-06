<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script defer src="/face-recognition/face-api.min.js"></script>
  <script defer src="/js/mqtt.js"></script>
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
      transform: rotateY(180deg);
      /* display: none; */
      width: 150%;
      position: absolute;      
      z-index: 1;
    }
    #alert,
    #alert2{
      background-color: white;
      position: absolute;
      z-index: 2;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50%;
      height: 30%;
      opacity: 0;
      border-radius: 20px;
      bottom: 0;
      background-size: cover;
      color: black;
    }
    #face{      
      height: 210px;
      width: 100%;
      margin-right: 20px;
    }
    #box,
    #box2{
      transition: all .2s;
      display: flex;
      flex-direction: column-reverse;
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
<div id="debugDiv" style="display:none;position:absolute;top:20px;left:10px;width:300px;height:400px;background:white;z-index:10"></div>
  <video id="video" width="720" height="560" autoplay muted></video>
  <div id="alert">
    <div id="box">
        <div>
          <p >ID : <span id="nik"></span> </p>
          <p >Name : <span id="name"></span></p>
          <p >Gender : <span id="gender"></span></p>
          <p >Is late : <span id="late"></span></p>
          <p >Arrival time : <span id="time"></span></p>
          <p >Time home  : <span id="waktu_pulang"></span></p>
          <p >Detection time : <span id="detection_time"></span></p>
        </div>
        <div style="margin-right: 20px;width: 250px;margin-bottom: 20px;margin-top: -100px;">            
          <img src="/assets/images/no-image.png" id="face" style="border-radius: 10px">    
        </div>
    </div>
  </div>
  <div id="alert2">
      <div id="box2" style="text-align: center;height: 100%;display: flex;justify-content: center;align-items: center;">
        <h3>Pastikan kamu dalam frame hanya 1 orang / detection</h3>
      </div>        
  </div>
</body>
</html>