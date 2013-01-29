<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package    MetaModels
 * @subpackage FrontendFilter
 * @author     Christian de la Haye <service@delahaye.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */
if (!defined('TL_ROOT'))
{
	die('You cannot access this file directly!');
}


/**
 * Filter "checkbox" for FE-filtering, based on filters by the meta models team.
 *
 * @package	   MetaModels
 * @subpackage FrontendFilter
 * @author     Christian de la Haye <service@delahaye.de>
 */
class MetaModelFilterSettingCheckbox extends MetaModelFilterSettingSimpleLookup
{
	/**
	 * {@inheritdoc}
	 */
	public function getParameterDCA()
	{
		// if defined as static, return nothing as not to be manipulated via editors.
		if (!$this->get('predef_param'))
		{
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
	 */
	public function getParameterFilterWidgets($arrIds, $arrFilterUrl, $arrJumpTo, $blnAutoSubmit)
	{

		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));

		$arrWidget = array
		(
			'label'     => array(
				($this->get('label') ? $this->get('label') : $objAttribute->getName()),
				$GLOBALS['TL_LANG']['MSC']['yes']
				),
			'inputType' => 'checkbox',
			'eval'      => array(
				'colname'            => $objAttribute->getColname(),
				'urlparam'           => $this->getParamName(),
				'yesfield'           => $this->get('yesfield'),
				'template'           => $this->get('template'),
			)
		);

		if (false && !$this->get('yesfield'))
		{
			$arrWidget['options'] = array
			(
				0 => $GLOBALS['TL_LANG']['MSC']['no'],
				1 => $GLOBALS['TL_LANG']['MSC']['yes']
			);
		}
var_dump($this->prepareFrontendFilterWidget($arrWidget, $arrFilterUrl, $arrJumpTo, $blnAutoSubmit));

		return array
		(
			$this->getParamName() => $this->prepareFrontendFilterWidget($arrWidget, $arrFilterUrl, $arrJumpTo, $blnAutoSubmit)
		);
	}
}

?>