<html>
<?php
$exnum = $_POST["exnum"];
$changeflag = $_POST["changeflag"];

/*
echo $exnum."<br>";
echo $changeflag . "<br>";
*/

function displaysent($exnum){
 if($exnum <1 | $exnum >4){
	echo "Selected example = ".$exnum."<br>";
 	echo "Invalid selection: Select an appropriat example...!";
 }

 $fname =  'wav/ex'.$exnum.'.txt';
 //echo nl2br(implode('',file($fname)));
 $fid = fopen($fname, 'r');
 $labels=array('Utterance','Transliteration','Syllables','Phonemes'); 
 for($i=0;$i<4 & ($buffer[$i] = fgets($fid, 4096)) !== false & !feof($fid);$i++);
 echo '<table border=1>';
 echo '<tr><td><b>'.$labels[0].'</b></td><td>'.$buffer[0].'</td></tr>';
 echo '<tr><td><b>'.$labels[1].'</b></td><td>'.$buffer[1].'</td></tr>';
 echo '<tr><td><b>'.$labels[2].'</b></td><td>'.$buffer[2].'</td></tr>';
 echo '<tr><td><b>'.$labels[3].'</b></td><td>'.$buffer[3].'</td></tr>';
  echo '</table>';
 

 //echo nl2br(implode('',file('wav/ex'.$exnum.'.txt')));
 //$fid = fopen("wav/ex".$exnum.".txt", 
}

function drawselectlist($arr){
 $ele = explode(":",$arr);
 //echo $ele[0].' '.$count($ele);
 echo "<select name='".$ele[0]."'>";
 for($i=0;$i<count($ele);$i++){
  echo "<option name=".$i." value=".$i.">".$ele[$i]."</option>";
 }
 echo "</select>";

}

function displaylabels($exnum){

$etypelist = "Select-Extn-type:None:Voiced:Unvoiced:Unvoiced-Unasp-Plosive:Unvoiced-Asp-Plosive:Voiced-Unasp-Plosive:Voiced-Asp-Plosive";
$ele1 = explode(":",$etypelist);

$mannerlist = "Select-manner:None:Stop:Nasal:Semivowel:Short-Vowel:Long-Vowel:Diphthong:Fricative";
$ele2 = explode(":",$mannerlist);

$placelist = "Select-place:None:Velar:Palatal:Alveolar:Retroflex:Dental:Labial:Front-High:Front-Mid:Central-Low:Back-High:Back-Mid";
$ele3 = explode(":",$placelist);

$fname = 'wav/ex'.$exnum.'.phn.ap';
$fid = fopen($fname,'r');

if(! $fid){
 echo "Error: Cannot open file - ".$fname."<br>";
}

$k=0;
while (!feof($fid) & ($buffer = fgets($fid, 4096)) !== false){
 list($unit[$k], $beg[$k], $end[$k],$etype[$k],$manner[$k],$place[$k]) = sscanf($buffer,'%s %d %d %s %s %s');
 $k++;
}
$phncount=$k;

echo "<table border=1>";
echo "<tr><td><b>SYM</b></td><td><b>BEG</b></td><td><b>END</b></td><td><b>EXTN TYPE</b><td><b>MANNER</b></td><td><b>PLACE</b></td></tr>";
//while (!feof($fid) & ($buffer = fgets($fid, 4096)) !== false){
// list($unit, $beg, $end) = sscanf($buffer,'%s %d %d');
for($k=0;$k<$phncount;$k++){
 echo "<tr><td><input style='width:60px' type=button value=".$unit[$k]." onclick=jszoomtosym(".$beg[$k].','.$end[$k].") /></td>"."<td>".$beg[$k]."</td>"."<td>".$end[$k]."</td>";
 echo "<td><select name='".$ele1[0]."' onchange=jsverifylab(this,'".$etype[$k]."','".$etypelist."')>";
 for($i=0;$i<count($ele1);$i++){
  echo "<option name=".$i." value=".$i.">".$ele1[$i]."</option>";
 }
 echo "</select></td>";
 echo "<td><select name='".$ele2[0]."' onchange=jsverifylab(this,'".$manner[$k]."','".$mannerlist."')>";
 for($i=0;$i<count($ele2);$i++){
  echo "<option name=".$i." value=".$i.">".$ele2[$i]."</option>";
 }
 echo "</select></td>";
 echo "<td><select name='".$ele3[0]."' onchange=jsverifylab(this,'".$place[$k]."','".$placelist."')>";
 for($i=0;$i<count($ele3);$i++){
  echo "<option name=".$i." value=".$i.">".$ele3[$i]."</option>";
 }
 echo "</select></td>";
 echo "</tr>";
}
echo "</table>";

/*
echo "Unit | Beg | End<br>";
echo "-----------------------------<br>";
 if($exnum <1 | $exnum >2){
	echo "Selected example = ".$exnum."<br>";
 	echo "Invalid selection: Select an appropriat example...!";
 }
 
 echo nl2br(implode('',file('wav/ex'.$exnum.'.lab')));
 //$fid = fopen("wav/ex".$exnum.".txt", 
*/
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
	
	var filename = 'ex' + <?php echo $exnum;?> + '.wav';
	//alert(filename);
	speechtooljs.setAudioFile(filename);
	speechtooljs.loadAudio();

}

function jszoomtosym(sbeg,send){
	//alert(sbeg + ' ' + send);
	var speechtooljs=document.getElementsByName('speechtool')[0];
	speechtooljs.setAudioSelection(sbeg-32,send+32);
}
	
function jsverifylab1(ele){
alert('I am here: ' + ele.value);
}

function jsverifylab(ele,ref,reflist){
	//alert('Ele value: ' + ele.value);
	refarr = reflist.split(':');
	//alert('Arr value: ' + refarr[ele.value]);
	var uval = refarr[ele.value];
	//alert('User value: ' + refarr[ele.value] + '\n Ref value: ' + ref);
	if (uval.toLowerCase() !=  ref.toLowerCase()){
		alert('Invalid choice. Try again...');
		ele.value=0;
	}
/*
	else{
		alert("Correct value = " + ref);
	}
*/
}



</script>


<table width=900><tr>
<td><h2>Part-1: Acoustic-Phonetic Labeling (pre-labeled examples)</h2></td>
<td width=200 align=right><a href=part2.php><b>Part-2 &gt;&gt;</b></a></td>
</tr></table>

<form method=post name=myform id=myform>
<select name=exnum id=exnum onchange=jschange()>
<option name=ex0 value=0 >Select an example</option>
<option name=ex1 value=1 <?php if($exnum=='1') echo 'selected=selected';?> >Ex-1: Hindi</option>
<option name=ex2 value=2 <?php if($exnum=='2') echo 'selected=selected';?> >Ex-2: Telugu</option>
<option name=ex3 value=3 <?php if($exnum=='3') echo 'selected=selected';?> >Ex-3: Kannada</option>
<option name=ex4 value=4 <?php if($exnum=='4') echo 'selected=selected';?> >Ex-4: Tamil</option>
</select>
<input type=submit name=go value=Go />
<input type=submit name=go value=Reset onclick=jsreset() />

<input type=hidden name=changeflag value=0 />

</form>

<?php
if($changeflag == 1){

displaysent($exnum);

 echo "<font size=-1><ol>";
 echo "<li>Select the correct excitation type, manner of articulation (MoA) and place of articulation (PoA) for each of the phonemes listed in the table.</li>";
 echo "<li>Click on the phoneme symbol (first column of the table) to zoom fit to the presegmented label, and observe the signal characteristics.</li>";
 echo "</ol></font>";

 echo "<table><tr>";
 echo "<td width=620 valign=top>";
 echo "<applet code=audioTransport/SVLAudioTool.class archive='media/speechAnalysis.jar' name='speechtool' width=600 height=400>";
 echo "<param name=foo value='bar'>";
 echo "Please install the latest version of the Java plugin for your browser. <br>";
 echo "</applet><br>";
 echo "</td>";
 echo "</tr></table>";
// echo "<td width=200 valign=top>";
 displaylabels($exnum);
// echo "</td>";
// echo "</tr></table>";

 echo '<script type="text/javascript">';
 echo "loadwavfile('ex".$exnum.".wav');";
 echo '</script>';

}
?>

</html>

