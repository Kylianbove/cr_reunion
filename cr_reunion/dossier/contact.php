<?php session_start();
if(isset($_POST['captcha'])){
    if($_POST['captcha']==$_SESSION['code']){
        echo "Code correct";
    } else {
        echo "Code incorrect";
    }
}
?>
<form action="contact.php" method="post">
    <input type="text" name="captcha"/>
    <input type="submit"/>
    <img src="image.php" onclick="this.src='image.php?' + Math.random();" alt="captcha" style="cursor:pointer;">
</form>
