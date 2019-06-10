var spectrum;


var buttons = {
    play: document.getElementById("btn-play"),
    //pause: document.getElementById("btn-pause"),
    //stop: document.getElementById("btn-stop")
};

var Spectrum = WaveSurfer.create({
    container: '#spectrum',
    waveColor: '0',
    progressColor: "0"
});

buttons.play.addEventListener("click", function(){
    Spectrum.play();

    buttons.pause.disabled = false;
    buttons.play.disabled = true;
}, false);

// Handle Pause button
//buttons.pause.addEventListener("click", function(){
    //Spectrum.pause();

    // Enable/Disable respectively buttons
    //buttons.pause.disabled = true;
    //buttons.play.disabled = false;
//}, false);


// Handle Stop button
//buttons.stop.addEventListener("click", function(){
    //Spectrum.stop();

    // Enable/Disable respectively buttons
   // buttons.pause.disabled = true;
    //buttons.play.disabled = false;
    //buttons.stop.disabled = true;
//}, false);


// Add a listener to enable the play button once it's ready
Spectrum.on('ready', function () {
    buttons.play.disabled = false;
});

// If you want a responsive mode (so when the user resizes the window)
// the spectrum will be still playable
window.addEventListener("resize", function(){
    // Get the current progress according to the cursor position
    var currentProgress = Spectrum.getCurrentTime() / Spectrum.getDuration();

    // Reset graph
    Spectrum.empty();
    Spectrum.drawBuffer();
    // Set original position
    Spectrum.seekTo(currentProgress);

    // Enable/Disable respectively buttons
    //buttons.pause.disabled = true;
    buttons.play.disabled = false;
    //buttons.stop.disabled = false;
}, false);





// Load the audio file from your domain !
Spectrum.load('spectrum')


// function preload(){
//     
//     sound = loadSound('hid_f 2.wav');
//    }
   
   

 