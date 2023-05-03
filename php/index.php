<?php
$title="Мои растения";
$mysql = new mysqli("mysql", "root", "qwer", "flower");
$result = $mysql->query("SELECT `id`,`data`,`image`,`content` FROM flower_table");
print("<html lang='ru'>
<head>
    <title>$title</title>
</head>
<body>");
if($result){
    while($row = $result->fetch_assoc()){
        print("<img alt='images' src='images/".$row["image"]."' width='640' height='480'><br>");
        print($row["data"]."||".$row["content"]);
        print("<br>");
    }
}
$mysql->close();
print("
    </body>
</html>
");