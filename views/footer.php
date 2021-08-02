</div>
<a id="footlink" href="#" onclick="tarjeta()">
<footer>
<div id="footext" align=right>
</footer></a>


<div id="tarjeta">
<center>
<a></a>
</div>
<a href="#" onclick="cerrartarj()" id="lightbox"></a>


<script type="text/javascript">
function tarjeta(){
document.getElementById('lightbox').style.display='block';
document.getElementById('tarjeta').style.display='block';

var popup = $('#tarjeta');
popup.css({
	'left': ($(window).width() / 2 - $(popup).width() / 2) + 'px',
	'top': ($(window).height() / 2 - $(popup).height() / 2) + 'px'
});

}

function cerrartarj(){
document.getElementById('lightbox').style.display='none';
document.getElementById('tarjeta').style.display='none';
}
</script>
