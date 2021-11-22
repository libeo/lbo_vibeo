<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Register the plugins

// List
$pluginSignature = 'vibeo_vibeomedialist';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Vibeo',
    'Vibeomedialist',
    'Vibeo media list'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:vibeo/Configuration/FlexForms/flexform_vibeomedialist.xml'
);
// END - List

// Single
$pluginSignature = 'vibeo_vibeosinglemedia';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Vibeo',
    'Vibeosinglemedia',
    'Vibeo single media'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:vibeo/Configuration/FlexForms/flexform_vibeosinglemedia.xml'
);

// END - Single

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_vibeo_domain_model_media',
    'EXT:vibeo/Resources/Private/Language/locallang_csh_tx_vibeo_domain_model_media.xml'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vibeo_domain_model_media');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vibeo_domain_model_transcription');
