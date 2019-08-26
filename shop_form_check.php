<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ろくまる農園</title>
    </head>
    <body>
        <?php
        require_once('../common/common.php');

        $post = sanitize($_POST);

        $onamae = $post['onamae'];
        $email = $post['email'];
        $postal1 = $post['postal1'];
        $postal2 = $post['postal2'];
        $address = $post['address'];
        $tel = $post['tel'];

        if ($onamae == '') {
            print 'お名前が入力されていません<br><br>';
        }
        if (preg_match('/^[\w\.\-]+\@[\w\-\.]+\.([a-zA-Z0-9]{2,4})$/', $email) == 0) {
            echo 'メールアドレスを性格に入力して下さい（例：test@example.com）<br><br>';
        }
        if (preg_match('/\A[0-9]+\z/', $postal1) == 0) {
            echo '郵便番号は半角数字で入力してください<br><br>';
        }
        if (preg_match('/\A[0-9]+\z/', $postal2) == 0) {
            echo '郵便番号は半角数字で入力してください<br><br>';
        }
        if ($address == '') {
            echo '住所が入力されていません。<br><br>';
        }
        if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel) == 0) {
            echo '電話番号を性格に入力してください。<br><br>';
        }

        echo '<form method="post" action="shop_form_done.php">';
            echo '<input >';
        echo '</form>';
        ?>
    </body>
</html>