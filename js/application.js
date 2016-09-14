//Login
function login(obj) {
  var username = obj.elements.username.value;
  var password = obj.elements.password.value;

  if (username == '' || password == '') {
    alert('Inputs must not be empty');
  } else {
      var r = new XMLHttpRequest();

      r.open('POST', 'index.php?route=user/login', true);
      r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      r.onreadystatechange = function () {
        if (r.readyState != 4 || r.status != 200) return;
          var json = JSON.parse(r.responseText);
          if (json.status) {
            location.reload();
          } else {
            alert('User not registered or password invalid');
          }
      };

      r.send('password=' + password + '&username=' + username);
  }
}

//Register
function register(obj) {
  var username = obj.elements.username.value;
  var password = obj.elements.password.value;
  var email = obj.elements.email.value;

  if (username == '' || password == '' || email == '') {
    alert('Username, email and password must not be empty');
  } else {
      var r = new XMLHttpRequest();

      r.open('POST', 'index.php?route=user/register', true);

      r.onreadystatechange = function () {
        if (r.readyState != 4 || r.status != 200) return;
          document.getElementById('block').innerHTML = r.responseText;
          document.getElementById('logout_btn').classList.remove('hide');
      };

      r.send(new FormData(obj));
  }
}

//Load Messages
function loadMessages(last_id) {
  var r = new XMLHttpRequest();

  r.open('POST', 'index.php?route=user/loadmessages', true);
  r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  r.onreadystatechange = function () {
    if (r.readyState != 4 || r.status != 200) return;
        var json = JSON.parse(r.responseText);
        if (json.status) {
          var div = document.createElement('div');

          div.innerHTML = json.content;

          document.getElementById('chat').appendChild(div);
          
          var chat = document.getElementById('chat');
          
          chat.scrollTop = chat.scrollHeight;

          document.getElementById('last_id').value =  json.last_id;
        }
  };

  r.send('last_id=' + last_id);
}

//send Message
function sendMessage(obj) {
  var message = obj.elements.message.value;

  if (message == '') {
    alert('Message must not be empty');
  } else {
      var r = new XMLHttpRequest();

      r.open('POST', 'index.php?route=user/savemessage', true);

      r.onreadystatechange = function () {
        if (r.readyState != 4 || r.status != 200) return;
          var json = JSON.parse(r.responseText);
          if (json.status) {
            document.getElementById('upload-file-info').innerHTML = '';
            document.getElementById('message-input').value = '';
            document.getElementById('message_file').value = '';
          } else {
            document.getElementById('block').innerHTML = json.content;
          }
      };

      r.send(new FormData(obj));
  }
}

//show attached file
function showFile(id) {
  var r = new XMLHttpRequest();

  r.open('POST', 'index.php?route=user/showfile', true);
  r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  r.onreadystatechange = function () {
    if (r.readyState != 4 || r.status != 200) return;
      var json = JSON.parse(r.responseText);
      
      if (json.status) {
        document.getElementById('myModalLabel').innerHTML = json.file_name;
        document.getElementById('modal-body').innerHTML = json.txt_file;
        
        $('#myModal').modal('show')
      } else {
        alert('File load error');
      }
  };

  r.send('id=' + id);
}

//Show register form
function showRegisterForm() {
  var r = new XMLHttpRequest();

  r.open('GET', 'index.php?route=user/register', true);

  r.onreadystatechange = function () {
    if (r.readyState != 4 || r.status != 200) return;
      document.getElementById('block').innerHTML = r.responseText;
  };

  r.send();
}

function showForm() {
    //Load chat/login form
    var r = new XMLHttpRequest();

    r.open('GET', 'index.php?route=user/form', true);

    r.onreadystatechange = function () {
      if (r.readyState != 4 || r.status != 200) return;
        document.getElementById('block').innerHTML = r.responseText;
    };

    r.send();
}

document.onreadystatechange = function () {
  if (document.readyState == 'complete') {

    showForm();

    //scroll down chat
    var chat = document.getElementById('chat');
    
    chat.scrollTop = chat.scrollHeight;

    //update chat
    setInterval(function() {
      loadMessages(document.getElementById('last_id').value);
    }, 2000);

    //Load login form
    if (document.getElementById('login_btn')) {
      document.getElementById('login_btn').onclick = function() {
        var r = new XMLHttpRequest();

        r.open('GET', 'index.php?route=user/login', true);

        r.onreadystatechange = function () {
          if (r.readyState != 4 || r.status != 200) return;
            document.getElementById('block').innerHTML = r.responseText;
        };

        r.send();
      };
    }

    //Logout
    if (document.getElementById('logout_btn')) {
      document.getElementById('logout_btn').onclick = function() {
        var r = new XMLHttpRequest();

        r.open('GET', 'index.php?route=user/logout', true);

        r.onreadystatechange = function () {
          if (r.readyState != 4 || r.status != 200) return;
            location.reload();
        };

        r.send();
      };
    }
  }
}