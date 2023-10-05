<?php
    require __DIR__ . '/../../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $userEmail = "";
    
    if(isset($_POST['subscribe'])){
        $userEmail = $_POST['email'];
        if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $mail = new PHPMailer(true);
    
            try {
                $mail->isSMTP();
                $mail->SMTPDebug  = 1; 
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth =   TRUE;       
                $mail->Username = 'nabilsalimi0229@gmail.com '; 
                $mail->Password = 'nbfdnbinpejpnufh'; 
                $mail->SMTPSecure = 'ssl';       
                $mail->Port = 465;   
    
                $mail->setFrom('33580@ma-web.nl', 'Nabil Salimi');
                $mail->addAddress($userEmail);
                $mail->isHTML(true);
    
                $mail->Subject = 'Thanks for your subscription';
                $mail->Body = 'Thanks for Subscribing';
    
                $mail->send();
    
                echo '<p>Success</p>';
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=emails', 'root', 'root');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (:email)");
                    $stmt->bindParam(':email', $userEmail);
                    $stmt->execute();
            
                    echo '<p>Success</p>';
                } catch (PDOException $e) {
                    echo '<p>Error: ' . $e->getMessage() . '</p>';
            }
            } catch (Exception $e) {
                echo '<p>Error: ' . $mail->ErrorInfo . '</p>';
            }
        } else {
            echo 'Invalid email';
        }
    }
    ?>
<form method="post">
    <input type="text" class="form__input" name="email" placeholder="Email" value="<?php echo $userEmail ?>">
    <figure class="form__fig form__fig--first"></figure>
    <figure class="form__fig form__fig--second"></figure>
    <input type="submit" name="subscribe" class="form__button" placeholder="submit">
</form>

