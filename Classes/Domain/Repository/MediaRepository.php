<?php

namespace Libeo\Vibeo\Domain\Repository;

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
class MediaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    public function initializeObject()
    {
        $querySettings = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }


    public function findByUidOrPid($uid = null, $pid = null)
    {
        $query = $this->createQuery();
        $conditions = array();

        if (is_null($uid) && is_null($pid)) {
            return null;
        }

        $conditions[] = $query->in('uid', is_array($uid) ? $uid : array((int) $uid));
        $conditions[] = $query->in('pid', is_array($pid) ? $pid : array((int) $pid));

        $query->matching($query->logicalOr(...$conditions));

        return $query->execute();
    }
}
