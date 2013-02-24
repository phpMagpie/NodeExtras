<ul class="sub_nav right clearfix">
<?php 
  foreach($links AS $link) {
    $options = array();
    if($link['Node']['id'] == $this->Layout->node('id')) {
      $options['class'] = 'active';
    }
    $link = $this->Html->link($link['Node']['title'], '/page/' . $link['Node']['slug'], $options);
    echo $this->Html->tag('li', $link, $options);
  }
?>
</ul>