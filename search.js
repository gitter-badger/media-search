$("#keyword").keyup(function(){
  key = $("#keyword").val();
  getVideoList(key);
});
function nextPage(keyword,token) {
  document.getElementById("videoList").innerHTML="Searching... <i class='icon-refresh icon-spin'></i>";
    if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp1=new XMLHttpRequest();
    } else { // code for IE6, IE5
      xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp1.onreadystatechange=function() {
      if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
        document.getElementById("videoList").innerHTML=xmlhttp1.responseText;
      }
    }
    keyword = keyword.replace(/ /g, '%2B');
    xmlhttp1.open("GET","search.php?keyword="+keyword+"&nextPage="+token,true);
    xmlhttp1.send();
  }

function getVideoList(keyword) {
  document.getElementById("videoList").innerHTML="Searching... <i class='icon-refresh icon-spin'></i>";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp2 = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp2.onreadystatechange=function() {
    if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
      document.getElementById("videoList").innerHTML = xmlhttp2.responseText;
    }
  }
  
  if(keyword.length > 0){
    keyword = keyword.replace(/ /g, '%2B');
    xmlhttp2.open("GET","search.php?keyword="+keyword,true);
  }else{
    xmlhttp2.open("GET","search.php",true);
  }
  xmlhttp2.send();
}
