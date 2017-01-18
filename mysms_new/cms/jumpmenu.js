// Jump Menu JS

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_jumpMenuGo(selName,targ,restore){ //v3.0
  var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
}

function AddLink(sName) { //Identify and make hyperlink from selected text
  var ta;
  ta = document.getElementById(sName);
  if (window.getSelection) { //mozilla
  	var sText, start, end, y, temptext;
  	start = ta.selectionStart;
  	end = ta.selectionEnd;
  	if (start != end){
		//Get selected text
		ta.setSelectionRange(start,end);
  		sText = ta.value.substring(start,end);
       	//Create link
  		y = window.prompt("Please enter URL:", "http://");
  		if (y){
   			temptext = "<a href=\"" + y + "\">" + sText + "</a>";
   			ta.value = ta.value.substring(0, start) + temptext + ta.value.substring(end);
  		}
  	}
  	else{
    	alert("Please select some text!");
  	}
  }
  else if (document.selection && document.selection.createRange) { //internet explorer
	var sText = document.selection.createRange();
  	if (!sText==""){
    	//Create link
    	// verify textarea or text input box
    	if ((ta.tagName == "TEXTAREA") || (ta.tagName == "INPUT")){
	  		var y;
	  		y = window.prompt("Please enter URL:", "http://");
	  		if (y){
      			var temptext;
      			temptext = "<a href=\"" + y + "\">" + sText.text + "</a>";
      			sText.text = temptext;
	  		}
    	}
  	}
  	else{
    	alert("Please select some text!");
  	}
  }
  else{}
}

function AddBold(sName) { //Identify and place bold tags around selected text
  var ta;
  ta = document.getElementById(sName);
  if (document.getSelection) { //mozilla
  	var sText, start, end, temptext;
  	start = ta.selectionStart;
  	end = ta.selectionEnd;
  	if (start != end){
		//Get selected text
		ta.setSelectionRange(start,end);
  		sText = ta.value.substring(start,end);
       	//Create tags
		temptext = "<strong>" + sText + "</strong>";
		ta.value = ta.value.substring(0, start) + temptext + ta.value.substring(end);
  	}
  	else{
    	alert("Please select some text!");
  	}
  }
  else if (document.selection && document.selection.createRange) { //internet explorer
  	var sText = document.selection.createRange();
  	if (!sText==""){
    	//Create tags
    	// verify textarea or text input box
    	if ((ta.tagName == "TEXTAREA") || (ta.tagName == "INPUT")){ 
      		var temptext;
      		temptext = "<strong>" + sText.text + "</strong>";
      		sText.text = temptext;
    	}
  	}
  	else{
    	alert("Please select some text!");
  	}
  }
  else {}
}

function AddItalic(sName) { //Identify and place italic tags around selected text
  var ta;
  ta = document.getElementById(sName);
  if (document.getSelection) { //mozilla
  	var sText, start, end, temptext;
  	start = ta.selectionStart;
  	end = ta.selectionEnd;
  	if (start != end){
		//Get selected text
		ta.setSelectionRange(start,end);
  		sText = ta.value.substring(start,end);
       	//Create tags
		temptext = "<i>" + sText + "</i>";
		ta.value = ta.value.substring(0, start) + temptext + ta.value.substring(end);
  	}
  	else{
    	alert("Please select some text!");
  	}
  }
  else if (document.selection && document.selection.createRange) { //internet explorer
  	var sText = document.selection.createRange();
  	if (!sText==""){
    	//Create tags
    	// verify textarea or text input box
    	if ((ta.tagName == "TEXTAREA") || (ta.tagName == "INPUT")){ // verify textarea or text input box
      		var temptext;
      		temptext = "<i>" + sText.text + "</i>";
      		sText.text = temptext;
    	}
  	}
  	else{
    	alert("Please select some text!");
  	}
  }
  else {}
}

function UndoHTML(sName) { //Identify and remove all html tags in textarea
  var ta;
  ta = document.getElementById(sName);
  if (document.getSelection) { //mozilla
  	var sText, re, temptext;
  	if (ta){
		//Fing tags
		re = /<(?:.|s)*?>/gim;
  		sText = ta.value;
       	//Remove tags
		temptext = sText.replace(re,"");
		ta.value = temptext;
  	}
  	else{
    	alert("Please select a textarea!");
  	}
  }
  else if (document.selection && document.selection.createRange) { //internet explorer
  	var sText = ta.createTextRange();  
	if (!sText==""){
    	// verify textarea or text input box
	   	if ((ta.tagName == "TEXTAREA") || (ta.tagName == "INPUT")){ // verify textarea or text input box
    		var mytext, temptext, re;
    		re = /<(?:.|s)*?>/gim;
    		temptext = sText.text;
     		mytext = temptext.replace(re,"");
      		sText.text = mytext;
    	}
  	}
  	else{
  		alert("Please select a textarea!");
  	}
  }
  else {}
}