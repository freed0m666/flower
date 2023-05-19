<?php
$hostname="http://localhost";
$title="Мои растения";
$date_="";
$content_="";
$fname_="";
$p="";
$mysql = new mysqli("mysql", "root", "qwer", "flower");
print("<html lang='ru'>
<head>
    <title>$title</title>
</head>
<body>");
if (isset($_POST['p'])) {
    $p = strval($_POST['p']);
    if ($p == 'add') {
        print("<a href='$hostname'>home</a><hr>");
        print("<form enctype='multipart/form-data' action='$hostname' method='POST'>
                    <p><label for='date'>Дата</label><input type='date' name='date'></p>
                    <p></p><label for='content'>Описание</label><input type='text' name='content'></p>
                    <p><label for='file'>Файл</label><input type='file' name='fname'></p>
                    <input type='hidden' name='p' value='add_content'>   
                    <p><input type='submit' value='Отправить'></p>
                    </form>");
    }
    elseif ($p=='add_content') {
        if (isset($_POST['date'])){
            $date_=strval($_POST['date']);
        }
        if (isset($_POST['content'])){
            $content_=strval($_POST['content']);
        }
        if (isset($_POST['fname'])){
            $fname_=strval($_POST['fname']);
        }
        //add file
        $uploaddir = '/var/www/html/images/';
        $uploadfile = $uploaddir . basename($_FILES['fname']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['fname']['tmp_name'], $uploadfile)) {
            echo "Файл корректен и был успешно загружен.\n";
        } else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }

        echo 'Некоторая отладочная информация:';
        print_r($_FILES);

        print "</pre>";

        //add base
        $mysql->query("INSERT INTO flower_table(`date`, `content`, `image`) VALUES('$date_','$content_','$fname_')");
        print("<a href='$hostname'>home</a>");
    }
    elseif($p=='del') {
        $i_=0;
        if (isset($_GET['id'])){
            $i_=intval($_GET['id']);
        }
        $mysql->query("SELECT * FROM flower_table");
        $mysql->query("DELETE FROM flower_table WHERE `flower_table`.`id` = $i_");
        print "<script>document.location.href='$hostname';</script>";
    }

} else {
    print("<form name='form1' action='$hostname' method='post'>
            <input type='hidden' name='p' value='add'>
            <a href='javascript:void(0)' OnClick='document.form1.submit();'>Добавить</a>
            </form>");
    $result = $mysql->query("SELECT `id`,`date`,`image`,`content` FROM flower_table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            print("<img alt='images' src='images/" . $row["image"] . "' width='640' height='480'><br>");
            print($row["date"] . "||" . $row["content"]);
            $link = $hostname . '?p=del&id=' . $row["id"];
            print("<a href='$link'>del</a>");
            print("<hr><p>");
        }
    }
}
$mysql->close();
phpinfo();
print("
</body>
</html>
");