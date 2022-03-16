<?php

$opt = getopt('i:c:');
$json = json_decode(file_get_contents('db.json'));
$cn = $opt['c'];
$k = ($json->$cn);
$newlist = [];
$x = 0;
while ($x!=100){
	$o = array_rand($k);
	$saycou_name = $k[$o];
	if (array_search($saycou_name,$newlist)===false){
		$newlist[] = $k[$o];}
	$x++;}
$js = json_decode(file_get_contents('us_status.json'));
$saycou_domin = $js->domin;
if (count($saycou_domin) == 0){
	$saycou_domin = ['yahoo.com'];}

$saycou_combo = [];
$pasw = array(12,123,1234,12345,123456,1234567,12345678,123456789,0,1,2,3,4,5,6,7,8,9,10);
foreach ($newlist as $saycou_line){
	$namee = $saycou_line;
	$x = 0;
	$em = [];
	while ($x!=11){
		$em[] = $saycou_line.$x;
		$x++;}
	$emdo = [];
	foreach ($em as $saycou_name){
		foreach ($saycou_domin as $d){
			$emdo[] = $saycou_name."@".$d;}}

	foreach ($emdo as $saycou_line){
		foreach ($pasw as $psw){
			$saycou_combo[] = $saycou_line.':'.$namee.$psw;}}
	}
$saycou_combo[] = shuffle($saycou_combo);
$infocombo = count($saycou_combo);
$saycou_combo[$infocombo-1] = 'telegram:@saycou';
$chat_id = $opt["i"];
$rn = rand(0,99);
$saycou_namefile = "$rn@saycou.txt";
file_put_contents('./files/'.$saycou_namefile,"telegram:@saycou\n");
foreach ($saycou_combo as $saycou_line){
	file_put_contents('./files/'.$saycou_namefile,$saycou_line."\n",FILE_APPEND);}
exec("php sendcombo.php -f ./files/$saycou_namefile -c $chat_id -i $infocombo");

