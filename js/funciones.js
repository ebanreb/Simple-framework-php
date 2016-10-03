function dialog(url,msg){
	if(confirm(msg)){
	    window.location=url;
	}
}

function desmarca(f,rad){
	for (var i = 0; i < f.elements[rad].length; i++) {
f.elements[rad][i].checked = false;
} 

}