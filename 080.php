<?php
header("Content-Type: text/html; charset=utf-8"); 
//отменяем лимит времени и запускаем таймер работы скрипта
set_time_limit(0);
$mtime=explode(" ",microtime());
$tstart=$mtime[1]+$mtime[0];

////////////////////////////////////////////////////////////////////////////
// перекодировка транслит
$translit = array("\xd1\x91"=>"e","\xd0\xb9"=>"y","\xd1\x86"=>"ts","\xd1\x83"=>"u","\xd0\xba"=>"k","\xd0\xb5"=>"e","\xd0\xbd"=>"n","\xd0\xb3"=>"g","\xd1\x88"=>"sh","\xd1\x89"=>"shch","\xd0\xb7"=>"z","\xd1\x85"=>"kh","\xd1\x8a"=>"","\xd1\x84"=>"f","\xd1\x8b"=>"y","\xd0\xb2"=>"v","\xd0\xb0"=>"a","\xd0\xbf"=>"p","\xd1\x80"=>"r","\xd0\xbe"=>"o","\xd0\xbb"=>"l","\xd0\xb4"=>"d","\xd0\xb6"=>"zh","\xd1\x8d"=>"e","\xd1\x8f"=>"ya","\xd1\x87"=>"ch","\xd1\x81"=>"s","\xd0\xbc"=>"m","\xd0\xb8"=>"i","\xd1\x82"=>"t","\xd1\x8c"=>"","\xd0\xb1"=>"b","\xd1\x8e"=>"yu","\xd0\x81"=>"E","\xd0\x99"=>"Y","\xd0\xa6"=>"TS","\xd0\xa3"=>"U","\xd0\x9a"=>"K","\xd0\x95"=>"E","\xd0\x9d"=>"N","\xd0\x93"=>"G","\xd0\xa8"=>"SH","\xd0\xa9"=>"SHCH","\xd0\x97"=>"Z","\xd0\xa5"=>"KH","\xd0\xaa"=>"","\xd0\xa4"=>"F","\xd0\xab"=>"Y","\xd0\x92"=>"V","\xd0\x90"=>"A","\xd0\x9f"=>"P","\xd0\xa0"=>"R","\xd0\x9e"=>"O","\xd0\x9b"=>"L","\xd0\x94"=>"D","\xd0\x96"=>"ZH","\xd0\xad"=>"E","\xd0\xaf"=>"YA","\xd0\xa7"=>"CH","\xd0\xa1"=>"S","\xd0\x9c"=>"M","\xd0\x98"=>"I","\xd0\xa2"=>"T","\xd0\xac"=>"","\xd0\x91"=>"B","\xd0\xae"=>"YU",);
/////////////////////////////////////////////////////////////////////////////

// инициализируем переменные стартфайл - это начальное имя файла
$catfirmid = 0;
$limitmysql = 100000;
$startfile = 50000;
$firmidprev = 0;
$modelidprev = 0;

//подключаемся к БД и задаем начальное имя файла
$db = mysql_connect("localhost","root");
mysql_select_db("drom_ru" ,$db);
// $reviews = mysql_query("SELECT * FROM reviews ORDER BY id LIMIT 20");
//$reviews = mysql_query("SELECT * FROM reviews WHERE catfirmid > 15 ORDER BY catfirmid, catmodelid LIMIT 10");
// $reviews = mysql_query("SELECT * FROM reviews ORDER BY catfirmid, catmodelid LIMIT 1000");
// $reviews = mysql_query("SELECT * FROM reviews ORDER BY catfirmid, catmodelid LIMIT $limitmysql");
$reviews = mysql_query("SELECT * FROM reviews WHERE catfirmid > $catfirmid ORDER BY catfirmid, catmodelid LIMIT $limitmysql");

// объявляем функции
function uv2($pages, $content, $firm, $model, $title, $firmid, $modelid, $name, $year, $startfile)
	{
	$z=0;
	$rndmonth2uv = rand (1,12);
		if($rndmonth2uv < 10)
		{$rndmonth2uv=$z.$rndmonth2uv;}
	$rndday2uv = rand (1, 28);
		  if($rndday2uv < 10)
		  {$rndday2uv=$z.$rndday2uv;}
	$rndhour2uv = rand (1,11);
		  if($rndhour2uv < 10)
		  {$rndhour2uv=$z.$rndhour2uv;}
	$rndmin2uv = rand (10,59);
	$rndsec2uv = rand (10,59);
	
	// echo "<strong>##".$firm." ".$model."</strong><br />";
	// echo "краткая инфа о модели $firm $model<br /><br />";
	// генерация 2ув
	fwrite($pages,"\n##$firm $model\n");
	// fwrite($pages,"@@keywords=список каталог отзывов опросов фотографий эксплуатация $firm $model\n");
	// fwrite($pages,"@@nosubmenu=true\n");
	fwrite($pages,"@@publish=2009-$rndmonth2uv-$rndday2uv $rndhour2uv:$rndmin2uv:$rndsec2uv\n");
	fwrite($pages,"@@nosubmenu=true\n");
	fwrite($pages,"@@params.perpage=10000\n");
	fwrite($pages,"@@module=zmodule_listpages\n");
	// fwrite($pages,"краткая инфа о модели $firm $model\n");
	// fwrite($pages,"@@params.template=titlepages\n\n");
	}

// генерация 3ув
function uv3($pages, $content, $firm, $model, $title, $firmid, $modelid, $name, $year, $startfile, $h1)
	{
	// формирование случайной даты публикации, переменная $z=0 - тупо ноль для добавления к счетчику часов/минут	
	$z=0;
	$rndmonth = rand (1,12);
		  if($rndmonth < 10)
		  {$rndmonth=$z.$rndmonth;}
	$rndday = rand (1, 28);
		  if($rndday < 10)
		  {$rndday=$z.$rndday;}
	$rndhour = rand (1,11);
		  if($rndhour < 10)
		  {$rndhour=$z.$rndhour;}
	$rndmin = rand (10,59);
	$rndsec = rand (10,59);
	
	// пишем тайтл
	fwrite($pages,"\n###$title\n");
	
	// новый вариант отложенной публикации, если файл заканчивается на цифру 9, то публикуем 2010 годом
	$str_startfile=strval($startfile);
	$last = $str_startfile{strlen($str_startfile)-1};
	// echo "$last<br />";
	if($last == 9)
		{
		fwrite($pages,"@@file=$startfile\n");
		fwrite($pages,"@@publish=2010-$rndmonth-$rndday $rndhour:$rndmin:$rndsec\n");
		}
	else
		{
		fwrite($pages,"@@file=$startfile\n");
		fwrite($pages,"@@publish=2009-$rndmonth-$rndday $rndhour:$rndmin:$rndsec\n");
		}
	
	// пишем оставшуюся часть контента
	fwrite($pages,"@@keywords=отзыв обзор эксплуатация отчет фото $firm $model\n");
	fwrite($pages,"@@h1=$h1\n");
	fwrite($pages,"$content\n");
	}

// открываем файл для записи
$pages=fopen("pages.txt","w");
echo "начальное значение startfile=$startfile<br />";

////////////////////////////////////////////////////////// запускаем проход таблицы #1 и обработку контента
// пишем заголовок главной страницы
fwrite($pages,"##Отзывы о JDM авто\n");
fwrite($pages,"@@file=index\n");
fwrite($pages,"@@keywords=toyota honda mmc mitsubishi nissan mazda isuzu daihatsu infiniti mitsuoka lexus subaru suzuki\n");
fwrite($pages,"@@description=Сайт о настоящих японских автомобилях JDM - Japan Domestic Market. Лучший способ узнать об эксплуатации авто и оределиться в выборе подходящей модели - прочитать отзывы хозяев.\n");
fwrite($pages,"@@nomenuitem=1\n");
fwrite($pages,"@@filter=text2html, php\n");
fwrite($pages,"@@publish=2009-01-01\n");
fwrite($pages,'<img src="~/pics/jdm.jpg" title="JDM автомобили" />');
fwrite($pages,"\n");

//определяем переменные под счетчик кол-во УВ2, УВ3
$kol_uv2=1;
$kol_uv3=1;

// заполняем главную ссылками
while ($tablerows = mysql_fetch_assoc($reviews))
    {
    //читаем контент, модель и фирму
    $firmid = $tablerows["catfirmid"];
    $modelid = $tablerows["catmodelid"];
    $name = $tablerows["name"];
	$name = iconv("windows-1251", "UTF-8//IGNORE", $name);
    $year = $tablerows["year"];
	$year = preg_replace('/\D/', '', $year);
	$firm = mysql_query("SELECT name FROM firm WHERE id=$firmid" ,$db);
    $firm = mysql_fetch_assoc($firm);
    $firm = $firm["name"];
    $model = mysql_query("SELECT name FROM model WHERE id=$modelid" ,$db);
    $model = mysql_fetch_assoc($model);
    $model = $model["name"];
	
	// транслит $firm $model
	// echo "$firm $model = ";
	$firm_translit = strtolower(strtr($firm, $translit));
	$firm_translit = preg_replace('%&.+?;%', '', $firm_translit);
	$firm_translit = preg_replace('%[^a-z0-9,._-]+%', '-', $firm_translit);
	$firm_translit = trim($firm_translit, '-');
	$model_translit = strtolower(strtr($model, $translit));
	$model_translit = preg_replace('%&.+?;%', '', $model_translit);
	$model_translit = preg_replace('%[^a-z0-9,._-]+%', '-', $model_translit);
	$model_translit = trim($model_translit, '-');
	$url2uv_translit="$firm_translit-$model_translit";
	$str_url2uv_translit = strval($url2uv_translit);
	
	// переменная $last_1 - это последняя цифра $startfile для первого прохода
	$str_startfile_1=strval($startfile);
	$last_1 = $str_startfile_1{strlen($str_startfile_1)-1};
	
	//проверка, если появилась новая фирма пишем на главную
	if($firmidprev != $firmid)
		{
		fwrite($pages,"\n<h2>Отзывы о моделях фирмы $firm:</h2>\n");
		}
	
	// проверка, если появилась новая модель - пишем УВ2 (где расположены уже ссылки на все отзывы по этой модели) и УВ3 - иначе пропустим первый отзыв
	if($modelidprev != $modelid)
		{
		fwrite($pages,"<a href=".'~'."/$url2uv_translit.html>$model</a>\n");
		// echo "firmid: $firmid | modelid: $modelid | УВ2: $kol_uv2 | УВ3: $kol_uv3<br />";
		$kol_uv3=1;
		$kol_uv2++;
		
		if(($last_1 != 9))
			{
			$kol_uv3++;
			$array_url[] = $str_url2uv_translit."/".$startfile.".html";
			}
		}
	
	// если модель и фирма одинаковые, вносим урл в массив
		if(($firmidprev == $firmid)&&($modelidprev == $modelid)&&($last_1 != 9))
		{
		$kol_uv3++;
		$array_url[] = $str_url2uv_translit."/".$startfile.".html";
		}
	
	// инкрементируем значения счетчиков
	$startfile++;
	
	// записываем текущие значения firmid и modelid (для выяснения необходимости формирования списка на главной)
	$firmidprev = $firmid;
    $modelidprev = $modelid;
    }

// итоговая статистика УВ2 УВ3
// echo "firmid: $firmid | modelid: $modelid | УВ2: $kol_uv2 | УВ3: $kol_uv3<br />";
	
$endfile = $startfile;

// пишем карту сайта сайтмэп
// fwrite($pages,"##Карта сайта\n");
// fwrite($pages,"@@file=sitemap\n");
// fwrite($pages,"@@module=zmodule_sitemap\n");
// fwrite($pages,"@@param.subpage=p.\n");
// fwrite($pages,"@@nomenuitem=1\n");
// fwrite($pages,"@@publish=2009-01-01\n");


////////////////////////////////////////////////////////// закрываем проход таблицы #1
mysql_close($db);
echo "<br /><pre>";
print_r($array_url);
echo "</pre><br />";

////////////////////////////////////////////////////////// запускаем проход таблицы #2 и обработку контента
// ОБНУЛЯЕМ переменные стартфайл - это начальное имя файла
$startfile=50000;
$firmidprev=0;
$modelidprev=0;

//подключаемся к БД и задаем начальное имя файла
$db = mysql_connect("localhost","root");
mysql_select_db("drom_ru" ,$db);
$reviews = mysql_query("SELECT * FROM reviews WHERE catfirmid > $catfirmid ORDER BY catfirmid, catmodelid LIMIT $limitmysql");

while ($tablerows = mysql_fetch_assoc($reviews))
    {
    //читаем контент, модель и фирму
    $firmid = $tablerows["catfirmid"];
    $modelid = $tablerows["catmodelid"];
    $content = $tablerows["htmltext"];
    $name = $tablerows["name"];
	$name = iconv("windows-1251", "UTF-8//IGNORE", $name);
    $year = $tablerows["year"];
	$year = preg_replace('/\D/', '', $year);
	$firm = mysql_query("SELECT name FROM firm WHERE id=$firmid" ,$db);
    $firm = mysql_fetch_assoc($firm);
    $firm = $firm["name"];
    $model = mysql_query("SELECT name FROM model WHERE id=$modelid" ,$db);
    $model = mysql_fetch_assoc($model);
    $model = $model["name"];
	
	//формируем тайтл
	$h1 = $firm." ".$model." ".$year." - ".$name;
	$title = $firm." ".$model." ".$year;
	$title = strip_tags($title);
	// $title = str_ireplace("<input", "", $title);
	//список замен
	$content = preg_replace('~<table.*?./p>~si', '', $content);
    $content = preg_replace('~<table.*?./table>~si', '', $content);
    $content = preg_replace('~<hr.*?./h4>~si', '', $content);
	$content = str_ireplace("<b>Комплектация салона:</b><br>", "<br />Подробно о салоне: ", $content);
	$content = str_ireplace("<b>Комплектация кузова:</b><br>", "<br />Подробно о кузове: ", $content);
	$content = str_ireplace("<b>Комплектация ходовой части:</b><br>", "<br />Подробно о ходовой: ", $content);
	$content = str_ireplace("<b>Комплектация двигателя:</b><br>", "<br />Подробно о двигателе: ", $content);
	$content = str_ireplace("Цвет машины", "<br />Цвет кузова", $content);
	$content = str_ireplace("Цвет салона", "<br />Цвет сидений, обшивки салона", $content);
	$content = str_ireplace("#61516;", "", $content);
	$content = str_ireplace("&#61514;", "", $content);
	$content = str_ireplace("<p>", "", $content);
	$content = str_ireplace("</p>", "", $content);
	$content = str_ireplace("<b>", "", $content);
	$content = str_ireplace("</b>", "", $content);
	$content = str_ireplace("<strong>", "", $content);
	$content = str_ireplace("</strong>", "", $content);
	$content = str_ireplace("<i>", "", $content);
	$content = str_ireplace("</i>", "", $content);
	$content = str_ireplace("Название комплектации (то, что написано на багажнике, на дверях)", "<br />Подробно о комплектации", $content);
	$content = str_ireplace("ОПИСАНИЕ КОМПЛЕКТАЦИИ МАШИНЫ:", "<br /><h2>Дополнительная информация</h2>", $content);
	// замена повторяющихся пробелов на один
	$content=str_replace("\r","",$content);
	//замены копирайтов и источников
    $content = str_ireplace("-- взято с форума auto.vl.ru --", "<noindex>по материалам сайта: auto.vl.ru</noindex>", $content);
    $content = str_ireplace("-- взято с форума auto.ru --", "<noindex>источник: сайт auto.ru</noindex>", $content);
	$content = str_ireplace('Отзыв написан для "Клуб Лексус Россия" http://www.club-lexus.ru и auto.vl.ru, копирование на другие сайты запрещено.', "", $content);
	$content = str_ireplace('(c) Оригинал этого отзыва находится на клубном сайте "Клуб Лексус Россия"', "", $content);
	$content = str_ireplace("http://www.club-lexus.ru", "", $content);
	$content = str_ireplace("http://club-lexus.ru/forum/viewtopic.php?t=1242", "", $content);
	// обработка картинок
	$content = str_ireplace("@images_path@reviews", "~/pics", $content);
	$content = str_ireplace("<img", "<br /><img", $content);
	
	// делаем произвольное число замен для перелинковки
	$numcrosslinks = rand (1,3);
	for ($icross = 1; $icross <= $numcrosslinks; $icross++)
		{
		// поиск русских слов свыше 6 символов тут была ОГРОМНАЯ проблема - решение в \w!!!!111
		preg_match_all("/\w{5,}/", $content, $matches, PREG_OFFSET_CAPTURE);
		$matches = $matches[0];		
		if ( count($matches) == 0)
			{
			// тут выдаем ошибку, если 
			echo "<h1>Отсутствуют слова, которые можно сделать ссылкой!!!!111</h1>";
			continue;
			}
			
		//берем случайный элемент массива
		//тут мне зяки помог, с 0+сайзофф
		$rand_url_file = rand(0,0+sizeof($array_url));
		$link = $array_url[$rand_url_file];
		// echo "$link<br />";
		

		// берем случайное слово и его позицию в тексте
		$r = rand(0, count($matches)-1);
		$word = $matches[$r][0];
		$position = $matches[$r][1];
		// разбиваем на куски: до слова, само слово и кусок после слова
		$before_word = substr($content, 0, $position);
		$after_word = substr($content, $position + strlen($word));
		// $word = "<a href=".$site.">".$matches[$r][0]."</a>";
		// $link = rand ($startfile,$endfile);
		$word = "<a href=".'~/'."$link>".$matches[$r][0]."</a>";
		// а потом склеиваем обратно
		$content = $before_word.$word.$after_word;
		}
		
	// расставляем тэги <!--more-->
	// определяем позицию вставки тэга
	$rndpos = rand (200,350);
	// ищем ближайший пробел
	$pos = strpos($content, " ", $rndpos);
	// вставляем собственно тэг
	$content = substr_replace ($content, " <!--more--> ", $pos, $pos+12);		
	
	// приводим контент в кодировку UTF-8
	$content = iconv("windows-1251", "UTF-8//IGNORE", $content);
	
	//проверка, если появилась новая фирма - НИЧЕГО ПИСАТЬ НЕ НАДО ????
	if($firmidprev != $firmid)
		{
		// echo "<strong>##".$firm."</strong><br />";
		// echo "<br />";
		}
	
	// проверка, если появилась новая модель - пишем УВ2 (где расположены уже ссылки на все отзывы по этой модели) и УВ3 - иначе пропустим первый отзыв
	if($modelidprev != $modelid)
		{
		uv2($pages, $content, $firm, $model, $title, $firmid, $modelid, $name, $year, $startfile);
		uv3($pages, $content, $firm, $model, $title, $firmid, $modelid, $name, $year, $startfile, $h1);
		}
		
	// проверка, если марка и модель - одинаковые, пишем УВ3 (где, собственно, и содержится текст отзыва)
	if(($firmidprev == $firmid)&&($modelidprev == $modelid))
		{
		uv3($pages, $content, $firm, $model, $title, $firmid, $modelid, $name, $year, $startfile, $h1);
		}

	// инкрементируем значения счетчиков
	$startfile++;
	
	// записываем текущие значения firmid и modelid (для выяснения необходимости формирования списка на главной)
	$firmidprev = $firmid;
    $modelidprev = $modelid;
    }
	
////////////////////////////////////////////////////////// закрываем проход таблицы #2 и обработку контента
mysql_close($db);

// закрываем файл для записи
fclose($pages);
echo "<br />конечное значение startfile=$endfile<br />";

//считаем время работы
$mtime=explode(" ",microtime());
$tend=$mtime[1]+$mtime[0];
$totaltime=round(($tend-$tstart),2);
echo "<br />Время работы скрипта: ".$totaltime." сек.";
?>