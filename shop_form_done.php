<?php
    session_start();
    session_regenerate_id(true);
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
            require_once('../common/common.php');

            $post = sanitize($_POST);

            $onamae = $post['onamae'];
            $email = $post['email'];
            $postal1 = $post['postal1'];
            $postal2 = $post['postal2'];
            $address = $post['address'];
            $tel = $post['tel'];

            echo $onamae.'様<br>';
            echo 'ご注文ありがとうございました。<br>';
            echo $email.'にメールを送信しましたのでご確認願います。<br>';
            echo '商品は以下の住所に発送させていただきます。<br>';
            echo $postal1.'-'.$postal2.'<br>';
            echo $address.'<br>';
            echo $tel.'<br>';

            $honbun = "";
            $honbun .= $onamae."様\n\nこのたびはご注文ありがとうございました。\n";
            $honbun .= "\n";
            $honbun .= "ご注文商品\n";
            $honbun .= "--------------\n";

            $cart = $_SESSION['cart'];
            $kazu = $_SESSION['kazu'];
            $max = count($cart);

            $dsn = 'mysql:dbname=shop;host=localhost;carset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            for ($i=0; $i < $max; $i++) {
                $sql = 'SELECT name, price FROM mst_product WHERE code=?';
                $stmt = $dbh -> prepare($sql);
                $data[0] = $cart[$i];
                $stmt -> execute($data);

                $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

                $name = $rec['name'];
                $price = $rec['price'];
                $suryo = $kazu[$i];
                $shokei = $price * $suryo;

                $honbun .= $name.' ';
                $honbun .= $price.'円　× ';
                $honbun .= $suryo.'個 = ';
                $honbun .= $shokei."円\n";
            }

            $dbh = null;

            $honbun .= "送料は無料です。\n";
            $honbun .= "---------------\n";
            $honbun .= "\n";
            $honbun .= "代金は以下の口座にお振込み下さい。\n";
            $honbun .= "ろくまる銀行やさい支店普通口座1234567\n";
            $honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
            $honbun .= "\n";
            $honbun .= "　　　　　　　　　　　　　　　　　　　　\n";
            $honbun .= "　〜安心野菜のろくまる農園〜\n";
            $honbun .= "\n";
            $honbun .= "◯◯県六丸郡六丸村123-4\n";
            $honbun .= "電話:090-6060-1111\n";
            $honbun .= "メール:info@rokumarunouen.com\n";
            $honbun .= "　　　　　　　　　　　　　　　　　　　　\n";
            // print '<br>';
            // print nl2br($honbun);

            $title = 'ご注文ありがとうございます。';
            $header = 'From: info@rokumarunouen.com';
            $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail($email, $title, $honbun, $header);


            $title = 'お客様からご注文がありました。';
            $header = 'From: '.$email;
            $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail('info@rokumarunouen.com', $title, $honbun, $header);

        } catch (Exception $e) {
            print "ただいま障害によりご迷惑をおかけしております。";
            exit();
        }
        ?>
    </body>
</html>