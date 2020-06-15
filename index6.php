<?php
// Реализация ПАТТЕРНА ДЕКОРАТОР

// Интерфейс
interface iTariff
{

    public function getTime();

    public function getPrice();

    public function getDescription();

}

class BasicTariff implements iTariff
{
    protected $distance;
    protected $time;
    protected $pricePerKm = 10;
    protected $pricePerMin = 3;

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

    public function getDescription()
    {
        return 'Базовый';
    }
}

class TariffOptDrive implements iTariff
{

    protected $tariff;

    public function __construct(iTariff $tariff)
    {
        $this->tariff = $tariff;
    }

    public function getTime()
    {
        return $this->tariff->getTime();
    }

    public function getPrice()
    {
        return $this->tariff->getPrice() + 100;
    }

    public function getDescription()
    {
        return ' + дополнительный водитель';
    }
}

class TariffGPS implements iTariff
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
$trip = new BasicTariff(5, 60);
echo $trip->getDescription();

// Добавляем дополнительного водителя
$trip = new TariffOptDrive($trip);
echo $trip->getDescription();

// Добавляем GPS
$trip = new TariffGps($trip);
echo $trip->getDescription();

echo " будет стоить {$trip->getPrice()} рублей";

