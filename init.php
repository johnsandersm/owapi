<?php

/**
 * Defined routes for plugin Skeleton
 */

//OW::getRouter()->addRoute(new OW_Route('oxwallapi-auth-checklogin',   'oxwallapi/user/checklogin',   'OWAPI_CTRL_Oxwallapi', 'auth'));
//OW::getRouter()->addRoute(new OW_Route('oxwallapi-auth-beforesignin', 'oxwallapi/user/beforesignin', 'OWAPI_CTRL_Oxwallapi', 'auth'));
//OW::getRouter()->addRoute(new OW_Route('oxwallapi-auth-signin',       'oxwallapi/user/signin',       'OWAPI_CTRL_Oxwallapi', 'auth'));
//$eventHandler = new OWAPI_CLASS_EventHandler();
//$eventHandler->init();
OW::getRouter()->addRoute(new OW_Route('oxwallapi-auth-checklogin',   'oxwallapi/user/checklogin',   'OWAPI_CTRL_Oxwallapi', 'index'));
OW::getRouter()->addRoute(new OW_Route('oxwallapi-auth-beforesignin', 'oxwallapi/user/beforesignin', 'OWAPI_CTRL_Oxwallapi', 'index'));
OW::getRouter()->addRoute(new OW_Route('oxwallapi-auth-signin',       'oxwallapi/user/signin',       'OWAPI_CTRL_Oxwallapi', 'index'));

OW::getRouter()->addRoute(new OW_Route('oxwallapi-index', 'oxwallapi', 'OWAPI_CTRL_Oxwallapi', 'index'));
OW::getRouter()->addRoute(new OW_Route('oxwallapi-index-1', 'oxwallapi/:par1', 'OWAPI_CTRL_Oxwallapi', 'index'));
OW::getRouter()->addRoute(new OW_Route('oxwallapi-index-1-2', 'oxwallapi/:par1/:par2', 'OWAPI_CTRL_Oxwallapi', 'index'));

OW::getRouter()->addRoute(new OW_Route('owapi-index', 'owapi', 'OWAPI_CTRL_Example', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-localization', 'skeleton/localization', 'OWAPI_CTRL_Localization', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-localization-delete-key', 'skeleton/localization/delete/:key', 'OWAPI_CTRL_Localization', 'deleteKey'));

OW::getRouter()->addRoute(new OW_Route('skeleton-routing', 'skeleton/routing', 'OWAPI_CTRL_Routing', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-forms', 'skeleton/forms', 'OWAPI_CTRL_Forms', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-database', 'skeleton/database', 'OWAPI_CTRL_Database', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-database-delete-item', 'skeleton/database/delete/:id', 'OWAPI_CTRL_Database', 'deleteItem'));

OW::getRouter()->addRoute(new OW_Route('skeleton-file-storage', 'skeleton/file-storage/', 'OWAPI_CTRL_FileStorage', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-file-storage-preview', 'skeleton/file-storage/preview', 'OWAPI_CTRL_FileStorage', 'preview'));

OW::getRouter()->addRoute(new OW_Route('skeleton-mail-sending', 'skeleton/mail-sending', 'OWAPI_CTRL_MailSending', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-notifications', 'skeleton/notifications', 'OWAPI_CTRL_Notifications', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-newsfeed', 'skeleton/newsfeed', 'OWAPI_CTRL_Newsfeed', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-floatbox', 'skeleton/floatbox', 'OWAPI_CTRL_Floatbox', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-widgets', 'skeleton/widgets', 'OWAPI_CTRL_Widgets', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-widgets-delete', 'skeleton/widgets/delete/:id', 'OWAPI_CTRL_Widgets', 'delete'));

OW::getRouter()->addRoute(new OW_Route('skeleton-profile_questions', 'skeleton/profile_questions', 'OWAPI_CTRL_ProfileQuestions', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-access_level', 'skeleton/access_level', 'OWAPI_CTRL_AccessLevel', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-cron', 'skeleton/cron', 'OWAPI_CTRL_Example', 'cron'));

OW::getRouter()->addRoute(new OW_Route('skeleton-ping', 'skeleton/ping', 'OWAPI_CTRL_Ping', 'index'));



/**
 * Adding example section to notifications settings page
 *
 * @param BASE_CLASS_EventCollector $e
 */
function skeleton_on_notify_actions( BASE_CLASS_EventCollector $e )
{
    $sectionLabel = OW::getLanguage()->text('owapi', 'notification_section_label');

    $e->add(array(
        'section' => 'owapi',
        'action' => 'example',
        'description' => OW::getLanguage()->text('owapi', 'email_notifications_setting_example'),
        'selected' => true,
        'sectionLabel' => $sectionLabel,
        'sectionIcon' => 'ow_ic_clock'
    ));

}
OW::getEventManager()->bind('notifications.collect_actions', 'skeleton_on_notify_actions');

/**
 * Binding on event that collects entities to be sent by email.
 * Uncomment the function below to start receive notifications from skeleton plugin.
 *
 * This event depends on profiles' email notification settings
 * @param BASE_CLASS_EventCollector $event
 */
//function skeleton_console_send_list( BASE_CLASS_EventCollector $event )
//{
//    $params = $event->getParams();
//    $userIdList = $params['userIdList'];
//
//    foreach ( $userIdList as $id => $userId )
//    {
//        $avatars = BOL_AvatarService::getInstance()->getDataForUserAvatars(array( $userId ) );
//        $avatar = $avatars[$userId];
//
//        $event->add(array(
//            'pluginKey' => 'owapi',
//            'entityType' => 'skeleton-example',
//            'entityId' => $userId,
//            'userId' => $userId,
//            'action' => 'example',
//            'time' => time(),
//
//            'data' => array(
//                'avatar' => $avatar,
//                'string' => OW::getLanguage()->text('owapi', 'notify_example', array(
//                    'content' => 'qwerty')
//                )
//            )
//        ));
//    }
//}
//OW::getEventManager()->bind('notifications.send_list', 'skeleton_console_send_list');

/**
 * Binding on event that receives params from client and responds to it
 *
 * @param OW_Event $event
 */
function skeleton_ping( OW_Event $event )
{
    $eventParams = $event->getParams();
    $params = $eventParams['params'];

    if ($eventParams['command'] != 'skeleton_ping')
    {
        return;
    }

    $response = array();

    $counterOldValue = (int)$params['counterOldValue'];

    $response['counterNewValue'] = ++$counterOldValue;

    $event->setData($response);
}
OW::getEventManager()->bind('base.ping', 'skeleton_ping');

