<?php
App::uses('AppHelper', 'View/Helper');

/**
 * NodeExtras: NodeNavigation Helper
 *
 * @category Helper
 * @package  Croogo
 * @version  1.0
 * @author   Paul Gardner <paul@webbedit.co.uk>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.webbedit.co.uk
 */
class NodeNavigationHelper extends AppHelper {

/**
 * breadcrumbs
 *
 * @param array $path
 * @return string
 */
	public function breadcrumbs($path = array()) {
  	foreach($path AS $node) {
  	  $this->_View->Html->addCrumb($node['Node']['title'], $this->_View->Html->url(array(
  	    'controller'=>'nodes',
  	    'action'=>'view',
  	    'slug'=>$node['Node']['slug'],
  	    'type'=>$node['Node']['type'],
  	  )));
  	}
	  return $this->_View->element('NodeExtras.breadcrumbs');
	}
		
/**
 * childmenu
 *
 * @param array $children
 * @return string
 */
	public function childmenu($children = array()) {
	
	}
	
/**
 * submenu
 *
 * @param array $submenu
 * @return string
 */
	public function submenu($submenu = array()) {
  	if($submenu['parentId'] && !empty($submenu['links'])) {
  	  if($submenu['parentId'] != $this->_View->Layout->node('id')) {
  	    return $this->_View->element('NodeExtras.submenu', array('links'=>$submenu['links']));
  	  }
  	}
	  return false;
	}
	
/**
 * NodeArchive by type
 *
 * @param string $typeAlias Type alias
 * @param array $options (optional)
 * @return string
 */
	public function nodeArchive($type, $options = array()) {
		if (!isset($this->_View->viewVars['nodeArchives_for_layout'][$type])) {
			return false;
		}
		$slider = $this->_View->viewVars['nodeArchives_for_layout'][$type];
	
		$_options = array(
			'element' => 'node_archive',
			'tag' => 'div',
			'attributes' => array(),
			'id' => 'node-archive-' . $type,
		);
		$options = array_merge($_options, $options);
		
		$output = $this->_View->element(
			$options['element'], 
			array(
				'archive' => $this->_View->viewVars['nodeArchives_for_layout'][$type],
				'options' => $options,
			), 
			array(
				'plugin' => 'NodeExtras'
			)
		);
		return $output;
	}
  
}