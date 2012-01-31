<?php
if (!isset($this->Media) || !is_a($this->Media, 'MediaHelper')) {
	$message = 'Attachments Element - The media helper is not loaded but required.';
	trigger_error($message, E_USER_NOTICE);
	return;
}

if (!isset($previewVersion)) {
	$previewVersion = 's';
}

/* Set $assocAlias and $model if you're using this element multiple times in one form */

if (!isset($assocAlias)) {
	$assocAlias = 'Attachment';
} else {
	$assocAlias = Inflector::singularize($assocAlias);
}

$modelId = $this->Form->value($this->Form->model().'.id');

if (!isset($title)) {
	$title = sprintf(__('%s', true), Inflector::pluralize($assocAlias));
}
?>
<div class="fileupload form">
    画像をアップロード<br />
	<?php if (isset($this->data[$assocAlias][0])): ?>
		<div>
		<?php
			$item = $this->data[$assocAlias][0];

			if ($file = $this->Media->file("{$item['dirname']}/{$item['basename']}")):
				$url = $this->Media->url($file);
				$size = $this->Media->size($file);
				$name = $this->Media->name($file);

				echo $this->Media->embed($this->Media->file("{$previewVersion}/{$item['dirname']}/{$item['basename']}"), array(
					'restrict' => array('image')
				));

				if (isset($this->Number)) {
					$size = $this->Number->toReadableSize($size);
				} else {
					$size .= ' Bytes';
				}

				printf(
					'<span class="description">%s&nbsp;(%s/%s) <em>%s</em></span>',
					$url ? $this->Html->link($item['basename'], $url) : $item['basename'],
					$name,
					$size,
					$item['alternative']
				);
			endif;
		?>
		</div>
	<?php endif ?>
<?php echo $this->Form->create('Upfile', array('type' => 'post', 'url' => array('plugin' => 'media', 'controller' => 'uploaduis', 'action' => 'dataset'))); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->submit('決定', array('name' => 'registry')); ?>
<?php echo $this->Form->submit('削除', array('name' => 'delete')); ?>
<?php echo $this->Form->end();?>
</div>
