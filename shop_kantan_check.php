<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['member_login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="shop_list.php">商品一覧へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ろくまる農園</title>
    </head>
    <body>
        <?php
        $code = $_SESSION['member_code'];

        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT name, email, postal1, postal2, address, tel FROM dat_member WHERE code=?';
        $stmt = $dbh -> prepare($sql);
        $data[] = $code;
        $stmt -> execute($data);
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

        $dbh = null;

        if ($okflg == true) {
            echo '<form method="post" action="shop_form_done.php">';
            echo '<input type="hidden" name="onamae" value="'.$onamae.'">';
            echo '<input type="hidden" name="email" value="'.$email.'">';
            echo '<input type="hidden" name="postal1" value="'.$postal1.'">';
            echo '<input type="hidden" name="postal2" value="'.$postal2.'">';
            echo '<input type="hidden" name="address" value="'.$address.'">';
            echo '<input type="hidden" name="tel" value="'.$tel.'">';
            echo '<input type="hidden" name="pass" value="'.$pass.'">';
            echo '<input type="hidden" name="danjo" value="'.$danjo.'">';
            echo '<input type="hidden" name="birth" value="'.$birth.'">';
            echo '<input type="button" onclick="history.back()" value="戻る">';
            echo '<input type="submit" value="OK">';
            echo '</form>';
        } 
        ?>
    </body>
</html>