<?php

class timer
{
    private $start_time;      //Время запуска тип - datetime
    private $duration;        //Длительность - сек


    public function __construct(){
        $args = func_get_args();
        $this->start_time = $args[0];
        $this->duration   = $args[1];
    }

    //Перевести время в милисекунды, для удобнго сравнения
    public function translateToSeconds($datetime){
        $d = explode(' ', $datetime);
        $date = explode('-',$d[0]);
        $time = explode(':', $d[1]);
        $time_start = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
        return $time_start;
    }


    //Проверить, вышло ли время таймера
    //true - вышло; false - нет;
    public function isTimeout(){
        $time_start = $this->translateToSeconds($this->start_time);
        if(($this->duration + $time_start) < time())
        {
            return true;
        }
        else
        {
            if($time_start<time()){
                return false;
            }else{
                return true;
            }

        }
    }

    public function set_duration($duration){
        $this->duration = $duration;
    }

    public function set_start_time($start_time){
        $this->start_time = $start_time;
    }

    public function get_duration(){
        return $this->duration;
    }

    public function get_time_start_in_seconds(){
        $time_start = $this->translateToSeconds($this->start_time);
        return $time_start;
    }


    //Получить время оставшееся до истечения таймера
    public function GetTimeLeft(){
        $time_left = $this->getOutTimestamp() -  time();
        return $time_left;
    }


    public function get_start_time(){
        return $this->start_time;
    }

    public function getDurationInStrFormat(){
        $time = $this->duration;
        $days = (int)($time/86400);
        $hours = (int)(($time - $days*86400)/3600);
        $minutes = (int)(($time - $days*86400 - $hours*3600)/60);
        $format = array('days' => $days, 'hours'=>$hours, 'minutes' => $minutes);
        return $format;
    }


    //Возвращает отметку времени окончания таймера
    public function getOutTimestamp(){
        $time_start = $this->translateToSeconds($this->start_time);
        $time_out = $time_start + $this->duration;
        return $time_out;
    }

    //Проверить стартовал ли таймер?
    public function isStarted(){
        if(time()> $this->translateToSeconds($this->start_time)){
            return false;
        }else{
            return true;
        }
    }




}