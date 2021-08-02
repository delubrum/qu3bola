function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    return;
  }
  if (str.length>4) {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("livesearch").innerHTML=this.responseText;
      }
    }
    xmlhttp.open("GET","?c=Grnte&a=Search&q="+str,true);
    xmlhttp.send();
  }
}

function SearchOut() {
document.getElementById("livesearch").innerHTML="";
document.getElementById("search").value="";
}
