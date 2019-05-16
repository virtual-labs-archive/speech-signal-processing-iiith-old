<html>

<script type="text/javascript" src="../js/MathJax/MathJax.js?config=default"></script>

<?php
$spk = $_POST["spk"];
$utt = $_POST["utt"];
$changeflag = $_POST["changeflag"];

/*
echo $spk."<br>";
echo $utt . "<br>";
echo $changeflag . "<br>";
*/

$spkarr = array(1=>"Male",2=>"Female",3=>"Child");
//$uttarr = array(1=>"/i/",2=>"/e/",3=>"/a/",4=>"/o/",5=>"/u/");
$uttarr = array(1=>"/i/",2=>"/e/",3=>"/a/");

if($spk == '') $spk = 0;
if($utt == '') $utt = 0;
if($changeflag == '') $changeflag = 0;

function displaylabels($lspk,$lutt){

	$fname = 'wav/'.$lspk.$lutt.'.txt';
	$fid = fopen($fname,'r');

	if(! $fid){
	 echo "<br>Error: Cannot open file - ".$fname."<br>";
	}
	echo "<table>";
	//echo "<tr><td><b>F0</b></td><td><b>F1</b></td><td><b>F2</b></td></tr>";
	while (!feof($fid) & ($buffer = fgets($fid, 4096)) !== false){
	 list($par, $val, $unit) = sscanf($buffer,'%s %f %s');
	 echo "<tr><td><b>".$par."</b></td><td><input size=10 type=text value='' name='uend$i' onchange=jsverifylab(this,$val) ></td><td><i>".$unit."</i></td></tr>";
	}
	echo "</table>";
}

function showOptionsDrop($array,$ndx){
        $string = '';
        foreach($array as $k => $v){
          $string .= '<option value="'.$k.'" ';
	  if($k == $ndx)
		$string .= 'selected=selected ';
	  $string .= '>'.$v.'</option>'."\n";
        }
        return $string;
}

?>

<script type=text/javascript>
function jschange(){
	document.myform.changeflag.value=1;
}

function jsreset(){
	document.myform.changeflag.value=0;
	document.myform.exnum.value=0;
}

function loadwavfile(filename){
	var speechtooljs=document.getElementsByName('speechtool')[0];
	
	//var filename = 'ex' + <?php echo $exnum;?> + '.wav';
	//alert('Click OK after applet has loaded ...');
	speechtooljs.setAudioFile(filename);
	speechtooljs.loadAudio();

}

function jssubmitform(){
	document.myform.changeflag.value=1;
	document.myform.submit();
}

function jsverifylab(ele,ref){
        //alert(ele.value + ' ' + ref);
        var uval = ele.value;
        var err = Math.abs(uval - ref)/ref*100;
        //alert('Error = ' + uval + ' - ' + ref + ' = ' + err);
        if (err > 10){
                alert('Your measurement is errorneous by ' + err + ' %.');
                ele.value='';
        }
}


</script>

<font size=-1> Select the speaker category, the vowel type, and click on the submit button.</font>
<br><br>

<form method=post name=myform id=myform>
<select name=spk id=spk>
<option value="0">Select speaker</option>
	<?php echo showOptionsDrop($spkarr,$spk); ?>
</select>

<select name=utt id=utt>
<option value="0">Select vowel</option>
	<?php echo showOptionsDrop($uttarr,$utt); ?>
</select>

<input type=submit name=go value=Submit onclick=jssubmitform() />
<input type=submit name=go value=Reset onclick=jsreset() />

<input type=hidden name=changeflag value=0 />



<?php
if($changeflag == 1){

 echo "<br><font size=-1>1. Measure the average fundamental frequency (\(F_0\)) from the autocorrelation sequence of selected speech segment.</font><br>";
 echo "<font size=-1>2. Measure the first three formant frequencies (\(F_1, F_2, F_3\)) from the LP log spectrum.</font><br>";
 echo "<font size=-1>3. Repeat the experiment for different sounds and different speaker category.</font><br>";
 echo "<font size=-1>4. Repeat the experiment for vowels recorded in your own voice.</font><br>";
}
?>

<table><tr>
<td width=620 valign=top>
<applet code=audioTransport.NatureSpeech.class archive='media/NatureOfSpeechS.jar' name='speechtool' width=620 height=480 >
Please install the latest version of the Java plugin for your browser. <br>
</applet><br>
</td>

<?php
if($changeflag == 1){

 echo "<td width=300 align=center valign=top>";
	echo "<font size=-1>Enter pitch (\( F_0 \)), formants (\( F_1 \), \( F_2 \), \( F_3 \)) and vowel duration values.<br>(Hint: \( F_s=8 \) kHz, \( N_{fft}=1024 \))</font>";
	displaylabels($spk,$utt);
 echo "</td>";

 echo '<script type="text/javascript">';
 echo "loadwavfile('".$spk.$utt.".wav');";
// echo "loadwavfile('ex2.wav');";

 echo '</script>';
}
?>

</tr></table>

</form>
</html>

