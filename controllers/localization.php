<?php

class OWAPI_CTRL_Localization extends OWAPI_CLASS_ActionController
{
    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "localization_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "localization_page_heading"));

        $localizationExampleForm = new Form('LocalizationExampleForm');

        $key = new TextField('key');
        $key->setLabel($language->text("owapi", "enter_text_key"));
        $key->setHasInvitation(true);
        $key->setInvitation('hello_world');
        $key->setRequired();

        $localizationExampleForm->addElement($key);

        $value = new TextField('value');
        $value->setLabel($language->text("owapi", "enter_original_value"));
        $value->setHasInvitation(true);
        $value->setInvitation('Welcome to my site');
        $value->setRequired();

        $localizationExampleForm->addElement($value);

        $createButton = new Submit('create');
        $createButton->setValue($language->text("owapi", "create"));

        $localizationExampleForm->addElement($createButton);

        //Assigning form to the controller action
        $this->addForm($localizationExampleForm);

        //Getting keys and values for prefix "owapi"
        $languageService = BOL_LanguageService::getInstance();

        $keys = $languageService->findLastKeyList(0, 10, 'owapi');

        foreach($keys as $id => $key)
        {
            $keys[$id]['deleteUrl'] = OW::getRouter()->urlForRoute('skeleton-localization-delete-key', array('key'=>$key['key']));
        }

        $this->assign('keys', $keys);

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $localizationExampleForm->isValid($_POST) )
        {
            $data = $localizationExampleForm->getValues();

            $key = str_replace(' ', '_', $data['key']);
            $key = strtolower($key);


            $keyDto = $languageService->findKey('owapi', $key);
            if ( !empty($keyDto) )
            {
                OW::getFeedback()->warning($language->text("admin", "msg_dublicate_key"));
            }
            else
            {
                $currentLanguageId = $languageService->getCurrent()->getId();
                $languageService->addValue($currentLanguageId, 'owapi', $key, $data['value'], true);
                OW::getFeedback()->info($language->text("owapi", "msg_key_added"));
                $this->redirect();
            }
        }

    }

    public function deleteKey($params)
    {
        $languageService = BOL_LanguageService::getInstance();
        $keyDto = $languageService->findKey('owapi', $params['key']);

        if (!empty($keyDto))
        {
            $languageService->deleteKey($keyDto->getId());
            OW::getFeedback()->info(OW::getLanguage()->text("owapi", "msg_key_deleted"));
        }

        $this->redirect( OW::getRouter()->urlForRoute('skeleton-localization') );
    }

}