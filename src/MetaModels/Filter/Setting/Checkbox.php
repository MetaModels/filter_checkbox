<?php

/**
 * This file is part of MetaModels/filter_checkbox.
 *
 * (c) 2012-2016 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels
 * @subpackage FilterCheckbox
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Christian de la Haye <service@delahaye.de>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @author     Andreas Nölke <zero@brothers-project.de>
 * @author     David Molineus <mail@netzmacht.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @copyright  2012-2016 The MetaModels team.
 * @license    https://github.com/MetaModels/filter_checkbox/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

namespace MetaModels\Filter\Setting;

use MetaModels\Attribute\IAttribute;
use MetaModels\Filter\IFilter;
use MetaModels\Filter\Rules\SearchAttribute;
use MetaModels\Filter\Rules\StaticIdList;
use MetaModels\FrontendIntegration\FrontendFilterOptions;
use MetaModels\IMetaModel;

/**
 * Filter "checkbox" for FE-filtering, based on filters by the meta models team.
 */
class Checkbox extends SimpleLookup
{
    /**
     * {@inheritdoc}
     */
    public function prepareRules(IFilter $objFilter, $arrFilterUrl)
    {
        $objMetaModel = $this->getMetaModel();
        $arrLanguages = $this->getAvailableLanguages($objMetaModel);
        $objAttribute = $objMetaModel->getAttributeById($this->get('attr_id'));

        $strParamName = $this->getParamName();

        // If is a checkbox defined as "no", 1 has to become -1 like with radio fields.
        if (isset($arrFilterUrl[$strParamName])) {
            $arrFilterUrl[$strParamName] =
                ($arrFilterUrl[$strParamName] == '1' && $this->get('ynmode') == 'no'
                    ? '-1'
                    : $arrFilterUrl[$strParamName]);
        }

        if ($objAttribute && $strParamName && !empty($arrFilterUrl[$strParamName])) {
            // Param -1 has to be '' meaning 'really empty'.
            $arrFilterUrl[$strParamName] = ($arrFilterUrl[$strParamName] == '-1' ? '' : $arrFilterUrl[$strParamName]);

            $objFilterRule = new SearchAttribute($objAttribute, $arrFilterUrl[$strParamName], $arrLanguages);
            $objFilter->addFilterRule($objFilterRule);

            return;
        }

        $objFilter->addFilterRule(new StaticIdList(null));
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterDCA()
    {
        // If defined as static, return nothing as not to be manipulated via editors.
        if (!$this->get('predef_param')) {
            return array();
        }

        $objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));

        return array(
            $this->getParamName() => array
            (
                'label'     => array(
                    ($this->get('label') ? $this->get('label') : $objAttribute->getName()),
                    'GET: '.$this->get('urlparam')
                ),
                'inputType' => 'checkbox',
            )
        );
    }

    /**
     * Overrides the parent implementation to always return true, as this setting is always optional.
     *
     * @return bool true if all matches shall be returned, false otherwise.
     */
    public function allowEmpty()
    {
        return true;
    }

    /**
     * Overrides the parent implementation to always return true, as this setting is always available for FE filtering.
     *
     * @return bool true as this setting is always available.
     */
    public function enableFEFilterWidget()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getParameterFilterWidgets(
        $arrIds,
        $arrFilterUrl,
        $arrJumpTo,
        FrontendFilterOptions $objFrontendFilterOptions
    ) {

        $objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));

        $arrWidget = array
        (
            'label'     => $this->prepareLabel($objAttribute),
            'inputType' => ($this->get('ynmode') == 'radio' ?: 'checkbox'),
            'eval'      => array(
                'colname'            => $objAttribute->getColName(),
                'urlparam'           => $this->getParamName(),
                'ynmode'             => $this->get('ynmode'),
                'ynfield'            => $this->get('ynfield'),
                'template'           => $this->get('template'),
                'includeBlankOption' => ($this->get('ynmode') == 'radio' && $this->get('blankoption') ? true : false),
            )
        );

        if ($this->get('ynmode') == 'radio') {
            $arrWidget['options']   = array
            (
                0    => '-1',
                1    => '1'
            );
            $arrWidget['reference'] = array
            (
                '-1' => $GLOBALS['TL_LANG']['MSC']['no'],
                '1'  => $GLOBALS['TL_LANG']['MSC']['yes']
            );
        }

        $this->addFilterParam();

        return array
        (
            $this->getParamName() => $this->prepareFrontendFilterWidget(
                $arrWidget,
                $arrFilterUrl,
                $arrJumpTo,
                $objFrontendFilterOptions
            )
        );
    }

    /**
     * Add filter param to global.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function addFilterParam()
    {
        $GLOBALS['MM_FILTER_PARAMS'][] = $this->getParamName();
    }

    /**
     * Get available langauges.
     *
     * @param IMetaModel $objMetaModel The metamodel.
     *
     * @return array|null|\string[]
     */
    private function getAvailableLanguages(IMetaModel $objMetaModel)
    {
        return ($objMetaModel->isTranslated() && $this->get('all_langs'))
            ? $objMetaModel->getAvailableLanguages()
            : array($objMetaModel->getActiveLanguage());
    }

    /**
     * Prepare the label depending on yes no mode.
     *
     * @param IAttribute $objAttribute The metamodel attribute.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function prepareLabel(IAttribute $objAttribute)
    {
        return ($this->get('ynmode') == 'radio' || $this->get('ynfield') ?
            array(
                ($this->get('label') ?: $objAttribute->getName()),
                ($this->get('ynmode') == 'yes'
                    ? $GLOBALS['TL_LANG']['MSC']['yes']
                    : $GLOBALS['TL_LANG']['MSC']['no']
                )
            )
            :
            array(
                ($this->get('label') ?: $objAttribute->getName()),
                ($this->get('ynmode') == 'no'
                    ? sprintf(
                        $GLOBALS['TL_LANG']['MSC']['extended_no'],
                        ($this->get('label') ?: $objAttribute->getName())
                    )
                    : ($this->get('label') ?: $objAttribute->getName())
                )
            )
        );
    }
}
