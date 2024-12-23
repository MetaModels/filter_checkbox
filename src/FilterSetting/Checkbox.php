<?php

/**
 * This file is part of MetaModels/filter_checkbox.
 *
 * (c) 2012-2024 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/filter_checkbox
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Christian de la Haye <service@delahaye.de>
 * @author     Andreas Isaak <info@andreas-isaak.de>
 * @author     Andreas Nölke <zero@brothers-project.de>
 * @author     David Molineus <mail@netzmacht.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @author     Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright  2012-2024 The MetaModels team.
 * @license    https://github.com/MetaModels/filter_checkbox/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\FilterCheckboxBundle\FilterSetting;

use Contao\StringUtil;
use MetaModels\Attribute\IAttribute;
use MetaModels\Filter\IFilter;
use MetaModels\Filter\Rules\SearchAttribute;
use MetaModels\Filter\Rules\StaticIdList;
use MetaModels\Filter\Setting\SimpleLookup;
use MetaModels\FrontendIntegration\FrontendFilterOptions;
use MetaModels\IMetaModel;

/**
 * Filter "checkbox" for FE-filtering, based on filters by the MetaModels team.
 */
class Checkbox extends SimpleLookup
{
    /**
     * {@inheritdoc}
     */
    public function prepareRules(IFilter $objFilter, $arrFilterUrl)
    {
        $objMetaModel = $this->getMetaModel();
        $arrLanguages = $this->getAvailableLanguages($objMetaModel) ?? [];
        $objAttribute = $objMetaModel->getAttributeById((int) $this->get('attr_id'));

        $strParamName = $this->getParamName();
        assert(\is_string($strParamName));

        // If is a checkbox defined as "no", 1 has to become -1 like with radio fields.
        if (isset($arrFilterUrl[$strParamName])) {
            $arrFilterUrl[$strParamName] =
                ($arrFilterUrl[$strParamName] === '1' && $this->get('ynmode') === 'no'
                    ? '-1'
                    : (string) $arrFilterUrl[$strParamName]);
        }

        if ($objAttribute && $strParamName && !empty($arrFilterUrl[$strParamName])) {
            // Param -1 has to be '' meaning 'really empty'.
            $arrFilterUrl[$strParamName] = ($arrFilterUrl[$strParamName] === $this->getParamValue(
                'no'
            ) ? '' : ($arrFilterUrl[$strParamName] === $this->getParamValue('yes') ? '1' : ''));

            $objFilterRule = new SearchAttribute(
                $objAttribute,
                $arrFilterUrl[$strParamName],
                \array_values(\array_filter($arrLanguages))
            );
            $objFilter->addFilterRule($objFilterRule);

            return;
        }

        $objFilter->addFilterRule(new StaticIdList(null));
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function getParameterDCA()
    {
        // If defined as static, return nothing as not to be manipulated via editors.
        if (!$this->get('predef_param')) {
            return [];
        }

        $strParamName = $this->getParamName();
        assert(\is_string($strParamName));

        if ($this->get('ynmode') === 'radio') {
            return [
                $strParamName => [
                    'label'     => [
                        $this->getLabel(),
                        'GET: ' . $this->get('urlparam')
                    ],
                    'inputType' => 'radio',
                    'options'   => [
                        $this->getParamValue('yes') => $this->getParamValue('yes'),
                        $this->getParamValue('no')  => $this->getParamValue('no')
                    ],
                    'reference' => [
                        $this->getParamValue('yes') => $this->translator->trans('MSC.yes', [], 'contao_default'),
                        $this->getParamValue('no')  => $this->translator->trans('MSC.no', [], 'contao_default')
                    ],
                    'eval'      => [
                        'includeBlankOption' => $this->get('blankoption')
                    ]
                ]
            ];
        }

        return [
            $strParamName => [
                'label'     => [
                    $this->getLabel(),
                    'GET: ' . $this->get('urlparam')
                ],
                'inputType' => 'checkbox'
            ]
        ];
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
     * @SuppressWarnings(PHPMD.LongVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getParameterFilterWidgets(
        $arrIds,
        $arrFilterUrl,
        $arrJumpTo,
        FrontendFilterOptions $objFrontendFilterOptions
    ) {

        $objAttribute = $this->getMetaModel()->getAttributeById((int) $this->get('attr_id'));
        assert($objAttribute instanceof IAttribute);

        $cssID = StringUtil::deserialize($this->get('cssID'), true);

        $arrWidget = [
            'label'     => $this->prepareLabel($objAttribute),
            'inputType' => ($this->get('ynmode') === 'radio' ? 'radio' : 'checkbox'),
            'eval'      => [
                'colname'            => $objAttribute->getColName(),
                'urlparam'           => $this->getParamName(),
                'ynmode'             => $this->get('ynmode'),
                'ynfield'            => $this->get('ynfield'),
                'template'           => $this->get('template'),
                'cssID'              => !empty($cssID[0]) ? ' id="' . $cssID[0] . '"' : '',
                'class'              => !empty($cssID[1]) ? ' ' . $cssID[1] : '',
                'includeBlankOption' => ($this->get('ynmode') === 'radio' && $this->get('blankoption') ? true : false),
            ]
        ];

        if ($this->get('ynmode') === 'radio') {
            $arrWidget['options']   = [
                0 => $this->getParamValue('yes'),
                1 => $this->getParamValue('no')
            ];
            $arrWidget['reference'] = [
                $this->getParamValue('yes') => $this->translator->trans('MSC.yes', [], 'contao_default'),
                $this->getParamValue('no')  => $this->translator->trans('MSC.no', [], 'contao_default')
            ];
        }

        if ($arrWidget['eval']['includeBlankOption']) {
            $arrWidget['eval']['blankOptionLabel'] = $this->translator->trans('do_not_filter', [], 'metamodels_filter');
        }

        if ($this->get('ynmode') !== 'radio' && $this->get('option_label_param')) {
            $arrWidget['options'] = [$this->getParamValue($this->get('ynmode')) => $arrWidget['label'][1]];
        }

        $this->addFilterParam();

        $strParamName = $this->getParamName();
        assert(\is_string($strParamName));

        return [
            $strParamName => $this->prepareFrontendFilterWidget(
                $arrWidget,
                $arrFilterUrl,
                $arrJumpTo,
                $objFrontendFilterOptions
            )
        ];
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
        /** @psalm-suppress DeprecatedMethod */
        return ($objMetaModel->isTranslated() && $this->get('all_langs'))
            ? $objMetaModel->getAvailableLanguages()
            : [$objMetaModel->getActiveLanguage()];
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
        return ($this->get('ynmode') === 'radio' || $this->get('ynfield')
            ?
            [
                ($this->get('label') ?: $objAttribute->getName()),
                ($this->get('ynmode') === 'yes'
                    ? $this->translator->trans('MSC.yes', [], 'contao_default')
                    : $this->translator->trans('MSC.no', [], 'contao_default')
                )
            ]
            :
            [
                ($this->get('label') ?: $objAttribute->getName()),
                ($this->get('ynmode') === 'yes'
                    ? $this->translator->trans(
                        'extended_yes',
                        ['%attribute%' => ($this->get('label') ?: $objAttribute->getName())],
                        'tl_metamodel_filtersetting'
                    )
                    : $this->translator->trans(
                        'extended_nos',
                        ['%attribute%' => ($this->get('label') ?: $objAttribute->getName())],
                        'tl_metamodel_filtersetting'
                    )
                )
            ]
        );
    }

    /**
     * Prepare the parameter value.
     *
     * @param string $value The value.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function getParamValue(string $value): string
    {
        if ($this->get('option_label_param')) {
            return 'yes' === $value
                ? $this->translator->trans('MSC.yes', [], 'contao_default')
                : $this->translator->trans('MSC.no', [], 'contao_default');
        }

        return 'yes' === $value ? '1' : '-1';
    }
}
