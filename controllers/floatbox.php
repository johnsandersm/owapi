<?php

class OWAPI_CTRL_Floatbox extends OWAPI_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "floatbox_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "floatbox_page_heading"));


        $script = "$('#skeleton_ajax_floatbox').click(function(){
            skeletonAjaxFloatBox = OW.ajaxFloatBox('OWAPI_CMP_Floatbox', {reload: false} , {width:380, iconClass: 'ow_ic_add', title: '".OW::getLanguage()->text('owapi', 'floatbox_title')."'});
});


$('#skeleton_floatbox').click(function(){

            window.skeletonFloatBox = new OW_FloatBox({\$title:'".OW::getLanguage()->text('owapi', 'floatbox_title')."', \$contents: $('#floatbox_content'), width: '550px'});
});
";
        OW::getDocument()->addOnloadScript($script);

    }
}