<?php

App::uses('AppHelper', 'View/Helper');

/**
 * NodeExtras: NodeImage Helper
 *
 * PHP version 5
 *
 * @category NodeImage.Helper
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodeImageHelper extends AppHelper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	public $helpers = array(
		'Html',
		'Js',
	);

/**
 * selectURL
 *
 * @return string
 */
	public function selectId() {
		$output = <<<EOF
function selectImage(id, url, title, description) {
	if (url == '') return false;
	
	if($('#NodeImageAttachmentId', window.top.opener.document).length == 0) {
	  selectURL(url, title, description);
	}
	
	url = '%s' + url;
	
	$('#NodeImageAttachmentId', window.top.opener.document).val(id);
	$('#NodeImageAttachmentImage', window.top.opener.document).attr('src', url);
	console.log($('#NodeImageAttachmentId', window.top.opener.document).attr('src'));
	window.top.close();
	window.top.opener.parent.focus();
}
EOF;
		$output = sprintf($output, Router::url('/uploads/', true));
		return $output;
	}
	
/**
 * beforeRender
 *
 * @param string $viewFile
 * @return void
 */
	public function beforeRender($viewFile) {
		if ($this->params['controller'] == 'attachments' && $this->params['action'] == 'admin_browse') {
			$this->Html->scriptBlock($this->selectId(), array('inline' => false));
		}
	}
	
/**
 * Output SLIR friendly image path
 *
 * @param string $image standard image path
 * @param array $options (optional)
 * @return string
 */
	public function slir($image, $options = array()) {
	  $path = '/slir/w' . $options['w'] . '-h'. $options['h'] . '-c' . $options['w'] . '.' . $options['h'] . '/webroot';
	  return $this->_View->Html->image($path.$image);
	}
	
}