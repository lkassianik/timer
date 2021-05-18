<html>
 <head>
  <title>Timer</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="timer.css">
<!--   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous"> -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <audio id="restSound" src="rest.mp3" preload="auto"></audio>
  <audio id="contractSound" src="contract.mp3" preload="auto"></audio>
  <audio id="finishedSound" src="finished.mp3" preload="auto"></audio>
 </head>
 <body>
<!--   <button id="startButton">Start</button>
  <button id="resetButton">Reset</button>  
  <button id="stopButton">STOP</button> -->
  <div class="container">
    <p></p>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-8">
        <div class="container" id="log">
<!--           <div class="progress">
            <div class="progress-bar" id="progressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>   -->          
        </div>      
      </div>
      <div class="col-4">
        <form action="" method="get" id="intervalSetter">
          <div class="form-group row">
            <label for="interval">Interval duration (1-90 seconds):</label>
            <input type="number" class="form-control" id="interval" name="interval" required min="0" max="100" placeholder="Interval (1-90 seconds)">
          </div>
          <div class="form-group row">
            <label for="rest">Rest duration (0-120 seconds):</label>
            <input type="number" class="form-control" id="rest" name="rest" required  min="0" max="120" placeholder="Rest (1-120 seconds)">
          </div>
          <div class="form-group row">
            <label for="repetitions">Number of intervals (max 10):</label>
            <input type="number" class="form-control" id="repetitions" name="repetitions" required  min="1" max="10" placeholder="Number of intervals (1-10)">          
          </div>    
          <div class="form-group row">
            <div class="col-sm-2">
              <input type="submit" class="btn btn-primary" value="Start">  
            </div>
            <div class="col-sm-4">
              <input type="submit" class="btn btn-secondary" value="Stop">  
            </div>
            
          </div>    
        </form>

        <div id="stopWatch">0</div>
      </div>
    </div>
  </div>



  <?php include 'script.php'; ?>
 </body>
</html>