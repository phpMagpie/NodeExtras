<?php

App::uses('NodeExtrasAppModel', 'NodeExtras.Model');

class NodeImage extends NodeExtrasAppModel {
	
/**
 * Model associations: belongsTo
 *
 * @var array
 * @access public
 */
	public $belongsTo = array(
		'Node' => array(
			'className' => 'Node',
			'foreignKey' => 'node_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'Attachment' => array(
			'className' => 'Node',
			'foreignKey' => 'attachment_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
	);

}
