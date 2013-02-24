<?php

App::uses('Component', 'Controller');

/**
 * NodeExtras: NodeNavigation Component
 *
 * @category Component
 * @package  Croogo
 * @version  1.0
 * @author   Paul Gardner <paul@webbedit.co.uk>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.webbedit.co.uk
 */
class NodeNavigationComponent extends Component {
  
/**
 * Enabled
 *
 * @var boolean
 * @access public
 */
  public $enabled = true;
    
/**
 * Components
 *
 * @var array
 * @access public
 */
  public $components = array('Croogo');
   
/**
* Blocks data: contains parsed value of bb-code like strings
*
* @var array
* @access public
*/
 	public $blocksData = array(
 		'nodeArchives' => array(),
 	);
 	  
/**
 * nodeArchives for layout
 *
 * @var string
 * @access public
 */
  public $nodeArchives_for_layout = array();

/**
 * Startup
 *
 * @param object $controller instance of controller
 * @return void
 */
  public function startup(&$controller) {
    $this->controller = $controller;
    if (!isset($this->controller->params['admin']) && !isset($this->controller->params['requested']) && $this->enabled) {
      $this->processBlocksData($this->Croogo->blocks_for_layout);
      $this->nodeArchives();
    }
  }

/**
 * beforeRender
 *
 * @param object $controller instance of controller
 * @return void
 */
  public function beforeRender(&$controller) {
    $this->controller = $controller;
    $this->controller->set(array(
      'nodeNavigation' => $this->nodeNavigation(),
      'nodeArchives_for_layout' => $this->nodeArchives_for_layout,
    ));
  }
  
/**
 * nodeNavigation
 *
 * @param object $controller instance of controller
 * @return void
 */
  public function nodeNavigation() {
    $output = array();
    if($this->controller->request->action == 'view') {
      $submenuParentId = false;
      $submenu = array();
      
      $nodeId = $this->controller->Node->field('id', array('slug'=>$this->controller->request->slug));
      $path = $this->controller->Node->getPath($nodeId, array('id', 'title', 'slug', 'type'));
      $children = $this->controller->Node->children($nodeId, true);
      if(!empty($path) && count($path) > 1) {
        $submenuParentId = $path[1]['Node']['id'];
        if($nodeId == $submenuParentId) {
          $submenu = $children;
        } else {
          $submenu = $this->controller->Node->children($submenuParentId, true);
        }
      }
      
      $output = array(
        'path' => $path,
        'children' => $children,
        'submenu' => array(
          'parentId' => $submenuParentId,
          'links' => $submenu
        )
      );
    }
    return $output;
  }
    
/**
 * nodeArchives
 *
 * @param object $controller instance of controller
 * @return void
 */
  public function nodeArchives() {
    $output = array();
    $archive = $this->controller->Node->find('all', array(
      'fields' => array("Node.type, DATE_FORMAT(Node.created, '%Y-%m') AS month", "COUNT(Node.id) AS count"),
      'conditions' => array('Node.type !=' => 'attachment'),
      'group' => array('Node.type, month'),
      'order' => array('Node.type, month'),
      'recursive' => -1
    ));
    foreach($archive AS $typeMonth) {
      $this->nodeArchives_for_layout[$typeMonth['Node']['type']][] = $typeMonth[0];
    }
    return $output;
  }
  
/**
 * Process blocks for bb-code like strings
 * Modified version of CroogoComponent::processBlocksData()
 *
 * @param array $regions (CroogoComponent::blocks_for_layout)
 * @return void
 */
	public function processBlocksData($regions) {
		foreach ($regions as $blocks) {
			foreach ($blocks as $block) {
				$this->blocksData['nodeArchives'] = Set::merge(
					$this->blocksData['nodeArchives'], 
					$this->Croogo->parseString('nodeArchive|na', $block['Block']['body'])
				);
			}
		}
	}
    
}