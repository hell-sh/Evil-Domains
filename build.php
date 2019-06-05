<?php
$domains = fopen("evil-domains.txt", "w");
fwrite($domains, "# Evil Domains\n# https://github.com/hell-sh/Evil-Domains");
foreach(scandir("lists") as $list)
{
	if(substr($list, -4) == ".txt")
	{
		fwrite($domains, "\n\n### ".substr($list, 0, -4)."\n\n".str_replace("\r", "", file_get_contents("lists/".$list)));
	}
}
fclose($domains);
