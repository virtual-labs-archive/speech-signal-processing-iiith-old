<html>
<?php
$uttind = $_POST["op"];
$utteng = $_POST["ip"];
$uttflag = $_POST["uttflag"];

$phnseq = $_POST["phn"];
$rsylseq = $_POST["rsyl"];


/*
echo $uttind."<br>";
echo $utteng."<br>";
echo $uttflag."<br>";
echo $phnseq."<br>";
echo $rsylseq."<br>";
*/

if($utteng == '') $uttflag=0; else $uttflag=1;

if($utteng != '' & $phnseq == ''){
	$phnseq = utt2phn($utteng);
	$rsylseq = phn2syl($phnseq);
	//echo $phnseq."<br>".$rsylseq."<br>";
	$phnseq = preg_replace('/#/',' ',$phnseq);
}

function displaysent($exnum){
 if($exnum <1 | $exnum >2){
	echo "Selected example = ".$exnum."<br>";
 	echo "Invalid selection: Select an appropriat example...!";
 }
 
 echo nl2br(implode('',file('wav/ex'.$exnum.'.txt')));
 //$fid = fopen("wav/ex".$exnum.".txt", 
}

function displaylabels($sym){
//echo $sym . ' ' . count($sym).'<br>';

$etypelist = "Select-Extn-type:None:Voiced:Unvoiced:Unvoiced-Unasp-Plosive:Unvoiced-Asp-Plosive:Voiced-Unasp-Plosive:Voiced-Asp-Plosive";
$ele1 = explode(":",$etypelist);

$mannerlist = "Select-manner:None:Stop:Nasal:Semivowel:Short-Vowel:Long-Vowel:Diphthong:Fricative";
$ele2 = explode(":",$mannerlist);

$placelist = "Select-place:None:Velar:Palatal:Alveolar:Retroflex:Dental:Labial:Front-High:Front-Mid:Central-Low:Back-High:Back-Mid";
$ele3 = explode(":",$placelist);


 echo "<table border=1>";
 echo "<tr><td><b>SYM</b></td><td><b>EXTN TYPE</b><td><b>MANNER</b></td><td><b>PLACE</b></td></tr>";
 $units = explode(' ',$sym);
 //echo count($units) . ' ' . sizeof($units) . '<br>';
 for($k=0;$k<sizeof($units);$k++){
  echo "<tr><td>".$units[$k]."</td>";
  echo "<td><select name='".$ele1[0]."' onchange=jsverifylab(this,'".$units[$k]."','".$etypelist."')>";
  for($i=0;$i<count($ele1);$i++){
   echo "<option name=".$i." value=".$i.">".$ele1[$i]."</option>";
  }
  echo "</select></td>";
  echo "<td><select name='".$ele2[0]."' onchange=jsverifylab(this,'".$units[$k]."','".$mannerlist."')>";
  for($i=0;$i<count($ele2);$i++){
   echo "<option name=".$i." value=".$i.">".$ele2[$i]."</option>";
  }
  echo "</select></td>";
  echo "<td><select name='".$ele3[0]."' onchange=jsverifylab(this,'".$units[$k]."','".$placelist."')>";
  for($i=0;$i<count($ele3);$i++){
   echo "<option name=".$i." value=".$i.">".$ele3[$i]."</option>";
  }
  echo "</select></td>";
  echo "</tr>";
 }
 echo "</table>";
}

function utt2phn($utt){
//echo $utt;
$utt = trim($utt);
$utt = preg_replace('/\s+/',' ',$utt);
$utt = preg_replace('/ /','#',$utt);
$tmp = preg_replace('/(.)/','${1} ',$utt);
$tmp = preg_replace('/([aiueo]) ([aiueo])/','${1}${2}',$tmp);
$tmp = preg_replace('/(.) ([~:])/','${1}${2}',$tmp);
$tmp = preg_replace('/([kctpgjdbs\:]) ([h])/','${1}${2}',$tmp);
$tmp = preg_replace('/h h/','hh',$tmp);
$tmp = preg_replace('/(.) x/','${1}x',$tmp);
$tmp = preg_replace('/n ([gjd])~/','n${1}~',$tmp);
$tmp = preg_replace('/\s+/',' ',$tmp);
//$tmp = preg_replace('/#/',' ',$tmp);

return $tmp;
}

function phn2syl($phnseq){
//echo $phnseq;

$tmp = preg_replace('/([^ ]) ([aiueo])/','${1}${2}',$phnseq);
$tmp = preg_replace('/([aiueo]) ([^aiueo# ]+) ([^aiueo ]+)/','${1}${2} ${3}',$tmp);

$tmp = preg_replace('/# ([^aiueo# ]+) ([^aiueo# ]+)/','# ${1}${2}',$tmp);
$tmp = preg_replace('/# ([^aiueo# ]+) ([^aiueo# ]+)/','# ${1}${2}',$tmp);

$tmp = preg_replace('/([^aiueo# ]+) ([^aiueo# ]+) #/','${1}${2} #',$tmp);
$tmp = preg_replace('/([^aiueo# ]+) ([^aiueo# ]+) #/','${1}${2} #',$tmp);

$tmp = preg_replace('/^([^aiueo# ]+) /','${1}',$tmp);
$tmp = preg_replace('/^([^aiueo# ]+) /','${1}',$tmp);

$tmp = preg_replace('/ ([^aiueo]+)$/','${1}',$tmp);
$tmp = preg_replace('/ ([^aiueo]+)$/','${1}',$tmp);

$tmp = preg_replace('/\s+/',' ',$tmp);
$tmp = preg_replace('/#/',' ',$tmp);
return $tmp;
}

?>

<script type=text/javascript>

function jsreset(){
	document.myform.uttflag.value=0;
	document.myform.uttind.value='';
	document.myform.utteng.value='';
	document.myform.phnseq.value='';
	document.myform.rsylseq.value='';
}

function loadwavfile(filename){
	var speechtooljs=document.getElementsByName('speechtool')[0];
	
	var filename = 'ex' + <?php echo $exnum;?> + '.wav';
	//alert(filename);
	speechtooljs.setAudioFile(filename);
	speechtooljs.loadAudio();

}

</script>

<table width=950><tr>
<td><h2>Part-2: Acoustic-Phonetic labeling without feedback </h2></td>
<td width=200 align=right><a href=part1.php><b>&lt;&lt;Part-1</b></a></td>
</tr></table>


<?php

if($uttflag == 1){

 include('displayutt.php');

 echo "<h4>Record your speech, observe the signal characteristics, and provide acoustic-phonetic description of the phonemes.</h4>";
 echo "<table border=1><tr>";
 echo "<td width=620 valign=top>";
 echo "<applet code=audioTransport/SVLAudioTool.class archive='media/speechAnalysis.jar' name='speechtool' width=600 height=400>";
 echo "<param name=foo value='bar'>";
 echo "Please install the latest version of the Java plugin for your browser. <br>";
 echo "</applet><br>";
 echo "</td>";
 echo "</tr></table><br><br>";
// echo "<td width=200 align=center valign=top>";
 echo "<font size=+1><b>Acoustic-Phonetic Description</b></font>";
 displaylabels(preg_replace('/\s+/',' ',trim($phnseq)));
// echo "</td>";
// echo "</tr></table><br>";

 echo '<script type="text/javascript">';
// echo "loadwavfile('ex".$exnum.".wav');";
 echo '</script>';

}
else{
echo "<b>Choose your language and construct a sentence.</b><br>";
include('trans.html');
}
?>
</html>

