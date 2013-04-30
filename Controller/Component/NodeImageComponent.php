<?php

App::uses('Component', 'Controller');

/**
 * NodeExtras: NodeImage Component
 *
 * @category Component
 * @package  Croogo
 * @version  1.0
 * @author   Paul Gardner <paul@webbedit.co.uk>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.webbedit.co.uk
 */
class NodeImageComponent extends Component {
  
/**
 * Enabled
 *
 * @var boolean
 * @access public
 */
  public $enabled = true;
  
/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}
  	
/**
 * beforeRender
 *
 * @param string $viewFile
 * @return void
 */
	public function beforeRender(Controller $controller) {
		if ($controller->request->params['controller'] == 'attachments' && $controller->request->params['action'] == 'admin_browse') {
		  $controller->view = "NodeExtras.Elements/admin_browse";
		}
	}
  
}
