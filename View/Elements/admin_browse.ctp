<div class="attachments index">
	<h2><?php echo $title_for_layout; ?></h2>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attachment'), array('action' => 'add', 'editor' => 1)); ?></li>
		</ul>
	</div>

	<table cellpadding="0" cellspacing="0">
	<?php
		$tableHeaders = $this->Html->tableHeaders(array(
			$this->Paginator->sort('id'),
			'&nbsp;',
			$this->Paginator->sort('title'),
			'&nbsp;',
			__('URL'),
			__('Actions'),
		));
		echo $tableHeaders;

		$rows = array();
		foreach ($attachments as $attachment) {
			$actions  = $this->Html->link(__('Edit'), array(
				'controller' => 'attachments',
				'action' => 'edit',
				$attachment['Node']['id'],
			));
			$actions .= ' ' . $this->Form->postLink(__('Delete'), array(
				'controller' => 'attachments',
				'action' => 'delete',
				$attachment['Node']['id'],
			), null, __('Are you sure?'));

			$mimeType = explode('/', $attachment['Node']['mime_type']);
			$mimeType = $mimeType['0'];
			if ($mimeType == 'image') {
				$thumbnail = $this->Html->link($this->Image->resize($attachment['Node']['path'], 100, 200), '#', array(
					'onclick' => "selectImage('" . $attachment['Node']['id'] . "', '" . $attachment['Node']['slug'] . "', '" . $attachment['Node']['title'] . "', '" . $attachment['Node']['excerpt'] . "');",
					'escape' => false,
				));
			} else {
				$thumbnail = $this->Html->image('/img/icons/page_white.png') . ' ' . $attachment['Node']['mime_type'] . ' (' . $this->Filemanager->filename2ext($attachment['Node']['slug']) . ')';
				$thumbnail = $this->Html->link($thumbnail, '#', array(
					'onclick' => "selectImage('" . $attachment['Node']['id'] . "', '" . $attachment['Node']['slug'] . "', '" . $attachment['Node']['title'] . "', '" . $attachment['Node']['excerpt'] . "');",
					'escape' => false,
				));
			}

			$insertCode = $this->Html->link(__('Insert'), '#', array('onclick' => 'selectImage("' . $attachment['Node']['id'] . '", "' . $attachment['Node']['slug'] . '", "' . $attachment['Node']['title'] . '", "' . $attachment['Node']['excerpt'] . '" );'));

			$rows[] = array(
				$attachment['Node']['id'],
				$thumbnail,
				$attachment['Node']['title'],
				$insertCode,
				$this->Html->link($this->Text->truncate(Router::url($attachment['Node']['path'], true), 20), $attachment['Node']['path']),
				$actions,
			);
		}

		echo $this->Html->tableCells($rows);
		echo $tableHeaders;
	?>
	</table>
</div>

<div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>

<tr>
<td>20</td> 
<td><a href="#" onclick="selectURL('20', 'washer.jpg', 'washer', '');"><img src="/uploads/resized/100x100_washer.jpg" alt="thumb" /></a></td> 
<td>washer</td> 
<td><a href="#" onclick="selectImage(&quot;20&quot;, &quot;washer.jpg&quot;, &quot;washer&quot;, &quot;&quot; );">Insert</a></td> 
<td><a href="/uploads/washer.jpg">http://dev.electr...</a></td> <td><a href="/admin/attachments/edit/20">Edit</a> <form action="/admin/attachments/delete/20" name="post_5125fb460fd90" id="post_5125fb460fd90" style="display:none;" method="post"><input type="hidden" name="_method" value="POST"/><input type="hidden" name="data[_Token][key]" value="72a591f861aeb2f25460a98a81c65dc96b039174" id="Token1152869111"/><div style="display:none;"><input type="hidden" name="data[_Token][fields]" value="f6904038a9f78c4ec825ef05d2d91a0827006127%3A" id="TokenFields659814401"/><input type="hidden" name="data[_Token][unlocked]" value="" id="TokenUnlocked1629533505"/></div></form><a href="#" onclick="if (confirm(&#039;Are you sure?&#039;)) { document.post_5125fb460fd90.submit(); } event.returnValue = false; return false;">Delete</a></td></tr>
