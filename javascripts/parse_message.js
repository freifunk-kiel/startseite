/**
 * replaces the content of the field with the id 'message_container'
 * by the content of the GET[message]
 * strips html, and only allows some markdown:
 * 	italic, bold and [titel](link)
 */

function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
    console.log('Query variable %s not found', variable);
}

var message=getQueryVariable('message');

if(message) {
	var m=document.getElementById('message_container')
	message=message.replace(/(<br\s*\/?>)/gi, '\n');
	message=message.replace(/<(?:.|\n)*?>/gm, '');
	message=message.replace(/\[([^\]]+)\]\(([^)]+)\)/gm, '<a href="$1">$2</a>');
	message=message.replace(/\*\*(.*?)\*\*/gm, '<strong>$1</strong>');
	message=message.replace(/\*(.*?)\*/gm, '<em>$1</em>');
	message=message.replace(/\n/gi, '<br>');
	m.innerHTML=message;
}
