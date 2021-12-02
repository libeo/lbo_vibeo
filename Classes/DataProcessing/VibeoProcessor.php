<?php
declare(strict_types=1);

namespace Libeo\Vibeo\DataProcessing;

use Libeo\Vibeo\Domain\Repository\MediaRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Minimal TypoScript configuration
 * Process field pi_flexform and overrides the values stored in data
 *
 * 10 = Libeo\Vibeo\DataProcessing\VibeoProcessor
 *
 *
 * Advanced TypoScript configuration
 * Process field assigned in fieldName and stores processed data to new key
 *
 * 10 = Libeo\Vibeo\DataProcessing\VibeoProcessor
 * 10 {
 *   fieldName = video
 *   as = video
 * }
 */
class VibeoProcessor implements DataProcessorInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->mediaRepository = $objectManager->get(MediaRepository::class);
    }

    /**
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        $fieldName = $cObj->stdWrapValue('fieldName', $processorConfiguration);
        if (empty($fieldName)) {
            $fieldName = 'video';
        }
        if (!$processedData['data'][$fieldName]) {
            return $processedData;
        }

        // Instantiate a Vibeo player
        $vibeo = [
            'userFunc' => 'TYPO3\CMS\Extbase\Core\Bootstrap->run',
            'extensionName' => 'LboVibeo',
            'pluginName' => 'Vibeosinglemedia'
        ];
        $vibeo['settings']['media']['uid'] = $processedData['data'][$fieldName];

        $htmlVibeo = $GLOBALS['TSFE']->cObj->cObjGetSingle('USER', $vibeo);

        // Set the target variable
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if (!empty($targetVariableName)) {
            $processedData[$targetVariableName] = $htmlVibeo;
        } else {
            $processedData['data'][$fieldName] = $htmlVibeo;
        }

        return $processedData;
    }
}
