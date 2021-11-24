<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;

Text::script('HELIX_NO_IMAGE_SELECTED');
Text::script('HELIX_DOCUMENTATION');
Text::script('HELIX_COMMUNITY');
Text::script('HELIX_PREMIUM_TEMPLATES');
Text::script('HELIX_JOOMLA_EXTENSIONS');
Text::script('HELIX_CHANGE_CURRENT_SETTINGS');
Text::script('HELIX_ALERT_WRONG');
Text::script('HELIX_DELETE_LAYOUT_NAME');
Text::script('HELIX_YOU_DOING_SOMETHINGS_WRONG');
Text::script('HELIX_SAVE_NEW_LAYOUT');
Text::script('HELIX_ROW_SETTINGS');
Text::script('HELIX_COLUMN_SETTINGS');
Text::script('HELIX_AREA_COMPONENT_TAKEN');
Text::script('HELIX_SECTION_HEADER');
Text::script('HELIX_COMPONENT');
Text::script('HELIX_ALERT_LAYOUT_NO_NAME_NOT_SAVE');
Text::script('HELIX_ENTER_CUSTOM_LAYOUT_GRID');
Text::script('HELIX_ERROR_GENERATED');
Text::script('HELIX_NONE');
Text::script('HELIX_CLICK_OK_TO_DELETE_ROW');

class JFormFieldAsset extends FormField
{
	protected	$type = 'Asset';

	protected function getInput()
	{
		$helix_plg_url 	= Uri::root(true) . '/plugins/system/helix3';
		$doc 			= Factory::getDocument();
		$version 		= Version::MAJOR_VERSION;
	
		$doc->addScriptdeclaration('var layoutbuilder_base="' . Uri::root() . '";');
		$doc->addScriptDeclaration("var joomlaVersion = ".$version.";");
		$doc->addScriptDeclaration("var basepath = '{$helix_plg_url}';");
		$doc->addScriptDeclaration("var pluginVersion = '{$this->getVersion()}';");
		
	
		//Core scripts
		HTMLHelper::_('jquery.framework');
	
		$doc->addScript($helix_plg_url . '/assets/js/jquery-ui.min.js');
		$doc->addScript($helix_plg_url . '/assets/js/helper.js');
		$doc->addScript($helix_plg_url . '/assets/js/webfont.js');
		$doc->addScript($helix_plg_url . '/assets/js/modal.js');
		$doc->addScript($helix_plg_url . '/assets/js/admin.general.js');
		$doc->addScript($helix_plg_url . '/assets/js/admin.layout.js');
	
		//CSS
		$doc->addStyleSheet($helix_plg_url . '/assets/css/bootstrap.css');
		$doc->addStyleSheet($helix_plg_url . '/assets/css/modal.css');
		$doc->addStyleSheet($helix_plg_url . '/assets/css/font-awesome.min.css');
		
		if(version_compare(Version::MAJOR_VERSION, '4', '>='))
		{
			$doc->addStyleSheet($helix_plg_url . '/assets/css/admin.general.j4.css');
		}
		else
		{
			$doc->addStyleSheet($helix_plg_url . '/assets/css/admin.general.css');
		}
	}

	private function getVersion()
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array('*'))
			->from($db->quoteName('#__extensions'))
			->where($db->quoteName('type').' = '.$db->quote('plugin'))
			->where($db->quoteName('element').' = '.$db->quote('helix3'))
			->where($db->quoteName('folder').' = '.$db->quote('system'));
		$db->setQuery($query);
		$result = $db->loadObject();
		$manifest_cache = json_decode($result->manifest_cache);
		
		if (isset($manifest_cache->version)) {
			return $manifest_cache->version;
		}
    
		return;
	}
}
