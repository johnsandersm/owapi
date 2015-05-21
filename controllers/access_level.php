<?php

class OWAPI_CTRL_AccessLevel extends OWAPI_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "access_level_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "access_level_page_heading"));


    }
}