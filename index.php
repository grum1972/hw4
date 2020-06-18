<?php
// Реализация ПАТТЕРНА ДЕКОРАТОР

// Интерфейс
interface iTariff
{
    public function getTime();

    public function getPrice();

    public function getDescription();
}

// Абстрактный класс услуги
abstract class Service implements iTariff
{
    protected $tariff;
    protected $time;

    public function __construct(iTariff $tariff)
    {
        $this->tariff = $tariff;
    }

    public function getTime()
    {
        return $this->tariff->getTime();
    }
}

//Абстрактный класс Тарифа
abstract class Tariff implements iTariff
{
    protected $distance;
    protected $time;
    protected $pricePerKm = 0;
    protected $pricePerMin = 0;

    public function __construct(int $distance, int $time)
    {
        $this->time = $time;
        $this->distance = $distance;
    }

    public function getPrice()
    {
        return $this->distance * $this->pricePerKm + $this->time * $this->pricePerMin;
    }

    public function getTime()
    {
        return $this->time;
    }


}

class BasicTariff extends Tariff
{
    protected $pricePerKm = 10;
    protected $pricePerMin = 3;

    public function getDescription()
    {
        return 'Базовый';
    }
}

class StudentTariff extends Tariff
{
    protected $pricePerKm = 4;
    protected $pricePerMin = 1;

    public function getDescription()
    {
        return 'Студенческий';
    }
}

class HourTariff extends Tariff
{
    protected $pricePerHour = 200;

    function getHour()
    {
        return ($this->time <= 60) ? 1 : ceil($this->time / 60);
    }

    public function getPrice()
    {
        return $this->getHour() * $this->pricePerHour;
    }

    public function getDescription()
    {
        return 'Почасовой';
    }
}

class ServiceOptDrive extends Service
{
    public function getPrice()
    {
        return $this->tariff->getPrice() + 100;
    }

    public function getDescription()
    {
        return ' + дополнительный водитель';
    }
}

class ServiceGPS extends Service
{

    function getHour()
    {
        $this->time = $this->tariff->getTime();
        return ($this->time <= 60) ? 1 : ceil($this->time / 60);
    }

    public function getPrice()
    {
        return $this->tariff->getPrice() + $this->getHour() * 15;
    }

    public function getDescription()
    {
        return ' + GPS';
    }
}

echo 'Поездка по тарифу ';
// Добавляем базовый тариф
$trip = new BasicTariff(5, 90);
echo $trip->getDescription();

// Добавляем дополнительного водителя
$trip = new ServiceOptDrive($trip);
echo $trip->getDescription();

// Добавляем GPS
$trip = new ServiceGPS($trip);
echo $trip->getDescription();

echo " будет стоить {$trip->getPrice()} рублей";

echo '<br>';
echo '<br>';
echo 'Поездка по тарифу ';

// Добавляем почасовой тариф
$trip = new HourTariff(5, 90);

echo $trip->getDescription();
echo " будет стоить {$trip->getPrice()} рублей";

echo '<br>';
echo '<br>';
echo 'Поездка по тарифу ';

// Добавляем студенческий тариф
$trip = new StudentTariff(10, 50);
echo $trip->getDescription();

// Добавляем GPS
$trip = new ServiceGPS($trip);
echo $trip->getDescription();

echo " будет стоить {$trip->getPrice()} рублей";