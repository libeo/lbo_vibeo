<?php

defined('TYPO3') || die('Access denied.');

call_user_func(
    function () {
        $icons = [
            'vibeo-plugin-icon' => 'vibeo.svg',
        ];
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($icons as $identifier => $path) {
            if (!$iconRegistry->isRegistered($identifier)) {
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                    ['source' => 'EXT:lbo_vibeo/Resources/Public/Icons/' . $path]
                );
            }
        }

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'LboVibeo',
            'Vibeomedialist',
            [
                \Libeo\Vibeo\Controller\MediaController::class => 'list',
            ],
            // non-cacheable actions
            [
                \Libeo\Vibeo\Controller\MediaController::class => '',
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'LboVibeo',
            'Vibeosinglemedia',
            [
                \Libeo\Vibeo\Controller\MediaController::class => 'single',
                \Libeo\Vibeo\Controller\TranscriptController::class => 'show',
            ],
            // non-cacheable actions
            [
                \Libeo\Vibeo\Controller\MediaController::class => '',
                \Libeo\Vibeo\Controller\TranscriptController::class => '',
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
        );
    }
);
