<?
class MyDB
{
        private $db = null;
        private $result = null; 
 
/*Конструктору передаем адрес, имя пользователя, пароль, имя базы данных, порт, а также кодировку для соединения.
По умолчанию используется utf8*/ 
 
        public function __construct($host, $user, $password, $base, $port = null, $charset = 'utf8')
        {
                $this->db = new mysqli($host, $user, $password, $base, $port);
                $this->db->set_charset($charset);
        } 
 
/*основная и единственная функция, которая выполняет запрос и возвращает результат его работы*/ 
 
        public function query($query)
        {
                if(!$this->db)
                        return false; 
 
/*очищаем предыдущий результат*/ 
 
                if(is_object($this->result))
                        $this->result->free(); 
 
/*выполняем запрос*/ 
 
                $this->result = $this->db->query($query); 
 
/*если есть ошибки - выводим их*/ 
 
                if($this->db->errno)// header('Location: /404');
                        die("mysqli error #".$this->db->errno.": ".$this->db->error); 
 
/*если в результате выполнения запроса (например SELECT...) получены данные - возвращаем их.
ВНИМАНИЕ! данные всегда возвращаются в массиве, даже если запрос возвращает одну запись.*/ 
 
                if(is_object($this->result))
                {
                        while($row = $this->result->fetch_assoc())
                                $data[] = $row;
                        
                        return $data;
                } 
 
/*если результат отрицательный - возвращаем false*/ 
 
                else if($this->result == FALSE)
                        return false;
                        
/*если запрос (например UPDATE или INSERT) затронул какие-либо строки - возвращаем их количество*/ 
 
                else return $this->db->affected_rows;
        }
/*возвращает последний ID сгенерированный autoincrement*/  
        public function lastId()
        {
            return $this->db->insert_id;
        }
        
        
/*Получить первое значение*/         
        public function getVal($query) 
        {
            $res = $this -> query($query);
            if ($res)
            {
                $row = array_shift(array_values($res));
                return array_shift(array_values($row));
            }
        }

/*Тоже самое что и getVal($query) затупил с админкой*/         
        public function getValue($query) 
        {
            $res = $this -> query($query);
            if ($res)
            {
                $row = array_shift(array_values($res));
                return array_shift(array_values($row));
            }
        }
        
 /*Получить строку*/         
        public function getRow($query) 
        {
            $res = $this -> query($query);
            if ($res)
            return array_shift(array_values($res));
        }
}
?>