<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['member_login']) == false) {
    echo 'ようこそゲスト様'.'　'.'<a href="member_login.html">会員ログイン</a>'.'<br><br>';
} else {
    echo 'ようこそ'.$_SESSION['member_name'].'様'.'　';
    echo '<a href="member_logout.php">ログアウト</a>'.'<br><br>';
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
    try {
        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT code, name, price FROM mst_product WHERE 1';
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

        $dbh = null;

        print '商品一覧<br /><br />';

        while (true) {
            $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
            if ($rec == false) {
                break;
            } else {
                print '<a href="shop_product.php?procode='.$rec['code'].'">';
                print $rec['name'].'---';
                print $rec['price'].'円'.'<br>';
                print '</a>';
            }
        }

        echo '<br>'.'<a href="shop_cartlook.php">カートを見る</a>'.'<br>';
    }
    catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしておりますstaff_list.php';
        exit();
    }
    ?>
  </body>
</html>