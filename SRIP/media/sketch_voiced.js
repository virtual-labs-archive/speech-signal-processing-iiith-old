var button;
var wave;

function preload(){
    sound = loadSound("/media/voiced.wav");
  }

  
  function setup(){
    cnv = createCanvas(600,200);
    background(0);
    button = createButton('generate')
    button.mouseClicked(togglePlay)
    textSize(10);
  fill(255, 255, 255);
  text('amplitude values along the time domain for Voiced sound – Letter “b” in the word “book”', 10, 12);
    spectrum = new p5.FFT();
    
  
    
  }
   
  
  function draw(){

    beginShape();
    noFill();
    stroke(255,0,0); // waveform is red
    strokeWeight(1);
    wave = spectrum.waveform();

  for (var i = 0; i< wave.length; i++){
    var x = map(i, 0, wave.length, 0, width);
     var y = map( wave[i], 1, -1, 0, height);
  
    vertex(x,y);
    
    //console.log(waveform[i])

  }
  
  
  endShape();
} 


  function togglePlay() {
    if (sound.isPlaying()) {
      sound.pause();
    } else {
      sound.play();
      
    
    }
  }
  






