<?php

namespace Libeo\Vibeo\Domain\Model;

use TYPO3\CMS\Core\Context\Context;
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
class Transcription extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Title of this element
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Text description for this element
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Metadata title
	 *
	 * @var string
	 */
	protected $metadataTitle;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the metadataTitle
	 *
	 * @return string $metadataTitle
	 */
	public function getMetadataTitle() {
		return $this->metadataTitle;
	}

	/**
	 * Sets the metadataTitle
	 *
	 * @param string $metadataTitle
	 * @return void
	 */
	public function setMetadataTitle($metadataTitle) {
		$this->metadataTitle = $metadataTitle;
	}

	/**
	 * Returns the differentLanguage
	 *
	 * @return string
	 */
	public function getIsDifferentTagLanguageOfPage() {
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
		if($languageAspect->getId() != $this->_languageUid) {
			return $this->_languageUid;
		} else {
			return false;
		}
	}

}
