<?php
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit' && isset($_POST['content'])){
    $content = $_POST['content'];
    echo $content;
    require_once 'dbconfig.php';
    require_once 'php_functions.php';
    $sql=	"INSERT INTO news (`date` ,`content`) VALUES (CURRENT_TIMESTAMP ,  '$content')";
    $result=mysql_query($sql) or die(mysql_error());
    mysql_close($link);
    if($result)
    header('Location: ../index.php');
    else
    echo "Error in Insertion!";
}
?>
