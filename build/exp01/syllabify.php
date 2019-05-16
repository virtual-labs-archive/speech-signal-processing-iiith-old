
<form method=post name=myform id=myform>
<h4>Syllabify the utterance and then click on the 'Done' button.</h4>
<table border=1>
<tr><td>Utterance</td><td> <input size=80 type=text name=uttind readonly value='<?php echo $uttind;?>' /></td></tr>
<tr><td>Transliteration</td><td> <input size=80 type=text name=utteng readonly value='<?php echo $utteng;?>' /></td></tr>
<tr><td>Phonemes</td><td> <input size=80 type=text name=phn readonly value='<?php echo $phnseq?>' /></td></tr>
<tr><td>Syllables</td><td> <input size=80 type=text name=usyl value='<?php echo $usylseq;?>' /></td></tr>
<?php 
 if($sylflag == 1){
 echo "<tr><td>Ref Syllables</td><td> <input size=80 type=text name=refsyl readonly value='".$rsylseq."' /></td></tr>";
}
?>
</table>
<input type=submit name=reset value=Reset onclick=jsreset() />
<input type=button name=go value=Done onclick=jsverifysyl() />
<input type=hidden name=sylflag value=0 />
<input type=hidden name=rsyl value='<?php echo $rsylseq; ?>' />
</form>

