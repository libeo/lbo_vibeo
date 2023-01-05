<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'vibeo',
    'Configuration/TypoScript',
    'Vibéo accessible HTML5 media player - Based on MediaElement.js'
);