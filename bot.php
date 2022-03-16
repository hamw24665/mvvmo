
<?php

include 'index.php';
print ("- coder: sayco | telegram: https://t.me/saycou\n");
define('TOKEN',readline('- Your Token: '));
define('URL','https://t.me/saycou');

file_put_contents('bot.json',json_encode(array('token'=>TOKEN,'channel'=>1,'admin'=>1,'url'=>URL)));

try {
	$callback = function ($update, $saycou){
		if ($update != null){

		    if (isset($update->callback_query)){
			    $data = $update->callback_query->data;
			    $message_id = $update->callback_query->message->message_id;
			    $call_id = $update->callback_query->message->chat->id;
			    $from_id = $update->callback_query->from->id;
			    $lang = $update->callback_query->from->language_code;
			    $text_call = $update->callback_query->message->text;
			    $call2_id = $update->callback_query->id;
			    $text = false;

			    }

		    if (isset($update->message)){
			    $message = $update->message;
			    $message_id = $update->message->message_id;
			    $chat_id = $message->chat->id;
			    $text = $message->text;
			    $user = $message->from->first_name;
			    $ty = $message->chat->type;
			    $from_id = $message->from->id;
			    $lang = $message->from->language_code;
			    $data = false;
			    }

		    error_reporting(0);

		    if ($lang == 'ar'){

			    $senddomin = 'أرسل الدومين بدون علامة @ مثال : ( outlook.com ) .';
			    $adddomin = 'إضافة';
			    $domin = 'الدومينات';
			    $chose = '- مرحبا بك عزيزي المستخدم, اختر من القائمة .';
			    $back = 'عودة';
			    $usenow = "صنع كومبو";
			    $howtouse = 'كيف استخدم البوت';
			    $help = 'مرحبا ، إضغط على زر (صنع كومبو) و اختر الدولة المراد صنع منها كومبو , يمكنك إضافة دومينات أخرى لصناعة الكومبو .';$dev = 'sayco';
			    $more = "المزيد من الدول ";
			    $last = "الرجوع";
			    $more1 = "المزيد";
			    $wait1 = 'إنتظر قليلا , سيتم إرسال الملف في ثواني قليلة';

			    }






		    else{

			    $senddomin = 'Send the domain without @ tag example : ( outlook.com ).';
			    $add = 'add';
			    $domin = 'domin';
			    $chose = '- Hello dear user of the email tool, choose it from the list .';$dev = 'sayco';
			    $back = 'Back';
			    $usenow = "Make combo";
			    $howtouse = "How to use bot";
			    $help = "• Hi, press the button (making) and choose the state to be making combo , You can add dominoes to make combo";
			    $more = "More countries";
			    $last = "Return";
			    $more1 = "More";
			    $wait1 = 'Wait a little';

			    }

		    error_reporting(0);

		    if (isset($update->message)){

				$saycou->deletemessage([
					'chat_id'=>$from_id,
					'message_id'=>$message_id]);

				$js = json_decode(file_get_contents('us_status.json'));
				$st = $js->add;
				if ($st && strpos($text,'.')){
					$message_id = $js->mid;
					$js->add = false;
					$js->domin[] = $text;
					file_put_contents('us_status.json',json_encode($js));
					$js = json_decode(file_get_contents('us_status.json'));
	                                $arry = ['inline_keyboard'=>[]];
        	                        foreach ($js->domin as $line){
                	                        $arry["inline_keyboard"][] = [["text"=>$line,'callback_data'=>$line]
                        	                                                ,["text"=>'🗑','callback_data'=>'del:'.$line]]; }

                                	$arry["inline_keyboard"][] = [["text"=>$adddomin,"callback_data"=>"add"]];
	                                $arry["inline_keyboard"][] = [["text"=>$back,"callback_data"=>"back"]];

	                                $saycou->editMessageText([
        	                                'chat_id'=>$from_id,
                	                        'message_id'=>$message_id,
                        	                'text'=>$chose,
                                	        'reply_markup'=>json_encode($arry)]);}

					}

		    if ($text == '/start'){
				$saycou->sendMessage([
                                                'chat_id'=>$from_id,
                                                'text'=>$chose,
                                                'reply_markup'=>json_encode([
                                                        'inline_keyboard'=>[
                                                                [['text'=>$usenow,'callback_data'=>'usenow']],
								[['text'=>$domin,'callback_data'=>'domin']],
                                                                [['text'=>$howtouse,'callback_data'=>'howtouse']],
                                                                [['text'=>$dev,'url'=>URL]],


                                                        ]
                                                ])

                                                ]);}

		    if ($data == 'howtouse'){

			$saycou->editMessageText([
					'chat_id'=>$call_id,
					'message_id'=>$message_id,
					'text'=>$help,
					'reply_markup'=>json_encode([
						'inline_keyboard'=>[
							[['text'=>$back,'callback_data'=>'back']]
								]
								 ])
									]);

					}


		    if ($data == 'usenow'){
			$contry = json_decode(file_get_contents('states.json'));
			$x = 1;
			$contry = $contry->$x;
			$arry = ['inline_keyboard'=>[]];
                                foreach ($contry as $key){
					foreach ($key as $k1 => $k2){
                                        $arry["inline_keyboard"][] = [["text"=>$k1,'callback_data'=>$k1],["text"=>$k2,'callback_data'=>$k2]];  }}

				$arry["inline_keyboard"][] = [["text"=>$more,"callback_data"=>"2"]];
                                $arry["inline_keyboard"][] = [["text"=>$back,"callback_data"=>"back"]];

			$saycou->editMessageText([
					'chat_id'=>$call_id,
                                        'message_id'=>$message_id,
                                        'text'=>$chose,
                                        'reply_markup'=>json_encode($arry)]);}

		   if ($data == 'domin' || strpos($data,'del') === 0 ){
				$js = json_decode(file_get_contents('us_status.json'));
    				if (strpos($data,'del') === 0){
					$d = explode(':',$data)[1];
					$ar = array();
					foreach ($js->domin as $line){
						$ar[] = $line;}
					$js->domin= array_diff($ar,[$d]);
					file_put_contents('us_status.json',json_encode($js));}

				$js = json_decode(file_get_contents('us_status.json'));
				$js->add == false;
				$arry = ['inline_keyboard'=>[]];
				foreach ($js->domin as $line){
					$arry["inline_keyboard"][] = [["text"=>$line,'callback_data'=>$line]
									,["text"=>'🗑','callback_data'=>'del:'.$line]]; }

				$arry["inline_keyboard"][] = [["text"=>$adddomin,"callback_data"=>"add"]];
                                $arry["inline_keyboard"][] = [["text"=>$back,"callback_data"=>"back"]];

				$saycou->editMessageText([
                                        'chat_id'=>$call_id,
                                        'message_id'=>$message_id,
                                        'text'=>$chose,
                                        'reply_markup'=>json_encode($arry)]);}


		   if ($data == 'add'){
				$js = json_decode(file_get_contents('us_status.json'));
				$js->add = true;
				$js->mid = $message_id;
				file_put_contents('us_status.json',json_encode($js));
				$saycou->editMessageText([
                                        'chat_id'=>$call_id,
                                        'message_id'=>$message_id,
                                        'text'=>$senddomin,
                                        'reply_markup'=>json_encode([
                                                'inline_keyboard'=>[

                                                                             [['text'=>$back,'callback_data'=>'domin']]

                                                                ]
                                                                 ])                                                                                                          ]);
                                                                                                                                             }

		   if ($data == 'back'){
			$saycou->editMessageText([
                                                'chat_id'=>$call_id,
                                                'message_id'=>$message_id,
                                                'text'=>$chose,
                                                'reply_markup'=>json_encode([
                                                        'inline_keyboard'=>[
                                                                [['text'=>$usenow,'callback_data'=>'usenow']],
								[['text'=>$domin,'callback_data'=>'domin']],
                                                                [['text'=>$howtouse,'callback_data'=>'howtouse']],
                                                                [['text'=>$dev,'url'=>URL]]

                                                        ]
                                                ])

                                                ]);}

		   if ($data == '2'){
			$contry = json_decode(file_get_contents('states.json'));
			$x = 2;
                        $contry = $contry->$x;
                        $arry = ['inline_keyboard'=>[]];
                                foreach ($contry as $key){
                                        foreach ($key as $k1 => $k2){
                                        $arry["inline_keyboard"][] = [["text"=>$k1,'callback_data'=>$k1],["text"=>$k2,'callback_data'=>$k2]];
                                }}
                                $arry["inline_keyboard"][] = [["text"=>$more1,"callback_data"=>$x+1],["text"=>$last,"callback_data"=>"usenow"]];
                                $arry["inline_keyboard"][] = [["text"=>$back,"callback_data"=>"back"]];

                        $saycou->editMessageText([
                                        'chat_id'=>$call_id,
                                        'message_id'=>$message_id,
                                        'text'=>$chose,
                                        'reply_markup'=>json_encode($arry)]);}

		   $list = array("3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22");

		   if (array_search($data,$list)!==false){
                        $contry = json_decode(file_get_contents('states.json'));
                        $x = $data;
                        $contry = $contry->$x;
                        $arry = ['inline_keyboard'=>[]];
                                foreach ($contry as $key){
                                        foreach ($key as $k1 => $k2){
                                        $arry["inline_keyboard"][] = [["text"=>$k1,'callback_data'=>$k1],["text"=>$k2,'callback_data'=>$k2]];
                                }}
                                $arry["inline_keyboard"][] = [["text"=>$more1,"callback_data"=>$x+1],["text"=>$last,"callback_data"=>$x-1]];
                                $arry["inline_keyboard"][] = [["text"=>$back,"callback_data"=>"back"]];

                        $saycou->editMessageText([
                                        'chat_id'=>$call_id,
                                        'message_id'=>$message_id,
                                        'text'=>$chose,
                                        'reply_markup'=>json_encode($arry)]);}

		   if ($data == '23'){                                                                                                                                                                    $contry = json_decode(file_get_contents('states.json'));
                        $x = 23;
                        $contry = $contry->$x;
                        $arry = ['inline_keyboard'=>[]];
                                foreach ($contry as $key){
                                        foreach ($key as $k1 => $k2){
                                        $arry["inline_keyboard"][] = [["text"=>$k1,'callback_data'=>$k1],["text"=>$k2,'callback_data'=>$k2]];
                                }}

                                $arry["inline_keyboard"][] = [["text"=>$last,"callback_data"=>$x-1]];
                                $arry["inline_keyboard"][] = [["text"=>$back,"callback_data"=>"back"]];

                        $saycou->editMessageText([
                                        'chat_id'=>$call_id,
                                        'message_id'=>$message_id,
                                        'text'=>$chose,
                                          'reply_markup'=>json_encode($arry)]);}

			$arr = json_decode(file_get_contents('arrayofstates.json'));
                        if (array_search($data,$arr)!==false){
						$saycou->editMessageText([
        	                                       'chat_id'=>$call_id,
               		                                'message_id'=>$message_id,
                               		                'text'=>$wait1,
					                                                ]);
						$contry = $data;
						exec("php makecombo.php -i $from_id -c $contry");
								}

				}

				};


	$saycou = new EzTG(array('throw_telegram_errors'=>false,'token' => TOKEN, 'callback' => $callback));

} catch(Exception $e){
	$x = $e->getMessage().PHP_EOL;
	print_r ($x);}

