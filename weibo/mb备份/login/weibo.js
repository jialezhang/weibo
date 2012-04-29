var xmlHttp
function hehe(){alert('aaa');}

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
function at_someone(){
	    var addDiv = document.getElementById("at");

	    var atInput = document.createElement("input");
		 	atInput.style.marginLeft = "10px";
		 	atInput.style.marginTop = "0px";
		 	atInput.style.size="20";
			atInput.type="text";
			atInput.id='att';
            atInput.onkeydown=function(){show_list(this.value)};
        var eeInput = document.createElement("input");
			eeInput.style.marginLeft = "20px";
		 	eeInput.style.marginTop = "0px";
		 	eeInput.style.size="20";
			eeInput.type="button";
			eeInput.id='atte';
                        eeInput.value="确认";
            eeInput.onkeydown=function(){show_list(this.value);};	
		  atInput= addDiv.appendChild(atInput);
		  eeInput = addDiv.appendChild(eeInput);
		  }
function show_list(str){
		//if(str.length==0){
				//  document.getElementById("event").innerHTML=""
  //return
 // }
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)  {
 			 alert ("Browser does not support HTTP Request");		
			 return;
			 } 
		var url="at_ajax.php";
		url=url+"?friends="+str;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=function(){stateChanged()}; 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
				}
 

