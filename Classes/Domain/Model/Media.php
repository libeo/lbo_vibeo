<?php

namespace Libeo\Vibeo\Domain\Model;

use TYPO3\CMS\Core\Error\Exception;
use Libeo\Vibeo\Utility\Path;
use TYPO3\CMS\Core\Type\File\FileInfo;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
class Media extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Title of this element
     *
     * @var string
     */
    protected $title;

    /**
     * Subtitle of this element
     *
     * @var string
     */
    protected $subtitle;

    /**
     * Author of this video or audio content
     *
     * @var string
     */
    protected $author;

    /**
     * Text description for this element
     *
     * @var string
     */
    protected $description;

    /**
     * Files used for this element. Video and audio elements can have multiple files that will automatically rollback depending on the browser's supported formats. Possible audio or video formats are: MP4 WEBM OGG MPEG M4V OGV MOV RTMP AAC MP1 MP2 MP3 MPG M4A OGA WAV FLV
     *
     * @var string
     */
    protected $path;

    /**
     * URL of the media file is this is an external video or audio file
     *
     * @var string
     */
    protected $url;

    /**
     * Replacement image if the video or audio file cannot be played.
     *
     * @var string
     */
    protected $image;

    /**
     * Track files used for subtitles during video playback. Possible formats are: VTT TTML SRT TXT CSV XML
     *
     * @var string
     */
    protected $track;

    /**
     * fileType: 'video','audio','youtube','vimeo'. Used only internally.
     *
     * @var string
     */
    protected $mediaType;

    /**
     * File MIME-Type
     *
     * @var string
     */
    protected $fileType;


    /**
     * uid setter
     * @param integer $uid
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Sets the subtitle
     *
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the author
     *
     * @return string $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the author
     *
     * @param string $author
     * @return void
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the path
     *
     * @param string $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the image
     *
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param string $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Returns the track
     *
     * @return string $track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * Sets the track
     *
     * @param string $track
     * @return void
     */
    public function setTrack($track)
    {
        $this->track = $track;
    }

    /**
     * Sets media type
     *
     * @param string $track
     * @return void
     */
    public function setMediaType($mediatype)
    {
        $this->mediaType = $mediatype;
    }

    /**
     * Sets file type
     *
     * @param string $type
     * @return void
     */
    public function setFileType($filetype)
    {
        $this->fileType = $filetype;
    }

    /**
     * Gets media type
     *
     * @return string
     */
    public function getMediaType()
    {
        if (empty($this->mediaType)) {
            $this->setFileAndMediaTypes();
        }

        return $this->mediaType;
    }

    /**
     * Gets file type
     *
     * @return string
     */
    public function getFileType()
    {
        if (empty($this->fileType)) {
            $this->setFileAndMediaTypes();
        }

        return $this->fileType;
    }


    public function __construct()
    {
        $this->setFileAndMediaTypes();
    }


    /**
     * Get the MIME-TYPE for the media
     *
     * @param   string      $file: the filepath
     * @return  The Pseudo-MIME-TYPE of the file, leaves empty if no match
     */
    protected function setFileAndMediaTypes()
    {
        $mime = '';
        $url = $this->getUrl();
        $media = explode(',', $this->getPath());

        if (!empty($url)) {
            if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                $this->setFileType('video/youtube');
                $this->setMediaType('video');
            } elseif (strpos($url, 'vimeo.com') !== false) {
                $this->setFileType('video/vimeo');
                $this->setMediaType('video');
            } elseif (strpos($url, 'amazonaws.com') !== false) {
                $this->setFileType('video/amazons3');
                $this->setMediaType('video');

                $mime = $this->getMimeTypeFromUrl($url);
                $this->setFileType($mime);
                $this->setMediaType(substr($mime, 0, strpos($mime, '/')));
            } else {
                $mime = $this->getMimeTypeFromUrl($url);
                $this->setFileType($mime);
                $this->setMediaType(substr($mime, 0, strpos($mime, '/')));
            }
        } elseif (!empty($media[0])) {
            $resolver = Path::getInstance();
            $filepath = $resolver::resolvePath($media[0]);
            $mime = $this->getMimeByExtension($filepath);
            $this->setFileType($mime);
            $this->setMediaType(substr($mime, 0, strpos($mime, '/')));
        }

        return;
    }

    /*
    * Utility function to get MIME type of supported audio and video formats
    */
    protected function getMimeTypeFromFile($file)
    {
        if (!$file) {
            return '';
        }
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            try {
                $mime = finfo_file($finfo, $file);
            } catch (Exception) {
                $mime = '';
            }

            finfo_close($finfo);

            if (!empty($mime)) {
                return $mime;
            }
        }

        return $this->getMimeByExtension($file);
    }

    protected function getMimeTypeFromUrl($url)
    {
        return $this->getMimeByExtension($url);
    }

    /*
    * Get list of media files as array for use in a view
    */
    public function getMediaFilesInformation()
    {
        $info = array();
        $media = explode(',', $this->getPath());

        foreach ($media as $m) {
            if (!empty($m)) {
                $resolver = Path::getInstance();
                $filepath = $resolver::resolvePath($m);
                $info[] = array(
                    'path' => $filepath,
                    'mimetype' => $this->getMimeTypeFromFile($filepath)
                );
            }
        }

        return $info;
    }


    /*
    * Get first media file
    */
    public function getFirstMediaFile()
    {
        $media = explode(',', $this->getPath());

        if (!empty($media)) {
            $resolver = Path::getInstance();
            $filepath = $resolver::resolvePath($media[0]);
            return $filepath;
        }

        return '';
    }


    public function getImagePath()
    {
        $filepath = $this->image;
        if (!empty($this->image)) {
            $resolver = Path::getInstance();
            $filepath = $resolver::resolvePath($this->image);
        }
        return $filepath;
    }
    public function getTrackPath()
    {
        $trackpath = $this->track;
        if (!empty($this->track)) {
            $resolver = Path::getInstance();
            $trackpath = $resolver::resolvePath($this->track);
        }
        return $trackpath;
    }

    /**
     * @param $file
     * @return string
     */
    public static function getMimeByExtension($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'flv':
                $mime = 'video/flv';
                break;
            case 'webm':
                $mime = 'video/webm';
                break;
            case 'ogg':
                $mime = 'video/ogg';
                break;
            case 'mpeg':
                $mime = 'video/mpeg';
                break;
            case 'mp4':
                $mime = 'video/mp4';
                break;
            case 'm4v':
                $mime = 'video/m4v';
                break;
            case 'mov':
                $mime = 'video/mov';
                break;
            case 'rtmp':
                $mime = 'video/rtmp';
                break;
            case 'ogv':
                $mime = 'video/ogg';
                break;
            case 'aac':
                $mime = 'audio/aac';
                break;
            case 'mp1':
                $mime = 'audio/mpeg';
                break;
            case 'mp2':
                $mime = 'audio/mpeg';
                break;
            case 'mp3':
                $mime = 'audio/mpeg';
                break;
            case 'mpg':
                $mime = 'audio/mpeg';
                break;
            case 'm4a':
                $mime = 'audio/mp4';
                break;
            case 'oga':
                $mime = 'audio/ogg';
                break;
            case 'wav':
                $mime = 'audio/wav';
                break;
        }
        return $mime;
    }
}
