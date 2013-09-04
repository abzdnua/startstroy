<?php
require_once 'class.invis.db.php';
//require_once 'class.date.php';
class DLL {
    
    private $_db;
    private $_dtClass;
    
    private $_ru = array(
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
        'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
        'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
        'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
        'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
    );
    private $_en = array(
        'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'ZH', 'Z', 'I', 'I',
        'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
        'H', 'C', 'CH', 'SH', 'SH', '\'', 'I', '\'', 'E', 'YU', 'YA',
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'i',
        'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'sh\'', '\'', 'i', '\'', 'e', 'yu', 'ya'
    );
    
    public function linkInBD($text,$id)
    { 
        return strtolower(preg_replace('/[^0-9-_\+a-zA-Z]/', '', str_replace($this -> _ru, $this -> _en, preg_replace('/ +/', '_', trim(preg_replace('/\(.+?\)/si', '', $text)))))).'_'.$id;

    }
    
    function __construct() {
        $this -> _db =  db :: getInstance();
//        $this -> _dtClass = new date();
    }
    
    public function getWordDays($products)
    { 
        $count = abs($products) % 100;
        $lcount = $products % 10;
        if ($count >= 11 && $count <= 19) return $count.' дней';
        if ($lcount >= 2 && $lcount <= 4) return $count.' дня';
        if ($lcount == 1) return $count.' день';
        return $count.' дней';


    }


    public function getRusDate($inDate)
    {
        list($date, $time) = explode(' ', $inDate);
        list($y,$m,$d) = explode('-', $date);
        if($m > 12 || $m < 1) return false;
        $aMonth = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        return $d.' '.$aMonth[$m - 1].' '.$y.' г.';
    }

    public function mb_ucfirst($str)
    { 
        return mb_strtoupper(mb_substr($str, 0, 1), 'UTF-8').mb_substr($str, 1);
    } 


    public function idGen()
    {
        $date = date('Y-m-d 00:00:00');
        $this -> _db -> query("SELECT `No` FROM `orders` WHERE `order_time` >= '{$date}' ORDER BY `order_time` DESC LIMIT 1");
        if ($this -> _db -> getCount())  
            $idGen = $this -> _db -> getValue() + 1;
        else $idGen = (int)date('ymd').'001';

        return $idGen;
    }


    public function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',    1),
        array('гривна'  ,'гривны'  ,'гривен'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= $this -> morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = $this -> morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.$this -> morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
public function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}

    public function clearVar($var)
    {
        if ($var)
            return trim(preg_replace("/insert|delete|update|eval/i","", strip_tags($var)));
        else 
            return false; 
    }

    public function randBColor()
    {
        $colors = array(
            'f6e8d7',
            'ffffcc',
            'f7f2da',
            'd9f4df',
            'd0ecf4',
            'd4eded',
            'f9e3b2',
            'ffead0',
            'c8eaf5',
            'e9e9ff',
            'e2edc1',
            'd7ede6',
            'dff3fd',
            'f9eede',
            'e1f9e6',
            'fffac0',
            'e2edc1',
            'aee0e8',
            'd8d6ec',
            'c5df94',
            'c7eafb',
            'bddbed',
            'eff8fb',
            'e5f4fa',
            'd8ecd1',
            'f7f0bb',
            'edf1c5',
            'ebe9ca',
            'ebe3b5',
            'e8f4d1',
            'ecf5e1',
            'e2f4dc',
            'd4e9d1',
            'e6f5e4',
            'd5f3e0',
            'd3ecdd',
            'cbe9df',
            'beebee',
            'b5e9ed',
            'afe9e8',
            'd9edf0',
            'bad7d3',
            'dae5f4',
            'ccddf2',
            'bed0e7',
            'c2e5ec',
            'b7deef',
            'b1ddf0',
            'cbd0e8',
            'd7dbf0',
            'ffe5ba',
            'ffe7ce',
            'f8ead6',
            'fcf5b5',
            'faf5bd',
            'fcf0ba',
            'c2e9f1',
            'c4f1e5',
            'fcf49a',
            'f6f795',
            'adf09a',
            'fff58f',
            'ffd5a1',
            'fff7a9',
            'f8f8ac');
        return 'style="background-color:#'.(string)$colors[rand(0,count($colors) - 1)].';"';
    }

    /*
    функция обезает текст
    */
    public function substrText($inputStr,$substrLen = 200)
    {
        $inputStrLen = mb_strlen($inputStr);
        if ($inputStrLen)
        {
            if ($substrLen < mb_strlen($inputStr))
            {
                $text = mb_substr($inputStr, 0, mb_strrpos(mb_substr($inputStr, 0, $substrLen), " "));
                $subText = mb_substr($inputStr, mb_strrpos(mb_substr($inputStr, 0, $substrLen), " "));
                $result['text'] = $text.'<span class="dotdotdot">&nbsp;...</span>';
                $result['length'] = mb_strlen($text);
                $result['isFull'] = false;
                $result['subText'] = ' '.$subText;
            }
            else
            {
                $result['text'] = $inputStr;
                $result['length'] = $inputStrLen;
                $result['isFull'] = true;
                $result['subText'] = '';
            }
            return $result;
        }
        else return false;
    }


    //функция возврашает дату в привычном формате
    public function dateFromDB($string)
    {
        list($date, $time) = explode(' ', $string);
        list($y,$m,$d) = explode('-', $date);
        return $d.'.'.$m.'.'.$y;
    }

    //функция возврашает дату в привычном формате
    public function dateToDB($string)
    {
        list($d,$m,$y) = explode('.', $string);
        return $y.'-'.$m.'-'.$d;
    }
    //функция возвращает 1 значение по $id из таблицы $table
    private function query($id, $whatField, $table)
    { 
        if ($id)
        {    
            $this -> _db -> query("SELECT `".$whatField."` FROM `".$table."` WHERE id = {$id}");
            if ($this -> _db -> getCount() > 0) 
                return $this -> _db -> getValue();
            else return false;
        }
    }
    
    //1 значение по $id из таблицы admin 
    public function getUser($id, $whatField = 'name')
    { 
        return $this -> query($id, $whatField, 'admin');
    }
    
    
    //Фунция создает список из таблицы $name, можно задать первое значение $firstValue и первый заголовок $firstName, и задать стили $style
    public function greateSelect($name, $firstName = null, $firstValue = 0, $style = '', $attr = '',$src=null)
    { 
        $this -> _db -> query("SELECT * FROM `".$name."`");
        if ($this -> _db -> getCount() > 0) 
        {
            $style = ($style == null) ? "" : "style='".$style."'";
            $values = $this -> _db -> getArray();
            $src=($src == null) ? "" : $src;
            $selectB = '<select id="'.$name.'" name="'.$name.'" '.$style.' '.$attr.'>';
            $options = '';
            if ($firstName) $optionF = '<option value="'.$firstValue.'">'.$firstName.'</option>';
            foreach ($values as $i => $value)
            {
                if ($firstValue == $value['id']) 
                    $optionF = '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                else 
                    $options .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
            }
            $selectE = '</select>';
            return $selectB.$optionF.$options.$selectE;
        }
    }


    public function getActualDate()
    {
        $this -> _db -> query("SELECT dateCreate FROM `products` ORDER BY dateCreate DESC LIMIT 1");
        if ($this -> _db -> getCount() > 0)
        {
            $actualDT = $this -> _db -> getValue();
            $this -> _db -> query("SELECT dateUpdate FROM `products` WHERE dateUpdate > '{$actualDT}' ORDER BY dateUpdate DESC LIMIT 1");
            if ($this -> _db -> getCount() > 0)
            {$actualDT = $this -> _db -> getValue();}
        }
        return date('d.m.Y',strtotime($actualDT));
    }

}

$DLL = new DLL();
?>
