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
 * palettes
 */
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+config'][] = 'urlparam';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] = 'label';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] = 'template';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] = 'ynmode';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metasubselectpalettes']['ynmode']['yes'] = array('ynfield');
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metasubselectpalettes']['ynmode']['no'] = array('ynfield');
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metasubselectpalettes']['ynmode']['radio'] = array('blankoption');


/**
 * fields
 */
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['fields']['ynfield'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynfield'],
	'exclude'                 => true,
	'default'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array(
		'tl_class'            => 'w50',
	),
);

$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['fields']['ynmode'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynmode'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options'      			  => array('yes','no','radio'),
	'reference'               => $GLOBALS['TL_LANG']['tl_metamodel_filtersetting'],
	'eval'                    => array('tl_class'=>'w50 clr', 'submitOnChange'=>true)
);