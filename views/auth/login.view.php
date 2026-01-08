<?php require "views/components/header.php";?>


<?php foreach($errors as $error){ ?>
    <p> <?= $error ?></p>
    <?php };?>
<form  method="POST" action="">
<label for="">Username: </label>  <input name="username" type="text"> <br>
<label for="">Password: </label>  <input name="password" type="text"> <br>
<button>Login</button>
</form>


<?php require "views/components/footer.php";?>