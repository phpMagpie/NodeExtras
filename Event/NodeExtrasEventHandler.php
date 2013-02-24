<?php
/**
 * NodeExtras Event Handler
 *
 * PHP version 5
 *
 * @category Event
 * @package  Croogo
 * @version  1.0
 * @author   Paul Gardner <paul@webbedit.co.uk>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.webbedit.co.uk
 */
class NodeExtrasEventHandler extends Object implements CakeEventListener {

/**
 * Event view
 *
 * @var array
 * @access public
 */
	public $view = null;

/**
 * implementedEvents
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Helper.Layout.afterFilter' => array(
				'callable' => 'onLayoutAfterFilter',
			),
		);
	}

/**
 * onLayoutAfterFilter
 *
 * @param CakeEvent $event
 * @return void
 */
	public function onLayoutAfterFilter($event) {
		$this->view = $event->subject(); // is there a better way to do this?
		$event->data['content'] = $this->filterNodeArchives($event->data['content']);
	}
	
/**
 * Filter content for NodeArchives
 *
 * Replaces [nodeArchive:content_type_alias] or [na:content_type_alias] with NodeTypeArchive
 *
 * @param string $content
 * @return string
 */
	public function filterNodeArchives($content) {
		preg_match_all('/\[(nodeArchive|na):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
		for ($i = 0, $ii = count($tagMatches[1]); $i < $ii; $i++) {
			$regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
			preg_match_all($regex, $tagMatches[3][$i], $attributes);
			$alias = $tagMatches[2][$i];
			$options = array();
			for ($j = 0, $jj = count($attributes[0]); $j < $jj; $j++) {
				$options[$attributes[1][$j]] = $attributes[2][$j];
			}
			$content = str_replace($tagMatches[0][$i], $this->nodeArchive($alias, $options), $content);
		}
		return $content;
	}
		
	/**
	 * NodeArchive by Content Type
	 *
	 * @param string $alias Content Type alias
	 * @param array $options (optional)
	 * @return string
	 */
		public function nodeArchive($alias, $options = array()) {
			if (!isset($this->view->viewVars['nodeArchives_for_layout'][$alias])) {
				return false;
			}
			$slider = $this->view->viewVars['nodeArchives_for_layout'][$alias];
		
			$_options = array(
				'element' => 'node_archive',
				'tag' => 'div',
				'attributes' => array(),
				'id' => 'node-archive-' . $alias,
			);
			$options = array_merge($_options, $options);
			
			$output = $this->view->element(
				$options['element'], 
				array(
					'archive' => $this->view->viewVars['nodeArchives_for_layout'][$alias],
					'options' => $options,
				), 
				array(
					'plugin' => 'NodeExtras'
				)
			);
			return $output;
		}

}
