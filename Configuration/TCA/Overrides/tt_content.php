<?php
if (!defined('TYPO3_MODE')) {
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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:lbo_vibeo/Configuration/FlexForms/flexform_vibeosinglemedia.xml'
);

// END - Single

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_vibeo_domain_model_media',
    'EXT:lbo_vibeo/Resources/Private/Language/locallang_csh_tx_vibeo_domain_model_media.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vibeo_domain_model_media');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vibeo_domain_model_transcription');
