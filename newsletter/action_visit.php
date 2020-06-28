<?php
session_start();

include '../includes/db.inc.php';

if(isset($_POST['submit'])){
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        // MailChimp API credentials
        $apiKey = 'ed1824ff58850ee79892bd12478218e8-us18';
        $listID = 'f6294206ef';
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
        
        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $fname,
                'LNAME'     => $lname
            ]
        ]);
        
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // store the status message based on response code
        if ($httpCode == 200) {
           
        $sql = "SELECT email FROM mailchimp WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: index.php?error=sqlerrorMailchimp"); 
            exit();
        }
        else {

            mysqli_stmt_bind_param($stmt, "s" , $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $result = mysqli_stmt_num_rows($stmt);
            if($result > 0){
                header("Location: email_taken.html");
                exit();
             }
            else{
                $sql = "INSERT INTO mailchimp (fname , lname , email ) VALUES ( ? , ? , ?)";
                $stmt = mysqli_stmt_init($conn);
    
                if(!mysqli_stmt_prepare($stmt , $sql)){
                    header("Location: ../autenticar.php?sqlierror");
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, 'sss', $fname, $lname , $email);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
            header('Location: success.html');
            exit();

        } else {
            switch ($httpCode) {
                case 214:
                    header('Location: index.php?taken');
                    exit();
                    break;
                case 401:
                    header('Location: error.html');
                    exit();
                    break;
                default:
                    print_r($httpCode);
                    exit();
                    break;
            }
           
        }
    }else{
        header('Location: index.php?mail');
        exit();
    }
}
// redirect to homepage
