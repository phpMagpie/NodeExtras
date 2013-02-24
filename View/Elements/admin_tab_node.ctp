<?php

// set attachment_id default to 0 or we get a blackholed auth error
$attachment_id = isset($this->data['NodeImage']['attachment_id']) ? $this->data['NodeImage']['attachment_id'] : 0;

$output = <<<EOF
	window.open('%s', 'browserWindow', 'modal,width=960,height=700,scrollbars=yes');
EOF;
$js = sprintf($output, $this->Html->url(array('plugin' => false, 'controller' => 'attachments', 'action' => 'browse')));
echo $this->Html->link('Select Attachment', "#", array('onclick'=>$js));

echo $this->Form->input('NodeImage.id');
echo $this->Form->input('NodeImage.attachment_id', array('type'=>'hidden', 'value'=>$attachment_id));
// unlock hidden field to prevent blackholed auth/csrf error
$this->Form->unlockField('NodeImage.attachment_id');

if(isset($this->data['NodeImage']['attachment_id']) && $this->data['NodeImage']['attachment_id']) {
  echo '<p>'.$this->Html->image($this->data['NodeImage']['Attachment']['path'], array('id'=>'NodeImageAttachmentImage')).'</p>';
} else {
  echo '<p>'.$this->Html->image('NodeImage.no-image.jpg', array('id'=>'NodeImageAttachmentImage')).'</p>';
}