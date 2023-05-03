<?php
$hostname="http://localhost";
$title="Мои растения";
$p="";
$mysql = new mysqli("mysql", "root", "qwer", "flower");
print("<html lang='ru'>
<head>
    <title>$title</title>
</head>
<body>");
if (isset($_GET['p'])) {
    $p = strval($_GET['p']);
    if ($p == 'add') {
        print("<a href='$hostname'>home</a><hr>");
        print("<form action='$hostname' method='get'>
                    <p><label for='date'>Дата</label><input type='date' name='date'></p>
                    <p></p><label for='content'>Описание</label><input type='text' name='content'></p>
                    <p><label for='file'>Файл</label><input type='file' name='fname'></p>
                    <input type='hidden' name='p' value='add_content'>   
                    <p><input type='submit' value='Отправить'></p>
                    </form>");
    }
    elseif ($p=='add_content') {
        if (isset($_GET['date'])){
            $date_=strval($_GET['date']);
        }
        if (isset($_GET['content'])){
            $content_=strval($_GET['content']);
        }
        if (isset($_GET['fname'])){
            $fname_=strval($_GET['fname']);
        }
        $mysql->query("INSERT INTO flower_table(`date`, `content`, `image`) VALUES('$date_','$content_','$fname_')");
        print("<a href='$hostname'>home</a>");
    }
    elseif($p=='del') {
        if (isset($_GET['id'])){
            $i_=intval($_GET['id']);
        }
        $mysql->query("SELECT * FROM flower_table");
        $mysql->query("DELETE FROM flower_table WHERE `flower_table`.`id` = $i_");
        print "<script>document.location.href='$hostname';</script>";
    }

} elseif ($p=='') {
    print("<a href='$hostname?p=add'>Добавить</a><hr>");

    $result = $mysql->query("SELECT `id`,`date`,`image`,`content` FROM flower_table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            print("<img alt='images' src='images/" . $row["image"] . "' width='640' height='480'><br>");
            print($row["date"] . "||" . $row["content"]);
            $link=$hostname . '?p=del&id=' . $row["id"];
            print("<a href='$link'>del</a>");
            print("<hr>");
        }
    }
}
$mysql->close();
print("
    </body>
</html>
");