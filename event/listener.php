<?php

/**
*
* Remove attachment extension extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace rmcgirr83\removeextension\event;

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.parse_attachments_modify_template_data'	=> 'parse_attachments_modify_template_data',
		);
	}

	public function parse_attachments_modify_template_data($event)
	{
		$attachment = $event['attachment'];
		$block_array = $event['block_array'];

		$block_array['DOWNLOAD_NAME'] = $this->strip_file_extension($attachment['real_filename']);
		$event['block_array'] = $block_array;
	}

	/**
	* Remove only the final extension from a file name
	*
	* "annual.report.pdf" becomes "annual.report". Names without an
	* extension, or with only a leading dot (".htaccess"), are returned
	* unchanged so the displayed name is never empty.
	*
	* @param string $filename	The attachment's real file name
	* @return string			The file name without its last extension
	*/
	public function strip_file_extension($filename)
	{
		$last_dot = strrpos($filename, '.');

		return ($last_dot > 0) ? substr($filename, 0, $last_dot) : $filename;
	}
}
