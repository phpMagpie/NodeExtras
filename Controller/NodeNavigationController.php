<?php

App::uses('NodeExtrasAppController', 'NodeExtras.Controller');

class NodeNavigationController extends NodeExtrasAppController {
  
/**
 * Name
 *
 * @var string
 * @access public
 */
  public $name = 'NodeNavigation';

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Node');

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Node->Behaviors->attach('Tree', array('scope' => array('Node.type' => 'page')));
	}

/**
 * Admin index
 *
 * @return void
 * @access public
 */
	public function admin_index() {
		$this->set('title_for_layout', __('Content: Pages'));
		
		$this->Node->recursive = 0;
		$nodesTree = $this->Node->generateTreeList(array('Node.type' => 'page'), null, null, '&raquo;&nbsp;&nbsp;');
		$nodesStatus = $this->Node->find('list', array(
			'conditions' => array(
				'Node.type' => 'page',
			),
			'fields' => array(
				'Node.id',
				'Node.status',
			),
		));
		$this->set(compact('nodesTree', 'nodesStatus'));
	}
	
/**
 * Admin moveup
 *
 * @param integer $id
 * @param integer $step
 * @return void
 * @access public
 */
	public function admin_moveup($id, $step = 1) {
		$node = $this->Node->findById($id);
		if (!isset($node['Node']['id'])) {
			$this->Session->setFlash(__('Invalid id for node'), 'default', array('class' => 'error'));
			$this->redirect(array(
				'action' => 'index',
			));
		}
		$this->Node->Behaviors->attach('Tree', array(
			'scope' => array(
				'Node.type' => $node['Node']['type'],
			),
		));
		if ($this->Node->moveUp($id, $step)) {
			$this->Session->setFlash(__('Moved up successfully'), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('Could not move up'), 'default', array('class' => 'error'));
		}
		$this->redirect(array(
			'action' => 'index',
		));
	}

/**
 * Admin movedown
 *
 * @param integer $id
 * @param integer $step
 * @return void
 * @access public
 */
	public function admin_movedown($id, $step = 1) {
		$node = $this->Node->findById($id);
		if (!isset($node['Node']['id'])) {
			$this->Session->setFlash(__('Invalid id for node'), 'default', array('class' => 'error'));
			$this->redirect(array(
				'action' => 'index',
			));
		}
		$this->Node->Behaviors->attach('Tree', array(
			'scope' => array(
				'Node.type' => $node['Node']['type'],
			),
		));
		if ($this->Node->moveDown($id, $step)) {
			$this->Session->setFlash(__('Moved down successfully'), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('Could not move down'), 'default', array('class' => 'error'));
		}
		$this->redirect(array(
			'action' => 'index',
		));
	}
	
/**
 * Archive
 *
 * @return void
 * @access public
 */
	public function archive($month = false) {
		if (!isset($this->request->params['named']['type'])) {
		  if (isset($this->request->params['type'])) {
			  $this->request->params['named']['type'] = $this->request->params['type'];
			} else {
			  $this->request->params['named']['type'] = 'node';
			}
		}
		if (!$month) {
			$month = date('Y-m');
		}

		$this->paginate['Node']['order'] = 'Node.created DESC';
		$this->paginate['Node']['limit'] = Configure::read('Reading.nodes_per_page');
		$this->paginate['Node']['conditions'] = array(
			'Node.status' => 1,
			'Node.created LIKE' => $month.'%',
			'OR' => array(
				'Node.visibility_roles' => '',
				'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
			),
		);
		$this->paginate['Node']['contain'] = array(
			'Meta',
			'Taxonomy' => array(
				'Term',
				'Vocabulary',
			),
			'User',
		);
		if (isset($this->request->params['named']['type'])) {
			$type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
				'conditions' => array(
					'Type.alias' => $this->request->params['named']['type'],
				),
				'cache' => array(
					'name' => 'type_' . $this->request->params['named']['type'],
					'config' => 'nodes_index',
				),
			));
			if (!isset($type['Type']['id'])) {
				$this->Session->setFlash(__('Invalid content type.'), 'default', array('class' => 'error'));
				$this->redirect('/');
			}
			if (isset($type['Params']['nodes_per_page'])) {
				$this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
			}
			$this->paginate['Node']['conditions']['Node.type'] = $type['Type']['alias'];
			$this->set('title_for_layout', $type['Type']['title'].' Archive: '.date('M Y', strtotime($month)));
		}

		if ($this->usePaginationCache) {
			$cacheNamePrefix = 'nodes_archive_' . $month . '_' . $this->Croogo->roleId . '_' . Configure::read('Config.language');
			if (isset($type)) {
				$cacheNamePrefix .= '_' . $type['Type']['alias'];
			}
			$this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->params['named']['page'] : 1;
			$cacheName = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'];
			$cacheNamePaging = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'] . '_paging';
			$cacheConfig = 'nodes_index';
			$nodes = Cache::read($cacheName, $cacheConfig);
			if (!$nodes) {
				$nodes = $this->paginate('Node');
				Cache::write($cacheName, $nodes, $cacheConfig);
				Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
			} else {
				$paging = Cache::read($cacheNamePaging, $cacheConfig);
				$this->request->params['paging'] = $paging;
				$this->helpers[] = 'Paginator';
			}
		} else {
			$nodes = $this->paginate('Node');
		}

		$this->set(compact('type', 'nodes'));
		$this->_viewFallback(array(
			'archive_' . $type['Type']['alias'],
		));
	}
	
/**
 * View Fallback
 *
 * @param mixed $views
 * @return string
 * @access protected
 */
	protected function _viewFallback($views) {
		if (is_string($views)) {
			$views = array($views);
		}
    
		if ($this->theme) {
			$viewPaths = App::path('View');
			foreach ($views as $view) {
				foreach ($viewPaths as $viewPath) {
					$viewPath = $viewPath . 'Themed' . DS . $this->theme . DS . 'Nodes' . DS . $view . $this->ext;
					if (file_exists($viewPath)) {
						return $this->render($viewPath);
					}
				}
			}
		}
	}

}