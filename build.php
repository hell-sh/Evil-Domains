<?php
$domains = fopen("output/domains.txt", "w");

fwrite($domains, "# Evil Domains\n# https://github.com/timmyrs/Evil-Domains");

foreach(scandir("lists") as $list)
{
	if(substr($list, -4) == ".txt")
	{
		fwrite($domains, "\n\n### ".substr($list, 0, -4)."\n\n".str_replace("\r", "", file_get_contents("lists/".$list)));
	}
}

fclose($domains);

$formats = json_decode(file_get_contents("formats.json"), true);
$domains = fopen("output/domains.txt", "r");

foreach($formats as $i => $format)
{
	$formats[$i]["stream"] = fopen("output/".$format["name"], "w");
	fwrite($formats[$i]["stream"], $format["note"]."\n\n");
}

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
			foreach($formats as $format)
			{
				fwrite($format["stream"], str_replace("{domain}", $domain, $format["mask"])."\n");
			}
		} else
		{
			foreach($formats as $format)
			{
				fwrite($format["stream"], $domain."\n");
			}
		}
		$domain = "";
	} else
	{
		$domain .= $char;
	}
} while(true);

?>