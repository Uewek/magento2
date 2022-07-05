<?php
use Magento\Framework\App\Bootstrap;
use Test\GeoWeather\Cron\ReciveWeatherData;
use Test\GeoWeather\Model\RequestService;
require __DIR__ . '/app/bootstrap.php';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);

$obj = $bootstrap->getObjectManager();

$state = $obj->get(Magento\Framework\App\State::class);
$state->setAreaCode('crontab');

$sortPoll = $obj->get(ReciveWeatherData::class);
$sortPoll->execute();
//$a = $sortPoll->getWeatherData();
$b =0;
