<ul class="node-archive">
<?php 
  foreach($archive AS $link) {
    $options = array();
    if($this->params['action'] == 'archive' && isset($this->params[0])) {
      if($link['month'] == $this->params[0]) {
        $options['class'] = 'active';
      }
    }
    $link = $this->Html->link(
      $this->Time->format('F Y', $link['month'].'-01') . ' ('.$link['count'].')', 
      array('plugin'=>'node_extras', 'controller'=>'node_navigation', 'action'=>'archive', 'type'=>'blog', $link['month']),
      $options
    );
    
    echo $this->Html->tag('li', $link, $options);
  }
?>
</ul>
