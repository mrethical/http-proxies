<?php

namespace Mrethical\HttpProxies\WebDriver\Remote;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Mrethical\HttpProxies\Models\Proxy;

class ChromeDriver
{
    public static function create(Proxy $proxy = null, $capabilities = []): RemoteWebDriver
    {
        if (is_null($proxy)) {
            $proxy = Proxy::firstRandomActive();
        }
        $ip = $proxy->ip;
        $port = $proxy->port;

        $chromeOptions = new ChromeOptions();
        $chromeOptions->addArguments([
            '--start-maximized',
            '--disable-gpu',
            "--proxy-server=${ip}:${port}",
        ]);
        $chromeOptions->setExperimentalOption('useAutomationExtension', false);
        $chromeOptions->setExperimentalOption('excludeSwitches', ['enable-automation']);

        $desiredCapabilities = DesiredCapabilities::chrome();
        $desiredCapabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);
        foreach ($capabilities as $key => $capability) {
            $desiredCapabilities->setCapability($key, $capability);
        }

        $driver = RemoteWebDriver::create(
            config('http-proxies.selenium.url'),
            $desiredCapabilities,
            transform(config('http-proxies.selenium.timeouts.connection'), fn ($timeout) => $timeout * 1000),
            transform(config('http-proxies.selenium.timeouts.request'), fn ($timeout) => $timeout * 1000),
        );
        $driver->manage()->deleteAllCookies();
        $driver->manage()->timeouts()
            ->pageLoadTimeout(config('http-proxies.selenium.timeouts.pageload'))
            ->setScriptTimeout(config('http-proxies.selenium.timeouts.script'));

        return $driver;
    }
}
