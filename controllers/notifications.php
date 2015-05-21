<?php

class OWAPI_CTRL_Notifications extends OWAPI_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();
        
        OW::getDocument()->setTitle($language->text("owapi", "notifications_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "notifications_page_heading"));

        $notificationExampleForm = new OWAPI_CLASS_NotificationExampleForm();

        $this->addForm($notificationExampleForm);

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $notificationExampleForm->isValid($_POST) )
        {
            $notificationExampleForm->process();
        }
    }

}