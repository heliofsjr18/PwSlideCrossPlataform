
<!DOCTYPE html>
<html>
<head>
	<title></title>
	</head>
<body>
<?php  
	

buscaDocumentoHtml("http://www.google.com.br/search?hl=pt-BR&safe=off&gbv=2&sout=1&biw=1024&bih=548&tbm=isch&sa=1&q=guitarra");	
function buscaDocumentoHtml($url){
	$doc = new DOMDocument;
	$doc->preserveWhiteSpace = FALSE;
	@$doc->loadHTMLFile($url);

	$doc2 = new DOMDocument;
	$doc2->preserveWhiteSpace = FALSE;
	$doc2->appendChild($doc->getElementById("ires"));
	//$doc2->appendChild($elemen);

	echo $doc2->saveHTML();
	//return $doc->saveHTML();
	
}

?>
</body>
</html>
s