<?
include("getid3/getid3.php");
//ini_set('memory_limit', '1900M');
exec("find /home/steve/.cache/google-chrome/Default/Cache -size +2000k -exec file '{}' \; | grep \"ID3\" | awk '{print \"\"$1\"\"}' | cut -d ':' -f 1,3 > turntable.lst");
$handle=fopen("turntable.lst", "r");
while (($buffer = fgets($handle)) !== false)
{
$buffer=trim($buffer);
echo $buffer;

if (filemtime($buffer) < (time()-(60*10)) )
{

$getid3= new getID3;

$arr=$getid3->analyze($buffer);
print_r($arr);
//die();
	copy($buffer, "mp3/".$arr['tags']['id3v2']['artist']['0']." - ".$arr['tags']['id3v2']['title']['0'].".mp3");
unlink($buffer);
//print_r(id3_get_tag($buffer));
}
}
fclose($handle);
