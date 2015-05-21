<?php

class OWAPI_CTRL_Ping extends OWAPI_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "ping_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "ping_page_heading"));

        OW::getDocument()->addScript( OW::getPluginManager()->getPlugin('owapi')->getStaticJsUrl().'ping.js' );
    }
}