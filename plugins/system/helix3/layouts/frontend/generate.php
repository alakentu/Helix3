<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;

//helper & model
$menu_class   = JPATH_ROOT . '/plugins/system/helix3/core/classes/helix3.php';

if (file_exists($menu_class)) {
    require_once($menu_class);
}

$template       = Factory::getApplication()->getTemplate();
$themepath      = JPATH_THEMES . '/' . $template;
$rows_file      = $themepath . '/html/layouts/helix3/frontend/rows.php';
$lyt_thm_path   = $themepath . '/html/layouts/helix3/';

$layout_path  = (file_exists($rows_file)) ? $lyt_thm_path : JPATH_ROOT .'/plugins/system/helix3/layouts';

$data = $displayData;

$output ='';

$output .= '<' . $data['sematic'] . ' id="' . $data['id'] . '"' . $data['row_class'] . '>';

if ($data['componentArea']){
    if (!$data['pagebuilder'] && !$data['fluidrow']){
        $output .= '<div class="container">';
    }
}
else{
    if (!$data['fluidrow']){
        $output .= '<div class="container">';
    }
}


$getLayout = new FileLayout('frontend.rows', $layout_path );

$output .= $getLayout->render($data);


if ($data['componentArea']){
    if (!$data['pagebuilder']){
        $output .= '</div>';
    }
}
else{
    if (!$data['fluidrow']){
        $output .= '</div>';
    }
}

$output .= '</' . $data['sematic'] . '>';


echo $output;
