<?php

namespace Libeo\Vibeo\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * This is a basic calculation view helper
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class CalculatorViewHelper extends AbstractViewHelper {

    /**
     * Renders some classic dummy content: Lorem Ipsum...
     *
     * @param int $equation The equation
     * @validate $equation IntegerValidator
     * @return Result
     * @author Philippe Moreau
     */
    public function render($equation) {
        eval('$result = '.$equation.';');
        return $result;
    }
}

?>
