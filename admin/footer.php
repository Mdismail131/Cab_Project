<div id="footer">
    <div id="icon">
        <i class="fa fa-facebook" aria-hidden="true"></i>
        <i class="fa fa-instagram" aria-hidden="true"></i>
        <i class="fa fa-twitter" aria-hidden="true"></i>
    </div>
    <div id="logo">
        <p>CedCab</p>
    </div>
    <div id="quick_links">
        <a href="#features">FEATURES</a>
        <a href="#reviews">REVIEWS</a>
        <a href="#signup">SIGN UP</a>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$('.numbers').on('keyup', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});
$('#location').on('keyup', function () {
    this.value = this.value.replace(/[^a-zA-Z0-9\-]/g, ' ');
});
$('.uname').on('keyup', function () {
    this.value = this.value.replace(/[^a-zA-Z0-9\_\s]/g, '');
});
function printDiv(name) 
{
  var divToPrint=document.getElementById(name);
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}
</script>
</body>
</html>