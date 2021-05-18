
<script type="text/javascript"> 
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

  const start_button = document.getElementById('startButton');
  const rest_sound = document.getElementById('restSound');
  const contract_sound = document.getElementById('contractSound');
  const finished_sound = document.getElementById('finishedSound');
  const form_elem = document.querySelector('form');

  form.addEventListener('submit', makeFormData);  
  form_elem.addEventListener('formdata', beginCount);

  function startTimer(i) {
    totalCount++;

    var progress_bar = constructProgressBar(intervalCount, totalCount, restNow);;
    var seconds = 0;

    // run update function every 1000ms (1s)
    timerID = setInterval(function() {
        seconds++;
        $("#stopWatch").html(seconds);

        // update progress bar every 1000ms (1s)
        progress_bar.style.width = (seconds/i*100) + "%";
        progress_bar.innerHTML = (seconds/i*100) + " %";       

        // if we reach the end of the duration of the rest or interval, clear interval, increment if needed, toggle rest
        if (seconds == i) {        
          clearInterval(timerID);

          if (!restNow){intervalCount++};                           
          //if this is not the last interval, set new timer
          if (intervalCount == repetitions) {
            log.innerHTML += "<p>You're done!</p>";
            finished_sound.play();
            start_button.disabled = false;
          } else {
            // toggle rest status after each timer
            restNow = !restNow;            
            //check if rest and continue 
            if (restNow) {startTimer(rest)} else {startTimer(interval)}            
          }
        }
    }, 1000);
  }  

  function constructProgressBar(i, t, r) {
    var progressBarLabel = r ? "Resting" : "Interval " + (i + 1);
    var progress_bar;
    var htmlText;

    if (r) {
      htmlText = 
          '<div class="row align-items-start">' +
            '<div class="col-10 align-self-start">' +
              '<div class="progress" id="progressShell">' +
                '<div class="progress-bar bg-warning" id="progressBar' + t + '" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>' +
              '</div>' +
            '</div>' +
            '<div class="col-2 align-self-end">' +
              '<label class="progress-label" for="progressShell">' + progressBarLabel + '</label>' +
            '</div>' +
          '</div>';

        log.innerHTML += htmlText;
        progress_bar = document.getElementById('progressBar' + t);
        rest_sound.play();
    } else {
      htmlText = 
          '<div class="row align-items-start">' +
            '<div class="col-10 align-self-start">' +
              '<div class="progress" id="progressShell">' + 
                '<div class="progress-bar" id="progressBar' + t + '" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>' +
              '</div>' +
            '</div>' +
            '<div class="col-2 align-self-end">' +
              '<label class="progress-label" for="progressShell">' + progressBarLabel + '</label>' + 
            '</div>' +
          '</div>';

        log.innerHTML += htmlText;  
        progress_bar = document.getElementById('progressBar' + t);
        contract_sound.play();      
    }    
    return progress_bar;
  }  

  function makeFormData(e) {
    let formData = new FormData(form_elem);   
    e.preventDefault();
  }

  function beginCount(e) {
    var d = e.formData;
    let search = new URLSearchParams(d);
    interval = search.get('interval');
    rest = search.get('rest');
    repetitions = search.get('repetitions');

    //disable start button
    start_button.disabled = true;
    startTimer(interval);
  }

</script>

