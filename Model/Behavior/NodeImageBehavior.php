<?php
App::uses('ModelBehavior', 'Model');

/**
 * NodeExtras: NodeImage Behavior
 *
 * PHP version 5
 *
 * @category Behavior
 * @package  Croogo
 * @author   Paul Gardner <paul@webbedit.co.uk>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodeImageBehavior extends ModelBehavior {

/**
 * Setup
 *
 * @param Model $model
 * @param array $config
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		if (is_string($config)) {
			$config = array($config);
		}
		$this->settings[$model->alias] = $config;
		
		$model->hasOne['NodeImage'] = array(
	    'className' => 'NodeExtras.NodeImage',
	    'foreignKey' => 'node_id',
	    'conditions' => array(),
	    'dependent' => true
	  );
	}

/**
 * afterFind callback
 *
 * @param Model $model
 * @param array $queryData
 * @param boolean $primary
 * @return array
 */
	public function afterFind(Model $model, $results, $primary = false) {
	  foreach ($results as $key => $val) {
      if (isset($val['NodeImage']['attachment_id']) && $val['NodeImage']['attachment_id']) {
        $attachment = $model->NodeImage->Attachment->findById($val['NodeImage']['attachment_id']);
        $results[$key]['NodeImage']['Attachment'] = $attachment['Attachment'];
      } elseif(isset($val['Meta']) && !isset($val['NodeImage'])) {
        $nodeImage = $model->NodeImage->find('first', array(
          'conditions' => array('NodeImage.node_id' => $val['Node']['id']),
          'contain' => array('Attachment'),
        ));
        if(!empty($nodeImage)) {
          $results[$key]['NodeImage'] = $nodeImage['NodeImage'];
          $results[$key]['NodeImage']['Attachment'] = $nodeImage['Attachment'];
        }
      }
    }
    return $results;
	}

}
