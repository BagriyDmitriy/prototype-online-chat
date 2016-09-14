<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Phone book</title>
  </head>
  <body>
    <div class="container bootstrap snippet">
      <div class="row">
  	    <div class="col-md-10 bg-white ">
          <div class="chat-message">
            <div class="panel-heading">
              <div class="panel-control">
                <button class="btn btn-default <?php echo !isset($user_id) ? 'hide' : ''; ?>" type="button" id="logout_btn">Logout <span class="glyphicon glyphicon-off" aria-hidden="true"></span></button>
              </div>
              <h2 class="panel-title">Chat</h2>
            </div>
            <hr>
            <input type="hidden" id="last_id" value="<?php echo end($messages)['id']; ?>">
            <ul class="chat" id="chat">
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
            </ul>
          </div>
          <div id="block"></div>
	      </div>        
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="modal-body" id="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="js/application.js" type="text/javascript"></script>
  </body>
</html>