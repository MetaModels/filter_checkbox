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
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['typenames']['checkbox'] = 'Ja/nein';


/**
 * fields
 */
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynfield']     = array('Ja/Nein statt Attributname', 'Ja oder nein statt Attributnamen anzeigen und Attributnamen als Überschrift verwenden.');
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynmode']      = array('Modus', 'Ja/Nein auswählbar machen');


/**
 * labels
 */
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['yes']          = 'Ja-Checkbox';
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['no']           = 'Nein-Checkbox';
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['radio']        = 'Radio-Auswahl';
