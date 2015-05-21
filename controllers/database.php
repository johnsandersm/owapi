<?php

class OWAPI_CTRL_Database extends OWAPI_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();
        
        OW::getDocument()->setTitle($language->text("owapi", "database_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "database_page_heading"));
        
        $form = new Form("database_form");
        
        //Simple text field
        $textField = new TextField("text");
        $textField->setLabel($language->text("owapi", "forms_text_field_label"));
        $textField->setDescription($language->text("owapi", "forms_text_field_description"));
        $textField->setHasInvitation(true);
        
        $textField->setRequired();
        
        $form->addElement($textField);
        
        //Extended text field
        $textareaField = new Textarea("extended_text");
        $textareaField->setLabel($language->text("owapi", "forms_textarea_field_label"));
        $textareaField->setDescription($language->text("owapi", "forms_textarea_field_description"));
        
        $textareaValidator = new StringValidator(1, 200);
        $textareaField->addValidator($textareaValidator);
        
        $form->addElement($textareaField);
        
        //Selectbox field
        $selectField = new Selectbox("selectbox");
        $selectField->setLabel($language->text("owapi", "forms_selectbox_field_label"));
        $selectField->setDescription($language->text("owapi", "forms_selectbox_field_description"));
        
        $selectField->setOptions(array(
            "1" => "Option 1",
            "2" => "Option 2",
            "3" => "Option 3",
            "4" => "Option 4"
        ));
        
        $form->addElement($selectField);
        
        //Submit field
        $submit = new Submit("submit");
        $submit->setLabel($language->text("owapi", "forms_submit_field_label"));
        
        $form->addElement($submit);
        
        $service = OWAPI_BOL_Service::getInstance();
        
        if ( OW::getRequest()->isPost() && $form->isValid($_POST) )
        {
            $values = $form->getValues();
            $service->addRecord($values["text"], $values["extended_text"], $values["selectbox"]);
            
            OW::getFeedback()->info(OW::getLanguage()->text("owapi", "database_record_saved_info"));
            
            $this->redirect();
        }
        
        $this->addForm($form);
        
        $list = $service->findList();
        $tplList = array();
        foreach ( $list as $listItem )
        {
            /* @var $listItem OWAPI_BOL_Record */
            $tplList[] = array(
                "text" => $listItem->text,
                "extendedText" => $listItem->extendedText,
                "choice" => $listItem->choice,
                "deleteUrl" => OW::getRouter()->urlForRoute('skeleton-database-delete-item', array('id'=>$listItem->getId()))
            );
        }
        
        $this->assign("list", $tplList);
    }

    public function deleteItem($params)
    {
        $this->service->deleteDatabaseRecord($params['id']);

        OW::getFeedback()->info(OW::getLanguage()->text('owapi', 'database_record_deleted'));

        $this->redirect( OW::getRouter()->urlForRoute('skeleton-database') );
    }

}