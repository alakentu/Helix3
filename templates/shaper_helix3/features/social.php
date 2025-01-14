<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

class Helix3FeatureSocial {
	
	private $helix3;
	
	public $position;

	public function __construct( $helix3 )
	{
		$this->helix3   = $helix3;
		$this->position = $this->helix3->getParam('social_position');
		$this->load_pos = $this->helix3->getParam('social_load_pos');
	}

	public function renderFeature()
	{
		$facebook   = $this->helix3->getParam('facebook');
		$twitter    = $this->helix3->getParam('twitter');
		$pinterest  = $this->helix3->getParam('pinterest');
		$youtube    = $this->helix3->getParam('youtube');
		$linkedin   = $this->helix3->getParam('linkedin');
		$dribbble   = $this->helix3->getParam('dribbble');
		$behance    = $this->helix3->getParam('behance');
		$skype      = $this->helix3->getParam('skype');
		$whatsapp   = $this->helix3->getParam('whatsapp');
		$instagram  = $this->helix3->getParam('instagram');
		$tiktok  	= $this->helix3->getParam('tiktok');
		$telegram  	= $this->helix3->getParam('telegram');
		$flickr     = $this->helix3->getParam('flickr');
		$vk         = $this->helix3->getParam('vk');
		$custom     = $this->helix3->getParam('custom');

		if( $this->helix3->getParam('show_social_icons') && ( $facebook || $twitter || $pinterest || $youtube || $linkedin || $dribbble || $behance || $skype || $flickr || $vk ) ) {
			$html  = '<ul class="social-icons">';

			if( $facebook ) {
				$html .= '<li><a target="_blank" href="'. $facebook .'" aria-label="facebook"><i class="fa fa-facebook"></i></a></li>';
			}
			if( $twitter ) {
				$html .= '<li><a target="_blank" href="'. $twitter .'" aria-label="twitter"><i class="fa fa-twitter"></i></a></li>';
			}
			if( $pinterest ) {
				$html .= '<li><a target="_blank" href="'. $pinterest .'" aria-label="pinterest"><i class="fa fa-pinterest"></i></a></li>';
			}
			if( $youtube ) {
				$html .= '<li><a target="_blank" href="'. $youtube .'" aria-label="youtube"><i class="fa fa-youtube"></i></a></li>';
			}
			if( $linkedin ) {
				$html .= '<li><a target="_blank" href="'. $linkedin .'" aria-label="linkedin"><i class="fa fa-linkedin"></i></a></li>';
			}
			if( $dribbble ) {
				$html .= '<li><a target="_blank" href="'. $dribbble .'" aria-label="dribbble"><i class="fa fa-dribbble"></i></a></li>';
			}
			if( $behance ) {
				$html .= '<li><a target="_blank" href="'. $behance .'" aria-label="behance"><i class="fa fa-behance"></i></a></li>';
			}
			if( $flickr ) {
				$html .= '<li><a target="_blank" href="'. $flickr .'" aria-label="flickr"><i class="fa fa-flickr"></i></a></li>';
			}
			if( $vk ) {
				$html .= '<li><a target="_blank" href="'. $vk .'" aria-label="vk"><i class="fa fa-vk"></i></a></li>';
			}
			if( $skype ) {
				$html .= '<li><a href="skype:'. $skype .'?chat" aria-label="skype"><i class="fa fa-skype"></i></a></li>';
			}
			if( $whatsapp ) {
				$html .= '<li><a href="whatsapp://send?abid='. $whatsapp .'&text=Hi" aria-label="whatsapp"><i class="fa fa-whatsapp"></i></a></li>';
			}
			if( $instagram ) {
				$html .= '<li><a target="_blank" href="//www.instagram.com/'. $instagram .'" aria-label="instagram"><i class="fa fa-instagram"></i></a></li>';
			}
			if( $tiktok ) {
				$html .= '<li><a target="_blank" href="//tiktok.com/@'. $tiktok .'" aria-label="tiktok"><i class="fa fa-tiktok"></i></a></li>';
			}
			if( $telegram ) {
				$html .= '<li><a target="_blank" href="//t.me/'. $telegram .'" aria-label="telegram"><i class="fab fa-telegram-plane"></i></a></li>';
			}
			if( $custom ) {
				$explt_custom = explode(' ', $custom);
				$html .= '<li><a target="_blank" href="'. $explt_custom[1] .'"><i class="fa '. $explt_custom[0] .'"></i></a></li>';
			}

			$html .= '</ul>';

			return $html;
		}
	}
}