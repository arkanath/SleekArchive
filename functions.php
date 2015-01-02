<?php
function formatDate($t)
{
	$tt = time();
	$parsedt = date('j F, Y',$t);
	$parsednow = date('j F, Y',$tt);
	$parsedyes = date('j F, Y',$tt-24*60*60);
	if($parsedt==$parsednow) return "Today";
	if($parsedt==$parsedyes) return "Yesterday";
	return $parsedt;
}

function formatDateTime($t)
{
	return date('g.i a',$t).", ".formatDate($t);
}
?>