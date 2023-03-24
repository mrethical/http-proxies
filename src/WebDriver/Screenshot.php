<?php

namespace Mrethical\HttpProxies\WebDriver;

use Facebook\WebDriver\Remote\RemoteWebDriver;

class Screenshot
{
    protected RemoteWebDriver $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function take($name)
    {
        $this->driver->takeScreenshot(storage_path('app/screenshots/'.date('Y-m-d-H-i-s')."_${name}.png"));
    }
}
