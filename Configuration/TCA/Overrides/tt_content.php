<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

// Register the plugins

// List
$pluginSignature = 'lbovibeo_vibeomedialist';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'LboVibeo',
    'Vibeomedialist',
    'Vibeo media list'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:lbo_vibeo/Configuration/FlexForms/flexform_vibeomedialist.xml'
);
// END - List

// Single
$pluginSignature = 'lbovibeo_vibeosinglemedia';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'LboVibeo',
    'Vibeosinglemedia',
    'Vibeo single media'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:lbo_vibeo/Configuration/FlexForms/flexform_vibeosinglemedia.xml'
);

// END - Single
