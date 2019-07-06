var button;
var rawplot;
var residueplot;

function preload(){
    sound = loadSound("/media/voiced.wav");
  }

  
  function setup(){
  createCanvas(800,200);
  button = createButton('generate')
  button.mouseClicked(togglePlay)
  textSize(9);
  fill(255,0,0);
  text('amplitude values along the time domain for Voiced sound – Letter “b” in the word “book”', 10, 12);
  fill(0,0,0);
  text('residual signal of the voiced sound', 500, 12);
  spectrum = new p5.FFT(0,512);
    
  
    
  }
   
  
  function draw(){
  
  drawrawplot();
  drawresidueplot();
  
}    


function drawrawplot() {
    beginShape();
    noFill();
    stroke(255,0,0); // waveform is red
    strokeWeight(1);
    waveform = spectrum.waveform();

  for (var i = 0; i< waveform.length; i++){
    var x = map(i, 0, waveform.length, 0, 390);
    var y = map( waveform[i], 1, -1, 0, height);
  
    vertex(x,y);
    
    //console.log(waveform[i])

  }
  endShape();
}

function drawresidueplot() {
  beginShape();
    noFill();
    stroke(0,0,0); // waveform is black
    strokeWeight(1);
    wave = spectrum.waveform();
    //console.log(wave)

  for (var i = 0; i< wave.length; i++){
    var x = map(i, 0, wave.length, 410, 800);
    var new_signal = wave[i] + wave[i-1]
    //console.log(new_signal)
    var y = map(new_signal, 1, -1, 0, height);
  
    vertex(x,y);
    
    

  }
  endShape();
  
}



 

//====================================================================
  function togglePlay() {
    if (sound.isPlaying()) {
      sound.pause();
    } else {
      sound.play();
      
    
    }
  }
  






