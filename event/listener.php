<?php
/**
 * 
 * Parse BBCode in Custom Profile Fields
 * 
 * @copyright (c) 2015 Sequor ( http://autus.dekoryn.com/ )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Kaelyn Burns (Sequor)
 */

namespace sequor\cpfbbcode\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor of event listener
	 *
	 * @param \phpbb\path_helper					$path_helper	phpBB path helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 */
	public function __construct(\phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		global $phpbb_container;

		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;

		$this->ext_root_path = 'ext/sequor/cpfbbcode';

		// Add language vars
		$this->user->add_lang_ext('sequor/cpfbbcode', 'cpfbbcode');
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'				=> 'assign_template_vars',
		);
	}

	/**
	 * Assigns template vars
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function assign_template_vars()
	{
		$this->template->assign_vars(array(
			'T_EXT_CPFBBCODE_PATH'			=> $this->path_helper->get_web_root_path() . $this->ext_root_path,
			'T_EXT_CPFBBCODE_THEME_PATH'		=> $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme',
		));
	}
}
