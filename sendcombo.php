<?php



    $opt = getopt("f:c:i:");
    $token = json_decode(file_get_contents('bot.json'));
    define('BOT',$token->token);define('URL',$token->url);
    define("CHAT_ID",$opt['c']);
    define("AD",$token->admin);
    define('FILENAME',$opt["f"]);
    $inf = $opt["i"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".BOT."/sendDocument?chat_id=" . CHAT_ID);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), FILENAME);
    $cFile = new CURLFile(FILENAME, $finfo);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "document" => $cFile,
	'caption'=>" combo : $inf",
	"reply_markup"=>json_encode([
		'inline_keyboard'=>[
			[['text'=>'sayco','url'=>URL]]
				]])
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    exec("rm ".FILENAME);

