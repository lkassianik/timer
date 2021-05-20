// add reset and pause button
// add option to set a time for the routine, instead of number of intervals, but not both
// add volume controls for sounds
// add time stamp for start

  var timerID = null;

  // user inputs
  var interval = 0;
  var rest = 0;
  var repetitions = 0;

  // counters
  var totalCount = 0;
  var intervalCount = 0;
  var restNow = false; 
  var progressCounter = 0;
  var seconds = 0;

  // document elements
  const form = document.getElementById('intervalSetter');
  const log = document.getElementById('log');

  const start_button = document.getElementById('startButton');
  const stop_button = document.getElementById("stopButton");
  const proxy_submit_button = document.getElementById("proxySubmitButton");

  const rest_sound = document.getElementById('restSound');
  const contract_sound = document.getElementById('contractSound');
  const finished_sound = document.getElementById('finishedSound');
  const form_elem = document.querySelector('form');

  // event listeners
  stop_button.addEventListener('click', buttonClickHandler, false);
  form.addEventListener('submit', makeFormData);  

  function startTimer(i) {
    totalCount++;
    seconds = 0;

    var progress_bar = constructProgressBar(intervalCount, totalCount, restNow);

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
            readyTimer();
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
              '<div class="progress">' + 
                '<div class="progress-bar" id="progressBar' + t + '" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>' +
              '</div>' +
            '</div>' +
            '<div class="col-2 align-self-end">' +
              '<label class="progress-label">' + progressBarLabel + '</label>' + 
            '</div>' +
          '</div>';

        log.innerHTML += htmlText;  
        progress_bar = document.getElementById('progressBar' + t);
        contract_sound.play();      
    }    
    return progress_bar;
  }  

  function readyTimer() {
    Array.from(form.elements).forEach(formElement => formElement.disabled = false);
    timerID = null;
    restNow = false; 
  }

  function stopTimer() {
    if (timerID) {clearInterval(timerID)};
    repetitions = intervalCount;
    log.innerHTML += "<p>Timer stopped.</p>";
    finished_sound.play();    
    readyTimer();
  }

  function buttonClickHandler(e) {
    stopTimer();
    e.preventDefault();
  }

  function makeFormData(e) {
    beginCount(new FormData(form_elem));
    e.preventDefault();
  }

  function beginCount(d) {
    let search = new URLSearchParams(d);
    interval = parseInt(search.get('interval'));
    rest = parseInt(search.get('rest'));
    repetitions += parseInt(search.get('repetitions'));
    action = search.get('action');

    //disable form
    Array.from(form.elements).forEach(formElement => formElement.disabled = true);
    stop_button.disabled = false;

    startTimer(interval);
  }