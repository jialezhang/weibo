/*var f,ft,n=0,m,a,b,c,d,e;
var t=new Date();
var Afg=new Array();
 
function add_fresh(){
	f=document.getElementById('fresh_out').value;
	m=t.getMonth()+01;
	ft=f+' '+t.getFullYear()+'/'+m+'/'+t.getDate()+'  '+t.getHours()+':'+t.getMinutes();
	Afg[n]=ft;
	n+=1;
	document.getElementById("my_freshthings").innerHTML=Afg;
   } 
   
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
  }*/

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
function add_comment(fre_id,userid){
        var btnOC=document.getElementById('btn.rly'+fre_id);
		    btnOC.value="收起回复";
			btnOC.onclick=function(){close_rly(fre_id,userid);};
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

			btnSit.onclick=function(){reply(fre_id,userid);};
		 	btnSit.style.marginLeft = "10%";                           
		 	btnSit.id=fre_id+'Sit';

		  btnRly= addDiv.appendChild(btnRly);
		  btnSit = addDiv.appendChild(btnSit);

		  //document.getElementById('btn.rly'+fre_id).onclick='close_rly(fre_id)';

       //var close_reply= document.createElementById()
	}
function close_rly(fre_id,userid){
	  var btnOC=document.getElementById('btn.rly'+fre_id);
      var btnRly=document.getElementById(fre_id+'Rly');
	  var btnSit=document.getElementById(fre_id+'Sit');
	  var addDiv=document.getElementById(fre_id);
	  addDiv.removeChild(btnRly);
	  addDiv.removeChild(btnSit);
	  btnOC.value="评论";
	  btnOC.onclick=function(){add_comment(fre_id,userid);};

		}
function reply(fre_id,userid){
	 var str=document.getElementById(fre_id+'Rly').value;
		if(str.length==0){
				alert('Please input right reply!');
				}
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="ajax.php"
		url=url+"?body="+str
		url=url+"&&parent_id="+fre_id
		//url=url+"&&userid="+userid
		//url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=function(){stateChanged();}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
		 window.location.reload();
document.getElementById("zone_information").innerHTML=xmlHttp.responseText ;
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
   

function add_friends(fre){
	var focus=document.getElementById('focus');

	var addDiv=document.getElementById(fre);
	addDiv.value="取消关注";
    addDiv.onclick=function(){concel(fre);}
	var user=document.createElement('input');
	user.type="button";
	user.value="已关注";
	user.id="user"+fre;

	user=focus.appendChild(user);
	addDiv=focus.appendChild(addDiv);
		if(fre==null){
				alert('system error!');
				}
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="ajax_friends.php"
		url=url+"?fre="+fre
		//url=url+"&&userid="+userid
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=function(){stateChangeda()}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		
		
		}
function stateChangeda() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
document.getElementById("zone_information").innerHTML=xmlHttp.responseText ;
 } 
}


function copy(fre_id,userid){
        var btnCy=document.getElementById('btn.copy'+fre_id);
		    btnCy.value="以转载";
			btnCy.onclick=function(){return;};
		if(fre_id==null){
				alert('system error!');
				}
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="ajax_copy.php"
		url=url+"?fre_id="+fre_id
		//url=url+"&&userid="+userid
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=function(){stateChangedb()}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		

	}
function stateChangedb() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
document.getElementById("zone_information").innerHTML=xmlHttp.responseText ;
   alert('转载成功！');
 } 
}
 function concel(fre){
	var focus=document.getElementById('focus');

	var addDiv=document.getElementById(fre);
	addDiv.value="+关注";
    addDiv.onclick=function(){add_friends(fre);}
	var user=document.getElementById("user"+fre);

	focus=focus.removeChild(user);

		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="ajax_delfriends.php"
		url=url+"?fre="+fre
		//url=url+"&&userid="+userid
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=function(){stateChangedd()}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		
function stateChangedd() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
document.getElementById("zone_information").innerHTML=xmlHttp.responseText ;
//window.location.reload();
 } 
}			 
		 }
