<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package    MetaModels
 * @subpackage FilterCheckbox
 * @author     Christian de la Haye <service@delahaye.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

/**
 * filter types
 */
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['typenames']['checkbox'] = 'Yes/no';


/**
 * fields
 */
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynfield']     = array('Yes/no instead of attribute name', 'Show yes/no instead of attribute name and provide attribute name as a headline.');
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynmode']      = array('Modus', 'Ja/Nein auswählbar machen');


/**
 * labels
 */
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['yes']          = 'Checkbox yes';
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['no']           = 'Checkbox no';
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['radio']        = 'Radio selection';