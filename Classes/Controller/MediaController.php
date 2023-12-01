<?php

namespace Libeo\Vibeo\Controller;

use Libeo\Vibeo\Domain\Model\Media;
use Libeo\Vibeo\Domain\Repository\MediaRepository;
use Libeo\Vibeo\Domain\Repository\TranscriptionRepository;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Philippe Moreau <philippe.moreau@qcmedia.ca>, Qc Média
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package vibeo
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

/**
 * MediaController
 */
class MediaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    static $headerIncluded = false;
    protected $extKey = 'lbo_vibeo';

    // If those file type exist in the same folder other "source" will be defined
    protected $fallbackExtensionArray = array('mp4', 'ogg', 'webm');

    /**
     * mediaRepository
     *
     * @var MediaRepository
     */
    protected $mediaRepository;

    /**
     * transcriptionRepository
     *
     * @var TranscriptionRepository
     */
    protected $transcriptionRepository;

    /**
     * injectMediaRepository
     *
     * @param MediaRepository $mediaRepository
     * @return void
     */
    public function injectMediaRepository(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * injectTranscriptionRepository
     *
     * @param TranscriptionRepository $transcriptionRepository
     * @return void
     */
    public function injectTranscriptionRepository(
        TranscriptionRepository $transcriptionRepository
    ) {
        $this->transcriptionRepository = $transcriptionRepository;
    }


    /**
     * Initializes the current action
     * This function is called automatically by the extbase framework
     *
     * @return void
     */
    public function initializeAction()
    {
        //Validation. Quick & dirty message but should never appear in production.
        if (!isset($this->settings['includes'])) {
            return 'Typoscript setup file not included for tx_vibeo. Please include it somewhere.';
        }

        // Width / height fix
        if ($this->settings['player']['videoWidth'] <= 0) {
            $this->settings['player']['videoWidth'] = $this->settings['player']['defaultVideoWidth'];
        }
        if ($this->settings['player']['videoHeight'] <= 0) {
            $this->settings['player']['videoHeight'] = $this->settings['player']['defaultVideoHeight'];
        }

        // Add headers as necessary
        $this->setHeaders();
    }


    /*
    * setHeaders
    * Set JS and CSS according to TS settings
    *
    * @return void
    */
    protected function setHeaders()
    {
        if (!self::$headerIncluded) {
            $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

            if ($this->settings['includes']['jquery']) {
                $pageRenderer->addJsFooterLibrary('jquery-1.7.2', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', null, false, true, '', true);
            }

            if ($this->settings['includes']['mediaelement']) {
                $pageRenderer->addJsFooterFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/Vibeo/mediaelement-and-player.min.js', null, false, false, '', true);
            }

            if ($this->settings['includes']['jquery-resize']) {
                $pageRenderer->addJsFooterFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/Vibeo/jquery.ba-resize.min.js', null, false, false, '', true);
            }

            if ($this->settings['includes']['modernizr']) {
                $pageRenderer->addJsFooterFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/Vibeo/modernizr-2.5.3.js', null, false, false, '', true);
            }

            if ($this->settings['includes']['css']) {
                $pageRenderer->addCssFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/CSS/tx-vibeo.css');
            }

            if ($this->settings['includes']['mediaelement-css']) {
                $pageRenderer->addCssFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/Vibeo/mediaelementplayer.css');
            }

            if ($this->settings['includes']['mediaelement-skin-css']) {
                $pageRenderer->addCssFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/Vibeo/skin-gray.css');
            }

            self::$headerIncluded = true;
        }
    }

    /**
     * Generate the configuration string for the JS player. {...}
     *
     * @return string
     */
    protected function getJSPlayerConfigurationString()
    {
        $options = array();
        $ignore = array(
            'defaultVideoWidth',
            'defaultVideoHeight',
            'videoWidth',
            'videoHeight',
            'audioWidth',
            'audioHeight'
        );

        foreach ($this->settings['player'] as $param => $value) {
            if ($param === "startVolume") {
                $value = number_format((trim($value) / 100), 1, '.', '');
            }

            $value = trim($value);

            if ($value === '' || in_array($param, $ignore)) {
                continue;
            }
            if (strpos($value, 'LLL:') === 0) // Language label
            {
                $options[] = $param . ': "' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($value, $this->extKey) . '"';
            } else {
                $options[] = $param . ':' . (is_numeric($value) || $value === 'true' || $value === 'false' || substr($value,
                        0, 8) == 'function' || $value[0] === '[' ? $value : '"' . $value . '"');
            }
        }

        if (!isset($this->settings['player']['hideContextualMenu'])) {

            array_push($options, 'hideContextualMenu:1');

        }

        // Add callback function. Moved to TS
        //$options[] = 'success: function(media, node, player) {tx_vibeo_player_success_callback(media, node, player);}';

        return '{' . implode(',', $options) . '}';
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $pid = explode(',', $this->settings['records']['pages']);
        $uid = explode(',', $this->settings['records']['media']);

        $medias = empty($uid) && empty($pid) ? array() : $this->mediaRepository->findByUidOrPid($uid, $pid);

        if ($this->settings['list']['startWithThumbnails']) {
            unset($this->settings['player']['defaultVideoWidth'], $this->settings['player']['defaultVideoHeight']);

            $this->view->assign('finalVideoWidth', $this->settings['player']['videoWidth']);
            $this->view->assign('finalVideoHeight', $this->settings['player']['videoHeight']);

            $this->settings['player']['videoWidth'] = round($this->settings['player']['videoWidth'] / 3, 0);
            $this->settings['player']['videoHeight'] = round($this->settings['player']['videoHeight'] / 3, 0);
        }

        $this->view->assign('settings', $this->settings); // Reassign because we changed the settings
        $this->view->assign('medias', $medias);
        $this->view->assign('JSPlayerConfigurationString', $this->getJSPlayerConfigurationString());
        $this->view->assign('extRelativePath', PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)));
        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFooterFile(PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)) . 'Resources/Public/Vibeo/vibeo.js', null, false, false, '', true);
    }

    /**
     * action show
     *
     * @param Media $media
     * @return void
     */
    public function singleAction()
    {
        $media = new Media();

        if ($this->settings['media']['uid']) {
            /** @var Media $media */
            $media = $this->mediaRepository->findByUid($this->settings['media']['uid']);
        }

        if ($this->settings['media']['typoscript']) {
            /** @var \TYPO3\CMS\Extbase\Service\TypoScriptService $typoScriptService */
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
            $typoScriptArray = $typoScriptService->convertPlainArrayToTypoScriptArray($this->settings['media']['typoscript']);
            $stdWrapProperties = GeneralUtility::trimExplode(',', $this->settings['media']['typoscript']['useStdWrap'], true);
            foreach ($stdWrapProperties as $key) {
                if (is_array($typoScriptArray[$key . '.'])) {
                    $this->settings['media'][$key] = $this->configurationManager->getContentObject()->stdWrap(
                        $typoScriptArray[$key],
                        $typoScriptArray[$key . '.']
                    );
                }
            }
        }

        if ($this->settings['media']['files']) {
            $media->setPath($this->settings['media']['files']);
        }
        if ($this->settings['media']['description']) {
            $media->setDescription($this->settings['media']['description']);
        }
        if ($this->settings['media']['url']) {
            $media->setUrl($this->settings['media']['url']);
        }
        if ($this->settings['media']['image']) {
            $media->setImage($this->settings['media']['image']);
        }
        if ($this->settings['media']['track']) {
            $media->setTrack($this->settings['media']['track']);
        }

        $media->setUid($this->getUniqId());

        $this->view->assign('settings', $this->settings); // Reassign because we changed the settings
        $this->view->assign('media', $media);
        $this->view->assign('youtubeEmbed', $this->getYoutubeEmbedUrl($media->getUrl()));
        $this->view->assign('contentObject', $this->configurationManager->getContentObject()->data);
        $this->view->assign('extRelativePath', PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey)));
        $this->view->assign('transcription', $this->settings['media']['transcription']);
        $this->view->assign('downloadable', $this->settings['player']['downloadable']);
        $this->view->assign('pageUid', $GLOBALS['TSFE']->id);

        $arrayFallback = array();
        if ($media->getUrl()) {
            $originalExtension = pathinfo($media->getUrl(), PATHINFO_EXTENSION);
            foreach ($this->fallbackExtensionArray as $newExtension) {
                if ($newExtension != $originalExtension && strlen($media->getUrl()) > strlen($originalExtension)) {
                    $newUrl = substr($media->getUrl(), 0, -strlen($originalExtension)) . $newExtension;
                    if (self::is_url_exist($newUrl)) {
                        $arrayFallback[] = array(
                            'url' => $newUrl,
                            'type' => Media::getMimeByExtension($newUrl)
                        );
                    }
                }
            }
        }
        $this->view->assign('mediaFallback', $arrayFallback);

        $pageRender = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRender->addJsFooterInlineCode('Add video ' . $media->getUid(), '
			// This function will be called after player is initiated
			if(typeof tx_vibeo_player_success_callback == \'undefined\') {
				var tx_vibeo_player_success_callback = function (media, node, player) {}
			}
            $(function(){
                $(\'#tx-vibeo-media-' . $media->getUid() . '\').mediaelementplayer(
					' . $this->getJSPlayerConfigurationString() . '
                );
            });
		');
    }

    private static function getYoutubeEmbedUrl($url)
    {
        if (strstr($url, 'youtube') === false) {
            return false;
        }
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube-nocookie.com/embed/' . $youtube_id ;
    }

    private static function is_url_exist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    protected function getUniqId()
    {
        $this->contentObj = $this->configurationManager->getContentObject();
        return $this->contentObj->data['uid'] ? $this->contentObj->data['uid'] : GeneralUtility::md5int($this->contentObj->data[0] ?: 0);
    }

}

