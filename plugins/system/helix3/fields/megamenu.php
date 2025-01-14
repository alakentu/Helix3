<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;

class JFormFieldMegamenu extends FormField
{
	protected $type = "Megamenu";
	
	public function getInput()
	{
		$mega_menu_path = JPATH_SITE.'/plugins/system/helix3/fields/';
	
		$html = $this->getMegaSettings($mega_menu_path,json_decode($this->value));
		$html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'">';
	
		return $html;
	}
	
	public function getMegaSettings($path,$value = null)
	{
		ob_start();
		$menu_data = $value;
		include_once $path . 'menulayout.php';
		$html = ob_get_contents();
		ob_clean();
	
		return $html;
	}
}
