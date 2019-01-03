<?php

/**
 * This file is part of MetaModels/filter_checkbox.
 *
 * (c) 2012-2019 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/filter_checkbox
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @author     David Molineus <mail@netzmacht.de>
 * @author     Christian de la Haye <service@delahaye.de>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2019 The MetaModels team.
 * @license    https://github.com/MetaModels/filter_checkbox/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] =
    'urlparam';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] =
    'label';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] =
    'template';
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox extends _attribute_']['+fefilter'][] =
    'ynmode';

$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metasubselectpalettes']['ynmode']['yes']   = array('ynfield');
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metasubselectpalettes']['ynmode']['no']    = array('ynfield');
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metasubselectpalettes']['ynmode']['radio'] = array('blankoption');

$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['fields']['ynfield'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynfield'],
    'exclude'   => true,
    'default'   => true,
    'inputType' => 'checkbox',
    'sql'       => 'char(1) NOT NULL default \'1\'',
    'eval'      => array(
        'tl_class' => 'w50',
    ),
);

$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['fields']['ynmode'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['ynmode'],
    'exclude'   => true,
    'inputType' => 'radio',
    'options'   => array('yes', 'no', 'radio'),
    'reference' => $GLOBALS['TL_LANG']['tl_metamodel_filtersetting'],
    'sql'       => 'varchar(8) NOT NULL default \'yes\'',
    'eval'      => array('tl_class' => 'w50 clr', 'submitOnChange' => true)
);
