<?php

function mymy_log($string) {
    $file = OW_DIR_ROOT . 'ow_logs/ow-api-use.log';
    // Open the file to get existing content
    //$current = file_get_contents($file);
    // Append a new person to the file
    //$current .= $string."\n";
    // Write the contents back to the file
    //file_put_contents($file, $current);

    $line  = date('Y-m-d H:i:s') . " - $_SERVER[REMOTE_ADDR]: ";
    $line .= $string;
    file_put_contents($file, $line . PHP_EOL, FILE_APPEND);
}

class OWAPI_CLASS_EventHandler
{
    public function onCollectAccessExceptions( BASE_CLASS_EventCollector $e ) {
        mymy_log("OWAPI_CLASS_EventHandler->onCollectAccessExceptions");
        $e->add(array('controller' => 'OWAPI_CTRL_Oxwallapi', 'action' => 'auth'));
    }

    public function init()
    {
        mymy_log("OWAPI_CLASS_EventHandler->init");
        OW::getEventManager()->bind('base.members_only_exceptions', array($this, "onCollectAccessExceptions"));
        OW::getEventManager()->bind('base.password_protected_exceptions', array($this, "onCollectAccessExceptions"));
        OW::getEventManager()->bind('base.splash_screen_exceptions', array($this, "onCollectAccessExceptions"));
    }
}
