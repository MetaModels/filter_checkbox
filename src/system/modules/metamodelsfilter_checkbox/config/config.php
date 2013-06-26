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
$GLOBALS['METAMODELS']['filters']['checkbox']['class'] = 'MetaModelFilterSettingCheckbox';
$GLOBALS['METAMODELS']['filters']['checkbox']['image'] = 'system/modules/metamodelsfilter_checkbox/html/filter_checkbox.png';
$GLOBALS['METAMODELS']['filters']['checkbox']['info_callback'] = array('TableMetaModelFilterSetting', 'infoCallback');
$GLOBALS['METAMODELS']['filters']['checkbox']['attr_filter'][] = 'checkbox';