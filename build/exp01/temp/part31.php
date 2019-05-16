<html>
<?php
$uttind = $_POST["op"];
$utteng = $_POST["ip"];
$uttflag = $_POST["uttflag"];

$phnseq = $_POST["phn"];
$usylseq = $_POST["usyl"];
$rsylseq = $_POST["rsyl"];
$sylflag = $_POST["sylflag"];

if($sylflag == 1){
 $utteng = $_POST["utteng"];
 $uttind = $_POST["uttind"];
}

/*
echo $uttind."<br>";
echo $utteng."<br>";
echo $uttflag."<br>";
echo $phnseq."<br>";
echo $usylseq."<br>";
echo $rsylseq."<br>";
echo $sylflag."<br>";
*/

if($utteng == '') $uttflag=0; else $uttflag=1;
if($usylseq == '') $sylflag=0; else $sylflag=1;

if($utteng != '' & $phnseq == ''){
	$phnseq = utt2phn($utteng);
	$rsylseq = phn2syl($phnseq);
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
 echo "<table border=1>";
 echo "<tr><td><b>SYM</b></td><td><b>BEG</b></td><td><b>END</b></td></tr>";
$units = explode(' ',$sym);
//echo count($units) . ' ' . sizeof($units) . '<br>';
for($i=0;$i<sizeof($units);$i++){
  echo "<tr><td>$units[$i]</td><td><input size=10 type=text value='' name='ubeg$i' /></td><td><input size=10 type=text name='uend$i' /></td></td></tr>";
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
	document.myform.sylflag.value=0;
	document.myform.uttind.value='';
	document.myform.utteng.value='';
	document.myform.phnseq.value='';
	document.myform.rsylseq.value='';
	document.myform.usylseq.value='';
}

function jsverifysyl(){
	if(document.myform.usyl.value == ''){
		alert('Syllabify the utterance first...');
	}
	else{
		document.myform.sylflag.value=1;
		document.myform.submit();
	}
	
}

function loadwavfile(filename){
	var speechtooljs=document.getElementsByName('speechtool')[0];
	
	var filename = 'ex' + <?php echo $exnum;?> + '.wav';
	//alert(filename);
	speechtooljs.setAudioFile(filename);
	speechtooljs.loadAudio();

}

</script>

<table width=1000><tr>
<td><h1>Part-3: Segmentation without feedback </h1></td>
<td width=200 align=right><a href=part21.php><b>&lt;&lt;Part-2</b></a></td>
</tr></table>

<input type=hidden name=sylflag value=0 />

<?php

if($uttflag == 1){

 include('syllabify.php');

 if($sylflag == 1){

 echo "<h4>Record your speech and identify the syllable boundaries</h4>";
 echo "<table border=1><tr>";
 echo "<td width=620 valign=top>";
 //echo "<applet code=audioTransport/SVLAudioTool.class archive='media/svlAudioTool.jar' width=600 height=400>";
 echo "<applet code=audioTransport/SVLAudioTool.class archive='media/speechAnalysisSigned.jar' name='speechtool' width=600 height=400>";
 echo "<param name=foo value='bar'>";
 echo "Please install the latest version of the Java plugin for your browser. <br>";
 echo "</applet><br>";
 echo "</td>";
 echo "<td width=200 align=center valign=top>";
 echo "<font size=-1>Subword unit boundaries</font>";
 displaylabels(preg_replace('/\s+/',' ',trim($rsylseq)));
 echo "</td>";
 echo "</tr></table><br>";

 echo '<script type="text/javascript">';
// echo "loadwavfile('ex".$exnum.".wav');";
 echo '</script>';
 }

}
else{
echo "<b>Choose your language and construct a sentence.</b><br>";
include('trans.html');
}
?>
</html>

