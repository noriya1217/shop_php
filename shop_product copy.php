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
        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT name, price, gazou FROM mst_product WHERE code=?';
        $stmt = $dbh -> prepare($sql);
        $data[] = $pro_code;
        $stmt -> execute($data);

        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        $pro_name = $rec['name'];
        $pro_price = $rec['price'];
        $pro_gazou_name = $rec['gazou'];

        $dbh = null;

        if ($pro_gazou_name == '') {
            $disp_gazou = '画像なし';
        } else {
            $disp_gazou = '<img src="../product/gazou/'.$pro_gazou_name.'">';
        }

        echo '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br><br>';

    }
    catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }
    ?>

    商品情報参照<br /><br />
    商品コード<br />
    <?php print $pro_code; ?><br /><br />
    商品名：<?php print $pro_name; ?><br><br>
    価格：<?php echo $pro_price; ?>円<br><br>
    商品画像：<?php echo $disp_gazou; ?><br><br>

    <form>
        <input type='button' onclick="history.back()" value="戻る">
    </form>

  </body>
</html>