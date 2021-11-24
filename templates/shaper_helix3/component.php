<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

//Load Helix
$helix3_path = JPATH_PLUGINS . '/system/helix3/core/helix3.php';

if (file_exists($helix3_path))
{
	require_once($helix3_path);
	$this->helix3 = helix3::getInstance();
}
else
{
	die(Text::_('HELIX_PLUGIN_WARNING_NOTICE'));
}
?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            $doc = Factory::getDocument();
            if ($favicon = $this->params->get('favicon'))
            {
                $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
            }
            else
            {
                $doc->addFavicon( $this->baseurl . '/templates/'. $this->template .'/images/favicon.ico' );
            }
        ?>

        <jdoc:include type="head" />

        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/all.min.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/plugins/system/helix3/assets/css/system.j<?php echo Version::MAJOR_VERSION < 4 ? 3 : 4; ?>.min.css">
    </head>
    <body>
        <jdoc:include type="component" />
    </body>
</html>