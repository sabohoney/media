<?php
/**
 * Attachment Model File
 *
 * Copyright (c) 2007-2011 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @package    media
 * @subpackage media.models
 * @copyright  2007-2011 David Persson <davidpersson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link       http://github.com/davidpersson/media
 */

/**
 * Attachment Model Class
 *
 * A ready-to-use model combining multiple behaviors.
 *
 * @package    media
 * @subpackage media.models
 */
class Related extends MediaAppModel {

/**
 * Name of model
 *
 * @var string
 * @access public
 */
	var $name = 'Related';

/**
 * Name of table to use
 *
 * @var mixed
 * @access public
 */
	var $useTable = 'attachments';

	var $belongsTo = array(
		'Upfile' => array(
			'className' => 'Upfile',
			'foreignKey' => 'foreign_key',
		),
	);
}
