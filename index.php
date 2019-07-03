<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>URL Shortener</title>
    </head>
    <body style = "background-color: #66b0ff;">
      <div class = "container">
      <div class = "heading"><h1 style = "margin: 25px;"><center>URL Shortener</center></h1></div>
       <div id = "form"><div class = "jumbotron shadow" style = "margin:25px; background-color:#91c4f7">
        <form action="index.php" name = "lnkshrt" method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return(validate());">
        <div class="form-group">
          <label for="name">Enter URL:</label><span style="color: red !important; display: inline; float: none;">*</span>
          <input type="text" name="url" class="form-control" id="url">
        </div>
        <button type="submit" id = "form-btn" class="btn btn-success">Shorten URL</button>
      </form></div></div>
    <?php include('conn.php');
    if (isset($_POST["url"]))
    {
      $url = $_POST["url"];
      //rand for numbers only and str_shuffle for random chars
      $length = 6;
      $random = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, $length);
      $id = $random;
      $original_length = strlen($url);
      if(strpos($url, 'http://') !== false || strpos($url, 'https://') !== false)
      {
        $stmt = $conn->prepare("INSERT INTO lnkshrt (url, id) VALUES (?, ?)");
        $stmt->bind_param("ss", $url, $id);
        $new_length = strlen('localhost/lnkshrt/'.$id);
      }
      else
      {
        $newurl = 'https://'.$url;
        $stmt = $conn->prepare("INSERT INTO lnkshrt (url, id) VALUES (?, ?)");
        $stmt->bind_param("ss", $newurl, $id);
        $new_length = strlen('localhost/lnkshrt/'.$id);
      }
      $res = $stmt->execute();
      if($res)
      {

      ?>
        <script>
        document.getElementById("form").classList.add("jumbotron");
        document.getElementById("form").classList.add("shadow");
        document.getElementById("form").style.margin = "25px 25px 35px 25px";
        document.getElementById("form").innerHTML = "<h1>Success</h1><hr><p>URL successfully shortened.</p>";
        </script>
        <?php
        echo '<div class = "jumbotron shadow" style = "margin:25px;">';
        echo '
        <h3>Shortened URL</h3>
        <input type="text" value="localhost/lnkshrt/'.$id.'" id="shortURL" readonly>
        <button onclick="copy()">Copy</button>
        ';
        echo '<hr>';
        echo 'Original length: ' .$original_length;
        echo '<br>New length: ' .$new_length;
        echo '</div></div>';
        $stmt->close();
        $conn->close();
        echo '<center><h3><a href = "index.php">Click here to shorten more links</a></h3></center>';
      }
      else
      {
        ?>
        <script>
        document.getElementById("form").classList.add("jumbotron");
        document.getElementById("form").classList.add("shadow");
        document.getElementById("form").style.margin = "25px 25px 35px 25px";
        document.getElementById("form").innerHTML = "<h1>Error</h1><hr><p>The URL could not be shortened, please try again.</p>";
        </script>
        <?php
      }
    }
  ?>
  <div class = "moicredits">
    <center><p class = "lead">Made with <font color = "red">&#x2764;</font> by Priyanshu</p></center>
</div>
  <script src="script.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
