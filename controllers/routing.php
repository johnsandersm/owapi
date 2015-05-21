<?php

class OWAPI_CTRL_Routing extends OWAPI_CLASS_ActionController
{
    public function index($params)
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "routing_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "routing_page_heading"));

    }

}