<?php

/**
 * Routes
 */
  Croogo::hookRoutes('NodeExtras');

/**
 * Component
 */
	Croogo::hookComponent('*', 'NodeExtras.NodeNavigation');
	Croogo::hookComponent('Nodes', 'NodeExtras.NodeImage');
	Croogo::hookComponent('Attachments', 'NodeExtras.NodeImage');
	
/**
 * Behavior
 */
 	Croogo::hookBehavior('Node', 'NodeExtras.NodeImage', array());

/**
 * Helper
 */
	Croogo::hookHelper('*', 'NodeExtras.NodeNavigation');
	Croogo::hookHelper('*', 'NodeExtras.NodeImage');
	
/**
 * Admin Menu
 *
 */
 	CroogoNav::add('content.children.list.children.node_extras', array(
    'title' => __('Pages (by tree order)'),
    'url' => array(
 			'plugin' => 'node_extras',
 			'controller' => 'node_navigation',
 			'action' => 'index',
 		),
    'access' => array('admin'),
  ));
  
/**
 * Admin tab
 */
  Croogo::hookAdminTab('Nodes/admin_add', 'Image', 'NodeExtras.admin_tab_node', array('type' => array('blog', 'testimonial')));
  Croogo::hookAdminTab('Nodes/admin_edit', 'Image', 'NodeExtras.admin_tab_node', array('type' => array('blog', 'testimonial')));