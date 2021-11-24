<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/  

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

class SpTypeSelect{

	static function getInput($key, $attr)
	{
		if(!isset($attr['std'])){
			$attr['std'] = '';
		}

		$output  = '<div class="form-group '.$key.'">';
		$output .= '<label>'.$attr['title'].'</label>';

		$output .= '<select class="form-control form-select addon-input" data-attrname="'.$key.'">';
		
		foreach( $attr['values'] as $key => $value )
		{
			$output .= '<option value="'.$key.'" '.(($attr['std'] == $key )?'selected="selected"':'').'>'.$value.'</option>';
		}

		$output .= '</select>';

		if( ( isset($attr['desc']) ) && ( isset($attr['desc']) != '' ) )
		{
			$output .= '<p class="help-block">' . $attr['desc'] . '</p>';
		}

		$output .= '</div>';

		return $output;
	}

}