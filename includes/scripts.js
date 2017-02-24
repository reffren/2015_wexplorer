function clean(link){
	window.open(link.replace("_","http://"));
}
function clean_https(link){
	window.open(link.replace("_","https://"));
}
function new_page(link){
	window.location.assign(link.replace("_","http://wexplorer.ru/"));
}