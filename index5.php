<?php

// Реализация ПАТТЕРНА КОМПОНОВЩИКА

// Интерфейс
interface iTariff
{
    public function __construct(int $distance, int $time);

    public function getPrice();

}

abstract class Tariff implements iTariff
{
    protected $distance;
    protected $time;
    protected $pricePerKm;
    protected $pricePerMin;


    public function getPrice()
    {
        return $this->distance * $this->pricePerKm + $this->time * $this->pricePerMin;
    }
}
// Базовый тариф
class BasicTariff extends Tariff
{
    protected $distance;
    protected $time;
    protected $pricePerKm = 10;
    protected $pricePerMin = 3;

    public function __construct(int $distance, int $time)
    {
        $this->distance = $distance;
        $this->time = $time;
    }

    public function getPrice()
    {
        return parent::getPrice();
    }
}
// Студенческий тариф
class StudentTariff extends Tariff
{
    protected $distance;
    protected $time;
    protected $pricePerKm = 4;
    protected $pricePerMin = 1;

    public function __construct(int $distance, int $time)
    {
        $this->distance = $distance;
        $this->time = $time;
    }

    public function getPrice()
    {
        return parent::getPrice();
    }
}
//Почасовой тариф
class HourTariff extends Tariff
{
    protected $distance;
    protected $time;
    protected $pricePerKm = 0;
    protected $pricePerHour = 200;

    public function __construct(int $distance, int $time)
    {
        $this->distance = $distance;
        $this->time = $time;
    }

    public function getPrice()
    {
        return $this->pricePerHour * getTime($this->time);
    }
}

class GPSTariff extends Tariff
{
    protected $time;
    protected $pricePerHour = 15;

    public function __construct(int $distance, int $time)
    {
        $this->time = $time;
    }

    public function getPrice()
    {
        return $this->pricePerHour * getTime($this->time);
    }
}

// Услуга дополнительный водитель
class OptDriver extends Tariff
{

    public function __construct(int $distance, int $time)
    {
    }

    public function getPrice()
    {
        return 100;
    }
}

//Поездка
class Trip
{
    protected $tariffs;

    public function addTariff(iTariff $tariff)
    {
        $this->tariffs[] = $tariff;
    }

    public function getPriceTrip()
    {
        $netCost = 0;
        foreach ($this->tariffs as $tariff) {
            $netCost += $tariff->getPrice();
        }
        return $netCost;
    }
}

// Функция получения целых часов
function getTime($time)
{
    return ($time <= 60) ? 1 : ceil($time / 60);
}

$trip = new Trip(); // Новая поездка
$trip->addTariff(new BasicTariff(5, 60)); //Добавляем базовый тариф
//$trip->addTariff(new StudentTariff(20, 20));
//$trip->addTariff(new HourTariff(0, 90));
$trip->addTariff(new GPSTariff(0, 60)); //Добавляем услуг GPS
//$trip->addTariff(new OptDriver(0,0)); // Добавляем услугу Доп водитель
echo "Стоимость поездки составит : {$trip->getPriceTrip()} рублей";