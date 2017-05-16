<?php
$domains = fopen("output/domains.txt", "w");

fwrite($domains, "# Evil Domains\n# https://github.com/timmyrs/Evil-Domains");

foreach(scandir("lists") as $list)
{
	if(substr($list, -4) == ".txt")
	{
		fwrite($domains, "\n\n### ".substr($list, 0, -4)."\n\n".file_get_contents("lists/".$list));
	}
}

fclose($domains);

$domains = fopen("output/domains.txt", "r");
$hosts = fopen("output/hosts.txt", "w");

fwrite($hosts, "127.0.0.1 localhost\n::1 localhost\n::1 ip6-localhost\n::1 ip6-loopback\n\n");

$domain = "";
$was_empty = false;
do {
	$char = fread($domains, 1);
	if($char == "")
	{
		if($was_empty)
		{
			break;
		} else
		{
			$char = "\n";
			$was_empty = true;
		}
	}
	if($char == "\n")
	{
		if($domain != "" && substr($domain, 0, 1) != "#")
		{
			fwrite($hosts, "0.0.0.0 ".$domain."\n");
		} else
		{
			fwrite($hosts, $domain."\n");			
		}
		$domain = "";
	} else
	{
		$domain .= $char;
	}
} while(true);

fclose($domains);
fclose($hosts);
?>