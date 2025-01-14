<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;

class JFormFieldSpgallery extends FormField
{
  protected $type = 'Spgallery';

  protected function getInput()
  {
    $doc = Factory::getDocument();

    HTMLHelper::_('jquery.framework');

    $plg_path = Uri::root(true) . '/plugins/system/helix3';
    $doc->addScript($plg_path . '/assets/js/jquery-ui.min.js');
    $doc->addScript($plg_path . '/assets/js/spgallery.js');
    $doc->addStyleSheet($plg_path . '/assets/css/spgallery.css');

    $values = json_decode($this->value);

    if($values) {
      $images = $this->element['name'] . '_images';
      $values = $values->$images;
    } else {
      $values = array();
    }

    $output  = '<div class="sp-gallery-field">';
    $output .= '<ul class="sp-gallery-items clearfix">';

    if(is_array($values) && $values) {
      foreach ($values as $key => $value) {

        $data_src = $value;

        $src = Uri::root(true) . '/' . $value;

        $basename = basename($src);

        $thumbnail = JPATH_ROOT . '/' . dirname($value) . '/' . File::stripExt($basename) . '_thumbnail.' . File::getExt($basename);
        
        if(file_exists($thumbnail)) {
          $src = Uri::root(true) . '/' . dirname($value) . '/' . File::stripExt($basename) . '_thumbnail.' . File::getExt($basename);
        }

        $small_size = JPATH_ROOT . '/' . dirname($value) . '/' . File::stripExt($basename) . '_small.' . File::getExt($basename);
        
        if(file_exists($small_size)) {
          $src = Uri::root(true) . '/' . dirname($value) . '/' . File::stripExt($basename) . '_small.' . File::getExt($basename);
        }

        $output .= '<li data-src="' . $data_src . '"><a href="#" class="btn btn-mini btn-danger btn-remove-image">Delete</a><img src="'. $src .'" alt=""></li>';
      }
    }

    $output .= '</ul>';

    $output .= '<input type="file" class="sp-gallery-item-upload" accept="image/*" style="display:none;">';
    $output .= '<a class="btn btn-default btn-outline-primary btn-sp-gallery-item-upload" href="#"><i class="fa fa-plus"></i> Upload Images</a>';


    $output .= '<input type="hidden" name="'. $this->name .'" data-name="'. $this->element['name'] .'_images" id="' . $this->id . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8')
    . '"  class="form-field-spgallery">';
    $output .= '</div>';

    return $output;
  }
}