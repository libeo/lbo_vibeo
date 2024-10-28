<?php

namespace Libeo\Vibeo\Controller;

use Libeo\Vibeo\Domain\Model\Transcription;
use Libeo\Vibeo\Domain\Repository\TranscriptionRepository;
use Psr\Http\Message\ResponseInterface;

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
class TranscriptController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    protected $extKey = 'lbo_vibeo';

    /**
     * transcriptionRepository
     *
     * @var TranscriptionRepository
     */
    protected $transcriptionRepository;

    /**
     * injectTranscriptionRepository
     *
     * @param TranscriptionRepository $transcriptionRepository
     * @return void
     */
    public function injectTranscriptionRepository(TranscriptionRepository $transcriptionRepository): void
    {
        $this->transcriptionRepository = $transcriptionRepository;
    }

    /**
     * action show
     *
     * @param Transcription $transcription
     * @param int $backPid
     * @return ResponseInterface
     */
    public function showAction(Transcription $transcription = null, $backPid = 0): ResponseInterface
    {
        if (!$transcription) {
            return $this->htmlResponse('Aucune transcription à afficher.');
        }

        $register['transcriptTitle'] = $transcription->getMetadataTitle();
        $this->request->getAttribute('currentContentObject')->cObjGetSingle('LOAD_REGISTER', $register);

        $langTag = '';
        if ($transcription->getIsDifferentTagLanguageOfPage() !== false) {
            $langTag = ' lang="' . $this->settings['languageTag'][$transcription->getIsDifferentTagLanguageOfPage()] . '"';
        }

        $this->view->assign('transcription', $transcription);
        $this->view->assign('langTag', $langTag);
        $this->view->assign('backPid', $backPid);

        return $this->htmlResponse();
    }
}
