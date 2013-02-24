<?php

CroogoRouter::connect('/blog/archive/*', array('plugin' => 'node_extras', 'controller' => 'node_extras', 'action' => 'archive', 'type' => 'blog'));
