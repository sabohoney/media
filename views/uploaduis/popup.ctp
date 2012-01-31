<div id="tabs">
<ul>
    <li><a href="#tabs-1">PCからアップロード</a></li>
    <li><a href="#tabs-2">サーバ参照</a></li>
</ul>
<div id="tabs-1">
    <div class="fileupload form">
    <?php echo $this->Form->create('Upfile', array('type' => 'file', 'url' => array('plugin' => 'media', 'controller' => 'uploaduis', 'action' => 'upload'))); ?>
    	<fieldset>
            画像をアップロード<br />
            <?php echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Upfile')); ?>  
    	</fieldset>
    <?php echo $this->Form->end(__('Submit', true));?>
    </div>
</div>
<div id="tabs-2">
    <?php echo $this->Ajax->form(array(
        'type' => 'post',
        'options' => array(
            'model' => 'Related',
            'update' => 'result',
            'url' => array(
                'plugin' => 'media',
                'controller' => 'uploaduis',
                'action' => 'search',
            ),
            'indicator' => 'loading',
        )
    )); ?>
    <?php //echo $this->Form->create('Related', array('type' => 'post', 'url' => array('plugin' => 'media', 'controller' => 'uploaduis', 'action' => 'search'))); ?>
        <?php echo $this->Form->text('basename'); ?><br />
        <ul style="list-style:none">
            <li style="float:left;"><?php echo $this->Form->radio('viewstatus', array(1 => '表形式', 2 => 'サムネイル形式'), array('legend' => false, 'value' => 1, 'separator' => '</li><li style="float:left">')); ?>
        </ul>
    <?php echo $this->Form->end(__('search', true)); ?>
    <div id="result">
    </div>
</div>
<?php echo $this->Ajax->tabs('tabs'); ?>
