<?php 

namespace Tests\Browser\Pages;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;

class Common {

    public function full_page_screenshot($browser) 
    {
        $body = $browser->driver->findElement(WebDriverBy::tagName('body'));
        if (!empty($body)) {
            $currentSize = $body->getSize();
            $size = new WebDriverDimension($currentSize->getWidth(), $currentSize->getHeight());
            $browser->driver->manage()->window()->setSize($size);
        }

        return $browser;
    }
}

?>