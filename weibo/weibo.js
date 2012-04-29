//function hehe(){alert('aaaa');}

var xmlHttp

function count(a){
	if(a.length<141){
 		b=140-a.length;
		c=document.getElementById("count").innerHTML="还可以输入"+b;
 		return c;
 		}
 		else{
		d=a.length-140;
		e=document.getElementById("count").innerHTML="已超过"+d;
 			return e;
			}
  }
function add_comment(fre_id){
        var btnOC=document.getElementById('btn.rly'+fre_id);
		    btnOC.value="收起回复";
			btnOC.onclick=function(){close_rly(fre_id);};
	    var addDiv = document.getElementById(fre_id);

	    var btnRly = document.createElement("textarea");
		 	btnRly.style.marginLeft = "40px";
		 	btnRly.style.marginTop = "0px";
		 	btnRly.style.rows=2;
		 	btnRly.style.cols=15;
         	btnRly.id=fre_id+'Rly';
			btnRly.name=fre_id+'Rly';

		var btnSit = document.createElement("input");
		 	btnSit.value = "回复";
		 	btnSit.type = "button";

			btnSit.onclick=function(){reply(fre_id);};
		 	btnSit.style.marginLeft = "270px";                           
		 	btnSit.id=fre_id+'Sit';

		  btnRly= addDiv.appendChild(btnRly);
		  btnSit = addDiv.appendChild(btnSit);


	}
function close_rly(fre_id){
	  var btnOC=document.getElementById('btn.rly'+fre_id);
      var btnRly=document.getElementById(fre_id+'Rly');
	  var btnSit=document.getElementById(fre_id+'Sit');
	  var addDiv=document.getElementById(fre_id);
	  addDiv.removeChild(btnRly);
	  addDiv.removeChild(btnSit);
	  btnOC.value="评论";
	  btnOC.onclick=function(){add_comment(fre_id);};

		}
function reply(fre_id){
		str=document.getElementById(fre_id+'Rly').value;
		if(str.length==0){
				alert('Please input right reply!');
				}
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="../otherpage/ajax.php"
		url=url+"?body="+str
		url=url+"&&parent_id="+fre_id
		xmlHttp.onreadystatechange=function(){stateChanged()}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
document.getElementById("event").innerHTML=xmlHttp.responseText ;
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
	    var addDiv = document.getElementById("at");

	    var atInput = document.createElement("input");
		 	atInput.style.marginLeft = "20px";
		 	atInput.style.marginTop = "0px";
		 	atInput.style.size="30";
			atInput.type="text";
			atInput.id='att';
            atInput.onkeydown=function(){show_list(this.value)};
        var eeInput = document.createElement("input");
			eeInput.style.marginLeft = "20px";
		 	eeInput.style.marginTop = "0px";
		 	eeInput.style.size="30";
			eeInput.type="button";
			eeInput.id='att';
            eeInput.onkeydown=function(){show_list(this.value);};	
		  atInput= addDiv.appendChild(atInput);
		  eeInput = addDiv.appendChild(eeInput);
		  }

function show_list(str){
		if(str.length==0){
				  document.getElementById("att").innerHTML=""
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
		xmlHttp.onreadystatechange=function(){stateChanged()}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null));
				}
 
function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
document.getElementById("event").innerHTML=xmlHttp.responseText ;
 } 
}	
