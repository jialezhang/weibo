var xmlHttp;
function count(a){
		var a,b,c; 
	    b=140-a.length;
		c=document.getElementById('span').innerHTML=b;
 return c;
  }
   
function add_comment(){
  	   //展开评论

		 var addDiv = document.getElementById("comment");
		 var changeRow = document.createElement("br");
		 var boxObj = document.createElement("input");
		 boxObj.style.marginLeft = "50px";
		 boxObj.style.width = "400px";
		 boxObj.style.marginTop = "0px";
		 var response = document.createElement("input");
		 response.value = "回复";
		 response.type = "submit";
		 response.style.marginLeft = "20px";                           
		  changeRow = addDiv.appendChild(changeRow);
		  boxObj = addDiv.appendChild(boxObj);
		  response = addDiv.appendChild(response);
	}


function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
document.getElementById("comment").innerHTML=xmlHttp.responseText ;
 } 
}	





function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}







function at_someone(){
	    var at_c = document.getElementById('at');

	    var atInput = document.createElement("input");
		 	atInput.style.marginLeft = "20px";
		 	atInput.style.marginTop = "0px";
		 	atInput.style.size=30;
			atInput.id='att';
            atInput.onkeydown=show_list(this.value);
	
		  atInput= at_c.appendChild(atInput);
		  }

function show_list(str)){
		if(str.length==0){
				  document.getElementById("span").innerHTML=""
  return
  }
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="at_ajax.php"
		url=url+"?friends="+str
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=stateChanged(); 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null))
				}
 