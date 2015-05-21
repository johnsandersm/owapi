<?php

function my_log($string) {
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

//class OWAPI_CTRL_Oxwallapi extends OWAPI_CLASS_ActionController
class OWAPI_CTRL_Oxwallapi extends OW_ActionController
{

    public function auth()
    {
	print "hello";
	print $_GET['par1'];
	exit();
    }

    public function index()
    {
        $language = OW::getLanguage();
        $router = OW::getRouter();

    $ispost = OW::getRequest()->isPost();
    $rq_typ = OW::getRequest()->getRequestType();
    $rq_par = OW::getRequest()->getUriParams();
    $rq_uri = OW::getRequest()->getRequestUri();


    $raw_post = file_get_contents('php://input');
    $data = "";
    if($ispost)
    {
        $values = json_decode($raw_post, true);

        //print_r($values);
        $data = $values;

	$ar = $_POST;
	$ars = array_keys($ar);
        $d = '';
	foreach($ars as $ar) {
    	    $d .= '$' . nl2br($email);
        }

        // TBD - do somethong with data

    }

    // http://php.net/manual/ru/function.split.php
    //// Разделителями могут быть слеши, точки или дефисы
    //$date = "04/30/1973";
    //list($month, $day, $year) = split('[/.-]', $date);
    //echo "Месяц: $month; День: $day; Год: $year<br />\n";

    list($par0, $par1, $par2) = split('\/', $rq_uri);
    //$par0 - must be "oxwallapi"
    //$par1 = $_GET['par1'];
    //$par2 = $_GET['par2'];

    $type = $ispost ? "POST" : "GET";
    my_log($type.': '.$par1.'/'.$par2);
    //my_log(implode(", ", $_GET));
    my_log(implode(', ', array_map(function ($v, $k) { return $k . '=' . $v; }, $_GET, array_keys($_GET))));
    my_log($raw_post);

    // My
    // -----------
    // "oxwallapi/images/logo"
    // "oxwallapi/images/logo_example"
    //
    // oxWallAPI
    // -----------
    // "oxwallapi/user/checklogin"
    // "oxwallapi/user/beforesignin"
    //---------------------------------------------------------------------------
    // identity:   "a@a.h"
    // objectType: "email"
    // password:   "j"
    // remember:   "1"
    // "oxwallapi/user/signin"
    //---------------------------------------------------------------------------
    // "oxwallapi/notification/getnumbernotification"  [INFO] updateNotif
    // "oxwallapi/config/getversion"                   [INFO] oxwallversion:NaN
    // "oxwallapi/config/getsettings"
    // "oxwallapi/feed/feeds?type=site&page=1&show=10"

    if($par1 == "base")
    {
        $apiResponse = array (
            "type"    => 'yes',  // or 'no'
            "ispost"  => $ispost,
            "data"    => $data,
            "rq_typ"  => $rq_typ,
            "rq_uri"  => $rq_uri,
            "rq_par"  => $rq_par,
            "ver"     => OW::getConfig()->getValue('base', 'soft_version'),
            "build"   => OW::getConfig()->getValue('base', 'soft_build'),
            "par1"    => $_GET['par1'],
            "par2"    => $_GET['par2'],
            "status"  => 'ok',
            "content" => 'body-body',
        );
    } else if($par1 == 'images') {
        if($par2 == 'logo') {
            // header('Content-Disposition: Attachment;filename=image.png');
            header ( 'Content-Type: image/png' );
            $imagefile = "./ow_themes/origin/mobile/images/logo.png";
            $im = imagecreatefrompng($imagefile);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            imagepng($im);
        } else if($par2 == 'logo_example') {
            // header('Content-Disposition: Attachment;filename=image.png');
            header ( 'Content-Type: image/png' );
            $imagefile = "./ow_themes/origin/mobile/images/logo_example.png";
            $im = imagecreatefrompng($imagefile);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            imagepng($im);
        } else {
            header ( 'Content-Type: image/jpeg' );
            $imagefile = "./ow_themes/origin/images/bg.jpg";
            $im = imagecreatefromjpeg($imagefile);
            imagejpeg($im);
        }
        imagedestroy($im);
        exit ();
    } else if($par1 == 'notification') {
      if($par2 == 'getnumbernotification') {
        $apiNoReq = array (
            "New"  => '1',
        );
        $apiMlReq = array (
            "New"  => '0',
        );
        $apiFrReq = array (
            "New"  => '0',
        );
        $apiContent = array (
            "FriendsRequest"  => $apiFrReq,
            "Mailbox"         => $apiMlReq,
            "Notification"    => $apiNoReq,
        );
        $apiResponse = array (
            "rq_uri"  => $rq_uri,
            "status"  => 'ok',
            "content" => $apiContent,
        );
            ;
      }
    } else if($par1 == 'user') {
      if($par2 == 'signin') {
        $apiContent = array (
            "email"         => 'a@a.com',
            "username"      => 'pseudo-admin',
            "joinStamp"     => '14.14.2014',
            "activityStamp" => '14.14.2014',
            "accountType"   => 'polu-admin',
            "emailVerify"   => 'yes',
            "joinIp"        => '192.168.0.0',
            "id"            => '19191919191',
            "avatar"        => 'a.png',
            "displayName"   => 'Hackerok',
        );
        $apiResponse = array (
            "rq_uri"  => $rq_uri,
            "status"  => 'ok',
            "content" => $apiContent,
        );
      } else {
        $apiResponse = array (
            "type"    => 'yes',  // or 'no'
            "ispost"  => $ispost,
            "data"    => $data,
            "rq_uri"  => $rq_uri,
            "status"  => 'ok',
            "content" => 'body-body',
        );
      }
    } else {
        $apiResponse = array (
            "type"    => 'no',  // or 'yes'
            "rq_uri"  => $rq_uri,
            "status"  => 'ok',
            "content" => 'body-body',
        );
    }

    // prepare result and format
    header ( 'Content-Type: application/json' );

    echo json_encode ( $apiResponse );

    exit ();


        //====================================================================================

        OW::getDocument()->setTitle($language->text("owapi", "index_page_title"));
        OW::getDocument()->setDescription($language->text("owapi", "index_page_description"));
        OW::getDocument()->setHeading($language->text("owapi", "index_page_heading"));
        
        $skeletonMenu = array();

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_file_structure"),
            "url" => $router->urlFor("OWAPI_CTRL_Example", "fileStructure")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_devtools"),
            "url" => $router->urlFor("OWAPI_CTRL_Example", "devtools")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_pluginxml"),
            "url" => $router->urlFor("OWAPI_CTRL_Example", "pluginxml")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_routing"),
            "url" => $router->urlForRoute("skeleton-routing")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_localization"),
            "url" => $router->urlForRoute("skeleton-localization")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_forms"),
            "url" => $router->urlForRoute("skeleton-forms")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_database"),
            "url" => $router->urlForRoute("skeleton-database")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_file_storage"),
            "url" => $router->urlForRoute("skeleton-file-storage")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_mail_sending"),
            "url" => $router->urlForRoute("skeleton-mail-sending")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_notifications"),
            "url" => $router->urlForRoute("skeleton-notifications")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_newsfeed"),
            "url" => $router->urlForRoute("skeleton-newsfeed")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_floatbox"),
            "url" => $router->urlForRoute("skeleton-floatbox")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_widgets"),
            "url" => $router->urlForRoute("skeleton-widgets")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_access_level"),
            "url" => $router->urlForRoute("skeleton-access_level")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_profile_questions"),
            "url" => $router->urlForRoute("skeleton-profile_questions")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_cron"),
            "url" => $router->urlForRoute("skeleton-cron")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_ping"),
            "url" => $router->urlForRoute("skeleton-ping")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("owapi", "menu_item_install"),
            "url" =>  $router->urlFor("OWAPI_CTRL_Example", "install")
        );

        $this->assign("menu", $skeletonMenu);
    }

    public function devtools()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "devtools_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "devtools_page_heading"));

        $this->assign('devtoolsUrl', OW_URL_HOME.'admin/dev-tools/languages');
    }

    public function pluginxml()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "pluginxml_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "pluginxml_page_heading"));
    }

    public function fileStructure()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "file_structure_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "file_structure_page_heading"));

        $this->assign('pluginxmlUrl', OW::getRouter()->urlFor("OWAPI_CTRL_Example", "pluginxml"));
        $this->assign('cronUrl', OW::getRouter()->urlFor("OWAPI_CTRL_Example", "cron"));
    }

    public function cron()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "cron_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "cron_page_heading"));

    }

    public function install()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("owapi", "install_page_title"));
        OW::getDocument()->setHeading($language->text("owapi", "install_page_heading"));

    }

}

// from other project
/*

<?php

define('_OW_', true);

define('DS', DIRECTORY_SEPARATOR);

define('OW_DIR_ROOT', dirname(__FILE__) . DS);

require_once(OW_DIR_ROOT . 'ow_includes' . DS . 'init.php');

//if ( !defined('OW_ERROR_LOG_ENABLE') || (bool) OW_ERROR_LOG_ENABLE )
//{
//    $logFilePath = OW_DIR_LOG . 'error.log';
//    $logger = OW::getLogger('ow_core_log');
//    $logger->setLogWriter(new BASE_CLASS_FileLogWriter($logFilePath));
//    $errorManager->setLogger($logger);
//}

//public function index() {
//
	//print "hello";
	//print $_GET['par1'];
	//exit();
//}

*/
