<?php

/**
 * This file is part of MetaModels/filter_checkbox.
 *
 * (c) 2012-2017 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels
 * @subpackage FilterCheckboxBundle
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright  2012-2017 The MetaModels team.
 * @license    https://github.com/MetaModels/filter_checkbox/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

namespace MetaModels\FilterCheckboxBundle\FilterSetting;

use MetaModels\Filter\Setting\AbstractFilterSettingTypeFactory;

/**
 * Attribute type factory for tags filter settings.
 */
class CheckboxFilterSettingTypeFactory extends AbstractFilterSettingTypeFactory
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setTypeName('checkbox')
            ->setTypeIcon('system/modules/metamodelsfilter_checkbox/html/filter_checkbox.png')
            ->setTypeClass('MetaModels\Filter\Setting\Checkbox')
            ->allowAttributeTypes('checkbox');
    }
}
