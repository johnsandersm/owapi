<?php

$path = OW::getPluginManager()->getPlugin('owapi')->getRootDir() . 'langs.zip';
BOL_LanguageService::getInstance()->importPrefixFromZip($path, 'owapi');


$query = "CREATE TABLE IF NOT EXISTS `" . OW_DB_PREFIX . "skeleton_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `extendedText` text NOT NULL,
  `choice` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

OW::getDbo()->query($query);
