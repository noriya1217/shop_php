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
        $pro_code = $_GET['procode'];

        if (isset($_SESSION['cart']) == true) {
            $cart = $_SESSION['cart'];
            $kazu = $_SESSION['kazu'];
        }
        $cart[] = $pro_code;
        $kazu[] = 1;
        $_SESSION['cart'] = $cart;
        $_SESSION['kazu'] = $kazu;
    }
    catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }
    ?>

    カートに追加しました。<br>
    <br>
    <a href="shop_list.php">商品一覧に戻る</a>

  </body>
</html>