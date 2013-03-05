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
 * Frontend filter
 */

// y/n checkbox
$GLOBALS['METAMODELS']['filters']['checkbox'] = array
(
	'class' => 'MetaModelFilterSettingCheckbox',
	'attr_filter' => array('checkbox'),
	'image' => 'system/modules/metamodelsfilter_checkbox/html/filter_checkbox.png',
	'info_callback' => array('TableMetaModelFilterSetting','infoCallback'),
);