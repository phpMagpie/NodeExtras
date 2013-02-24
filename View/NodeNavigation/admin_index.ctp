<?php $this->extend('/Common/admin_index'); ?>
<?php $this->start('tabs'); ?>
<li><?php echo $this->Html->link(
	__('New Page'), 
	array('plugin' => false, 'controller' => 'nodes', 'action' => 'add', 'page')); ?>
</li>
<?php $this->end('tabs'); ?>

<?php
	if (isset($this->params['named'])) {
		foreach ($this->params['named'] as $nn => $nv) {
			$this->Paginator->options['url'][] = $nn . ':' . $nv;
		}
	}

	echo $this->Form->create('Link', array(
		'url' => array(
			'plugin' => false, 'controller' => 'nodes', 'action' => 'process',
		),
	));
?>

<table cellpadding="0" cellspacing="0">
<?php
	$tableHeaders = $this->Html->tableHeaders(array(
		'',
		__('Id'),
		__('Title'),
		__('Status'),
		__('Actions'),
	));
	echo $tableHeaders;

	$rows = array();
	foreach ($nodesTree as $nodeId => $nodeTitle) {
		$actions  = $this->Html->link(__('Move up'), array('action' => 'moveup', $nodeId));
		$actions .= ' ' . $this->Html->link(__('Move down'), array('action' => 'movedown', $nodeId));
		$actions .= ' ' . $this->Html->link(__('Edit'), array('plugin'=>false, 'controller' => 'nodes', 'action' => 'edit', $nodeId));
		$actions .= ' ' . $this->Layout->adminRowActions($nodeId);
		$actions .= ' ' . $this->Layout->processLink(__('Delete'),
			'#Node' . $nodeId . 'Id',
			null, __('Are you sure?'));

		$rows[] = array(
			$this->Form->checkbox('Node.' . $nodeId . '.id'),
			$nodeId,
			$nodeTitle,
			$this->Layout->status($nodesStatus[$nodeId]),
			$actions,
		);
	}

	echo $this->Html->tableCells($rows);
	echo $tableHeaders;
?>
</table>
<div class="bulk-actions">
<?php
	echo $this->Form->input('Node.action', array(
		'label' => false,
		'options' => array(
			'publish' => __('Publish'),
			'unpublish' => __('Unpublish'),
			'delete' => __('Delete'),
		),
		'empty' => true,
	));
	echo $this->Form->end(__('Submit'));
?>
</div>