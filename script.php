
<script type="text/javascript"> 
// add progress bar
// add reset button
// disable start button when in progress
// add option to set a time for the routine, instead of number of intervals, but not both
// add volume controls for sounds
// add time stamp for start

  var timerID;

  var interval = 0;
  var rest = 0;
  var repetitions = 1;

  var totalCount = 0;
  var intervalCount = 0;
  var restNow = false; 
  var progressCounter = 0;

  const form = document.getElementById('intervalSetter');
  const log = document.getElementById('log');

  const rest_sound = document.getElementById('restSound');
  const contract_sound = document.getElementById('contractSound');
  const finished_sound = document.getElementById('finishedSound');
  const form_elem = document.querySelector('form');

  form.addEventListener('submit', beginRoutine);  
  form_elem.addEventListener('formdata', beginCount);

  // $("#startButton").click(
  //   startTimer
  // );
    
  // $("#resetButton").click(function (e) {
  //   i = 0;
  // });

  // $("#stopButton").click(function (e) {
  //   i=0;
  //   $("#stopWatch").html(i);
  //   clearInterval(timerID);
  // });

  function startTimer(i) {
    totalCount++;

    var progress_bar;
    var rest_counter;

    var newText = restNow ? "Resting." : "Interval " + (intervalCount + 1) + " in progress.";  
    if (restNow) {
      log.innerHTML += '<div id="rest' + totalCount + '">' + newText + "</div>";  
      rest_counter = document.getElementById('rest'+totalCount);  
      rest_sound.play();
    } else {
      log.innerHTML += 
        '<div class="progress"><div class="progress-bar" id="progressBar' + totalCount + '" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div> ';    
       progress_bar = document.getElementById('progressBar' + totalCount);   
       contract_sound.play();      
    }


    var seconds = 0;
    timerID = setInterval(function() {
        seconds++;
        $("#stopWatch").html(seconds);
        if (!restNow) {
          progress_bar.style.width = (seconds/i*100) + "%";
          progress_bar.innerHTML = (seconds/i*100) + " %";       
        } else {
          rest_counter.innerHTML = seconds;
        }

        // if we reach the end of the duration of the rest or interval, clear interval, increment if needed, toggle rest
        if (seconds == i) {        
          if (!restNow){intervalCount++};                   
        
          //if this is not the last interval, set new timer
          if (intervalCount == repetitions) {
            log.innerHTML += "<p>You're done!</p>";
            finished_sound.play();
            clearInterval(timerID);             
          } else {
            clearInterval(timerID);              
            // toggle rest status after each timer
            restNow = !restNow;            
            //check if rest and continue 
            if (restNow) {startTimer(rest)} else {startTimer(interval)}            
          }
        }
    }, 1000);
  }  

  function beginRoutine(e) {
    let formData = new FormData(form_elem);   
    e.preventDefault();
  }

  function beginCount(e) {
    var d = e.formData;
    let search = new URLSearchParams(d);
    interval = search.get('interval');
    rest = search.get('rest');
    repetitions = search.get('repetitions');
    startTimer(interval);
  }

</script>

