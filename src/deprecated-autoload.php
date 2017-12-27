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
 * @author     Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright  2012-2017 The MetaModels team.
 * @license    https://github.com/MetaModels/filter_checkbox/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

// This hack is to load the "old locations" of the classes.


use MetaModels\FilterCheckboxBundle\FilterSetting\Checkbox as CheckboxSetting;
use MetaModels\FilterCheckboxBundle\FilterSetting\CheckboxFilterSettingTypeFactory;

spl_autoload_register(
    function ($class) {
        static $classes = [
            // FilterSetting
            'MetaModels\Filter\Setting\Checkbox'                         => CheckboxSetting::class,
            'MetaModels\Filter\Setting\CheckboxFilterSettingTypeFactory' => CheckboxFilterSettingTypeFactory::class,
        ];

        if (isset($classes[$class])) {
            // @codingStandardsIgnoreStart Silencing errors is discouraged
            @trigger_error('Class "'.$class.'" has been renamed to "'.$classes[$class].'"', E_USER_DEPRECATED);
            // @codingStandardsIgnoreEnd

            if (!class_exists($classes[$class])) {
                spl_autoload_call($class);
            }

            class_alias($classes[$class], $class);
        }
    }
);
