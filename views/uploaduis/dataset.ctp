<?php Configure::write('debug', 0); ?>
<?php $image = $this->Media->embed($this->Media->file("s/{$this->data['Attachment'][0]['dirname']}/{$this->data['Attachment'][0]['basename']}"), array(
					'restrict' => array('image')
				));
?>
<?php echo $this->Html->scriptStart(); ?>
$(function() {
    window.opener.$('#PostPicture').val(<?php echo $this->data['Upfile']['id']; ?>);
    window.opener.$("#update").css("display", "block");
    window.opener.$("#image").css("display", "block");
    window.opener.$("#filename").css("display", "block");
    window.opener.$("#delete").css("display", "block");
    window.opener.$("#image").html('<?php echo $image; ?>');
    window.opener.$("#filename").html("<?php echo $this->data['Attachment'][0]['basename']; ?>");
    window.opener.$("#delete").html('<?php echo $this->Html->link(__('delete', true), '#', array('data-skip-pjax' => true)); ?>');
    window.close();
    return false;

});
<?php echo $this->Html->scriptEnd(); ?>