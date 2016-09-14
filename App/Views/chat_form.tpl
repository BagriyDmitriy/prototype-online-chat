<div class="chat-box bg-white">
  <form onsubmit="sendMessage(this); return false;">
  	<div class="input-group form-group">
  		<input class="form-control border no-shadow no-rounded" name="message" id="message-input" placeholder="Type your message here" value="<?php echo isset($message) ? $message : ''; ?>">
  		<span class="input-group-btn">
  			<button type="submit" class="btn btn-success no-rounded" type="button">Send</button>
  		</span>
    	<?php if(isset($error['message'])) { ?>
    	  <div class="alert alert-warning" role="alert">The message is not filled</div>
      <?php } ?>
  	</div>
    <div class="form-group">
      <label class="btn btn-default" for="message_file">Add txt file</label>
      <input type="file" id="message_file" name="message_file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
      <span class='label label-info' id="upload-file-info"></span>
      <?php if(isset($error['message_file'])) { ?>
        <div class="alert alert-warning" role="alert">File is more then 100Kb</div>
      <?php } ?>
    </div>
	</form>
</div>