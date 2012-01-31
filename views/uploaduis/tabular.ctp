<?php //echo $this->Pjax->start(array('jquery' => true)); ?>
<?php echo $this->Html->scriptStart(); ?>
$(function(){
    $('#pagination .prev,#pagination .page,#pagination .next').click(function() {
        var url = $(this).attr("href");
       $('#update').load(url);
        return false;
		});
	});
<?php echo $this->Html->scriptEnd(); ?>
<div id="update">
    <div id="pagination">
    	<p>
        	<?php
            	echo $this->Paginator->counter(array(
                	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            	));
        	?>
    	</p>

    	<div class="paging">
    		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
    	 | 	<?php echo $this->Paginator->numbers(array('class'=>'page'));?>
     |
    		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
    	</div>
    </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php __('Actions');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ディレクトリ名', 'dirname');?></th>
			<th><?php echo $this->Paginator->sort('ファイル名', 'basename');?></th>
			<th><?php echo $this->Paginator->sort('公開', 'public');?></th>
			<th><?php echo $this->Paginator->sort('アップロード日時', 'created');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($rows as $data):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
            <?php echo $this->Form->create('Upfile', array('type' => 'post', 'url' => array('plugin' => 'media', 'controller' => 'uploaduis', 'action' => 'dataset'))); ?>
                <?php echo $this->Form->hidden('id', array('value' => $data['Upfile']['id'])); ?>&nbsp;
                <?php echo $this->Form->submit(__('this', true), array('div' => false)); ?>&nbsp;
            <?php echo $this->Form->end(); ?>
        </td>
		<td><?php echo $data['Related']['id']; ?>&nbsp;</td>
		<td><?php echo $data['Related']['dirname']; ?>&nbsp;</td>
		<td><?php echo $data['Related']['basename']; ?>&nbsp;</td>
		<td>
            <?php if ($data['Related']['public']): ?>
                <?php echo __('Public'); ?>
            <?php else: ?>
                <?php echo __('Private'); ?>
            <?php endif; ?>
        </td>
		<td><?php echo $data['Related']['created']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
