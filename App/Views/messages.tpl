<?php foreach ($messages as $message) { ?>
<li class="left clearfix">
  <div class="chat-body clearfix">
  	<div class="header">
  		<strong class="primary-font"><?php echo $message['username']; ?></strong>
    <?php if($message['name_file']) { ?> 
    <button type="button" class="btn btn-default btn-xs pull-right attachment" onclick="showFile(<?php echo $message['file_id']; ?>); return false;">
      <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> <?php echo $message['name_file']; ?>
    </button>
    <?php } ?> 
  	</div>
  	<p>
  		<?php echo $message['message']; ?>
  	</p>
  </div>
</li>
<?php } ?>