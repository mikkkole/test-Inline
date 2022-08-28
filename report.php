<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Результат поиска</title>
 </head>
 <body>
  <h1>Результат поиска записей по тексту комментария</h1>
 </body>

<?php
  $dbConnect = mysqli_connect('localhost', 'root', 'root', 'testInlane');

  if ($dbConnect == false){
    print("Ошибка подключения к БД: " . mysqli_connect_error());
  } else {

    $searchString = mysqli_real_escape_string($dbConnect, $_POST['searchString']);

    if (strlen($searchString) < 3) {
      exit('Необходимо ввести минимум три символа.');
    }

    $query = "SELECT postId, posts.title, comments.body FROM comments LEFT JOIN posts ON (comments.postId = posts.id) WHERE LOCATE('$searchString', comments.body) ORDER BY postId";

    $result = mysqli_query ($dbConnect, $query);

    if (mysqli_num_rows($result) !== 0) {
      $title = '';

      for ($i=0; $i<mysqli_num_rows($result); $i++) {
        $row=mysqli_fetch_assoc($result);
        if ($row['title'] == $title) {
          echo '<u>' . $row['body'] . '</u><br>';
        } else {
          echo '<br> Для записи с заголовком: <b>' . $row['title'] . '</b> найдены комментарии:<br><u>' . $row['body'] . '</u><br>';
          $title = $row['title'];
        }
      }
    } else {
      echo 'Ничего не найдено по запросу: ' . $searchString;
    }



    mysqli_close($dbConnect);

  }

?>

</body>
</html>
