<html>

<script type="text/javascript" src="/js/MathJax/MathJax.js?config=default"></script>

<table><tr>
<td width=600><h3>Part-2: Filter design</h3></td>
<td width=200 align=right><a href=part1.php>&lt;&lt; Part-1</a></td>
</tr></table>

<font size=-1>
The transfer function of the second order filter with two complex conjugate pole pair at \( f=F_1 \) and \( f=-F_1 \) is given by
$$ H(z) = \frac{1}{1-2e^{-\pi B_1 T}\cos{(2\pi F_1 T)} z^{-1} + e^{-2\pi B_1 T} z^{-2} },$$ 
where \( T = 1/F_s \) is the sampling interval (in sec) corresponding to a sampling rate of \( F_s \) in samples/sec. Here \( F_1 \) and \( B_1 \) are the formant or resonance frequency and its bandwidth, respectively.

<i>
<ol>
<li>Enter the resonance frequency (0-4000 Hz) and its bandwidth of your choice. (\( F_s = 8000 \))</li>
<li>Observe the impulse response and the frequency response of the filter by clicking on update button.</li>
<li>Listen the output of the filter for a impulse train excitation with a chosen \( F_0 \) value.</li>
<li>Study the effect on filter response for different values of \( F_1 \), \( B_1 \) and \( F_0 \).</li>
</ol>
</i>
</font>

<applet code=filterDesign.FilterDesignApplet.class archive=media/filterDesign.jar width="750" height="300" >
</applet>

</html>
