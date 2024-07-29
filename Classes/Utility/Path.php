<?php

namespace Libeo\Vibeo\Utility;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Resolv path Fal, relative link, user_upload
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Path
{

    public static $_this = null;

    private function __contruct()
    {
    }

    public static function getInstance()
    {
        if (self::$_this === null) {
            self::$_this = new Path();
        }
        return self::$_this;
    }

   /**
    * vibeo path Backward compatibility layer
    * possible value
    * path = fileadmin/videos/video.mp4  (4.5 n
    * path = fileadmin/videos/video.mp4
    * path = fileadmin/videos/video.mp4
    * @param string $path
    * @return string
    */
    public static function resolvePath($path)
    {
        if (strpos($path, 't3://file') === 0) {
            $fileUid = substr($path, 14);

            if (MathUtility::canBeInterpretedAsInteger($fileUid)) {
                $fileObject = GeneralUtility::makeInstance(ResourceFactory::class)->getFileObject($fileUid);
                if ($fileObject instanceof \TYPO3\CMS\Core\Resource\FileInterface) {
                    $path = $fileObject->getPublicUrl();
                }
            }
        } elseif (strpos($path, '/') === false) {
            $path = 'uploads/tx_vibeo/'.$path;
        }
        return $path;
    }
}
