<?php

/**
 * Routes
 *
 * example_routes.php will be loaded in main app/config/routes.php file.
 */
  Croogo::hookRoutes('NodeExtras');

/**
 * Component
 *
 * This plugin's component will be loaded in ALL (*) controllers.
 */
	Croogo::hookComponent('*', 'NodeExtras.NodeNavigation');
	Croogo::hookComponent('Nodes', 'NodeExtras.NodeImage');
	Croogo::hookComponent('Attachments', 'NodeExtras.NodeImage');
	
/**
 * Behavior
 *
 * This plugin's  behavior will be attached whenever Node model is loaded.
 */
 	Croogo::hookBehavior('Node', 'NodeExtras.NodeImage', array());

/**
 * Helper
 *
 * This plugin's helper will be loaded in NodesController.
 */
	Croogo::hookHelper('*', 'NodeExtras.NodeNavigation');
	Croogo::hookHelper('Nodes', 'NodeExtras.NodeImage');
	Croogo::hookHelper('Attachments', 'NodeExtras.NodeImage');
	
/**
 * Admin Menu
 *
 * Add navigation links to the admin menu.
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
 *
 * Image tab addition to add and edit
 */
  Croogo::hookAdminTab('Nodes/admin_add', 'Image', 'NodeExtras.admin_tab_node');
  Croogo::hookAdminTab('Nodes/admin_edit', 'Image', 'NodeExtras.admin_tab_node');