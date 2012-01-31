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

?>
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
	<?php
	$i = 0;
	foreach ($rows as $data):
	?>
	<?php if (($i % 5) == 0) echo "<tr>"; ?>
        <?php if (isset($data[$assocAlias])): ?>
    		<td>
    		<?php
    			$item = $data[$assocAlias];

    			if ($file = $this->Media->file("{$item['dirname']}/{$item['basename']}")):
    				$url = $this->Media->url($file);
    				$size = $this->Media->size($file);
    				$name = $this->Media->name($file);

                    echo $ajax->link(
                        $this->Media->embed(
                            $this->Media->file(
                                "{$previewVersion}/{$item['dirname']}/{$item['basename']}"
                            ),
                            array(
    					        'restrict' => array('image')
				            )
                        ),
                        array(
                            'plugin' => 'media',
                            'controller' => 'uploaduis',
                            'action' => 'dataset',
                        ),
                        array(
                            'update' => 'container',
                            /*'confirm' => __('Is it all right at the file here?', true),*/
                            'data' => $js->object(array(
                                'data' => array(
                                    'Upfile' => array(
                                        'id' => $data['Upfile']['id'],
                                    ),
                                ),
                            )),
                            'escape' => false,
                        )
                    );

    				if (isset($this->Number)):
    					$size = $this->Number->toReadableSize($size);
    				else:
    					$size .= ' Bytes';
    				endif;
    			endif;
    		?>
    		</td>
        <?php endif; ?>
	<?php if (($i % 5) == 0) echo "</tr>"; ?>
    <?php $i++; ?>
    <?php endforeach; ?>
	</table>
</div>
