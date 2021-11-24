<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Registry\Registry;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;

if(!class_exists('Helix3')) {
	require_once (__DIR__ . '/core/helix3.php');
}

class PlgSystemHelix3 extends CMSPlugin
{
	protected $app;
	
	protected $db;
	
	protected $autoloadLanguage = true;
	
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		
		if (!$this->app)
		{
			$this->app = Factory::getApplication();
		}
		
		if (!$this->db)
		{
			$this->db = Factory::getDbo();
		}
	}

    // Copied style
    public function onAfterDispatch()
    {
        if( ! $this->app->isClient('administrator') ) {

            $activeMenu = $this->app->getMenu()->getActive();

            if(is_null($activeMenu))
            {
				$template_style_id = 0;
			}
            else {
				$template_style_id = (int) $activeMenu->template_style_id;
			}
            
            if( $template_style_id > 0 )
            {
                Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_templates/tables');
                $style = Table::getInstance('Style', 'TemplatesTable');
                $style->load($template_style_id);

                if( !empty($style->template) ) {
					$this->app->setTemplate($style->template, $style->params);
				}
            }
        }
    }

    public function onContentPrepareForm($form, $data)
    {
		if (!$form instanceof Form)
		{
			$this->subject->setError('JERROR_NOT_A_FORM');

			return false;
		}
		
        $doc 		= Factory::getDocument();
        $plg_path 	= Uri::root(true) . '/plugins/system/helix3';
        Form::addFormPath(JPATH_PLUGINS . '/system/helix3/params');

        //Add Helix menu params to the menu item
        if ($form->getName() == 'com_menus.item')
        { 
            HTMLHelper::_('jquery.framework');
            
            $data = (array)$data;

            if($data['id'] && $data['parent_id'] == 1)
            {
                $doc->addStyleSheet($plg_path . '/assets/css/bootstrap.css');
                $doc->addStyleSheet($plg_path . '/assets/css/font-awesome.min.css');
                $doc->addStyleSheet($plg_path . '/assets/css/modal.css');
                $doc->addStyleSheet($plg_path . '/assets/css/menu.generator.css');
                
                HTMLHelper::_('jquery.framework');
                $doc->addScript($plg_path . '/assets/js/jquery-ui.min.js');
                $doc->addScript($plg_path . '/assets/js/modal.js');
                $doc->addScript($plg_path . '/assets/js/menu.generator.js');
                $form->loadFile('menu-parent', false);
            }
            else
            {
                $form->loadFile('menu-child', false);
            }

            $form->loadFile('page-title', false);
        }

        //Article Post format
        if ($form->getName() == 'com_content.article')
        {
            HTMLHelper::_('jquery.framework');
            $doc->addStyleSheet($plg_path.'/assets/css/font-awesome.min.css');
            $doc->addScript($plg_path.'/assets/js/post-formats.js');

            $tpl_path = JPATH_ROOT . '/templates/' . $this->getTemplateName();

            if(File::exists( $tpl_path . '/post-formats.xml' )) {
                Form::addFormPath($tpl_path);
            } else {
                Form::addFormPath(JPATH_PLUGINS . '/system/helix3/params');
            }

            $form->loadFile('post-formats', false);
        }
    }

    // Live Update system
    public function onExtensionAfterSave($option, $data)
    {
        if ($option == 'com_templates.style' && !empty($data->id))
        {
            $params = new Registry;
            $params->loadString($data->params);

            $email       = $params->get('joomshaper_email');
            $license_key = $params->get('joomshaper_license_key');
            $template = trim($data->template);

            if(!empty($email) and !empty($license_key) )
            {
                $extra_query = 'joomshaper_email=' . urlencode($email);
                $extra_query .='&amp;joomshaper_license_key=' . urlencode($license_key);

                $fields = array(
                    $this->db->quoteName('extra_query') . '=' . $this->db->quote($extra_query),
                    $this->db->quoteName('last_check_timestamp') . '=0'
                );

                $query = $this->db->getQuery(true)
                    ->update($this->db->quoteName('#__update_sites'))
                    ->set($fields)
                    ->where($this->db->quoteName('name').'='.$this->db->quote($template));
                $this->db->setQuery($query);
                $this->db->execute();
            }
        }
    }

    public function onAfterRoute()
    {
        if ( $this->app->isClient('administrator') )
        {
            $user = Factory::getUser();

            if( !in_array( 8, $user->groups ) ){
                return false;
            }

            $option         = $this->app->input->get ( 'option', '' );
            $id             = $this->app->input->get ( 'id', '0', 'INT' );
            $helix3task     = $this->app->input->get ( 'helix3task' ,'' );

            if ( strtolower( $option ) == 'com_templates' && $id && $helix3task == "export" )
            {
               $query = $this->db->getQuery(true);

               $query
                    ->select( '*' )
                    ->from( $this->db->quoteName( '#__template_styles' ) )
                    ->where( $this->db->quoteName( 'id' ) . ' = ' . $this->db->quote( $id ) . ' AND ' . $this->db->quoteName( 'client_id' ) . ' = 0' );

                $db->setQuery( $query );

                $result = $this->db->loadObject();

                header( 'Content-Description: File Transfer' );
                header( 'Content-type: application/txt' );
                header( 'Content-Disposition: attachment; filename="' . $result->template . '_settings_' . date( 'd-m-Y' ) . '.json"' );
                header( 'Content-Transfer-Encoding: binary' );
                header( 'Expires: 0' );
                header( 'Cache-Control: must-revalidate' );
                header( 'Pragma: public' );

                echo $result->params;

                exit;
            }
        }
    }

    private function getTemplateName()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('template')));
        $query->from($db->quoteName('#__template_styles'));
        $query->where($db->quoteName('client_id') . ' = 0');
        $query->where($db->quoteName('home') . ' = 1');
        $db->setQuery($query);

        return $db->loadObject()->template;
    }

    public function onAfterRender__()
    {
        if ($this->app->isClient('administrator'))
        {
  			return;
  		}
          
        $body 	= $this->app->getBody();
  		$preset = Helix3::Preset();
  		$body 	= str_replace('{helix_preset}', $preset, $body);

  		$this->app->setBody($body);
    }
}