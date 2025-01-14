<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/  

defined('_JEXEC') or die;

class SpTypeCheckbox{

	static function getInput($key, $attr)
	{

		if (isset($attr['value'])) {
			$attr['std'] = $attr['value'];
		}else{
			if (!isset($attr['std'])) {
				$attr['std'] = '0';
			}
		}

		$output   = '<div class="form-group">';
		$output  .= '<div class="checkbox">';
		$output  .= '<label>';
		$output  .= '<input class="addon-input input-'.$key.'" data-attrname="'.$key.'" type="checkbox" '.(($attr['std'] == 1)?'checked':'').'> ' .$attr['title'];
		$output  .= '</label>';
		$output  .= '</div>';

		if( ( isset($attr['desc']) ) && ( isset($attr['desc']) != '' ) )
		{
			$output .= '<p class="help-block">' . $attr['desc'] . '</p>';
		}

		$output  .= '</div>';

		return $output;
	}

}