<?php

if(isset($_POST['login-submit'])){

    require 'db.inc.php';

   
    $email = $_POST['email'];
    $password = $_POST['password'];



    if(empty($email)  || empty($password)){
        
        header("Location: ../autenticar.php?LoginEmptyfiels");
        exit();
    }
    else{
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt , $sql)){

            header("Location: ../autenticar.php?sqlierror"); 
            exit();

        }
        else{

            mysqli_stmt_bind_param($stmt, "s" , $email);
            mysqli_stmt_execute($stmt);
            $result =  mysqli_stmt_get_result($stmt);
           

            if($row = mysqli_fetch_assoc($result)){///ver se coicidem 

                $pwdCheck = md5($password);// ve se as pwd sao iguais
               
                if($pwdCheck != $row['password']){
                    header("Location: ../autenticar.php?passErrada");
                    exit();
                }
                if($row['acount_status'] == 'desativado'){

                    header("Location: ../autenticar.php?desativado");
                    exit();
                }

                else if($pwdCheck == true){

                        session_start();
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['fname'] = $row['fname'];
                        $_SESSION['lname'] = $row['lname'];
                        $_SESSION['userEmail'] = $row['email'];
                        $_SESSION['foto_status'] = $row['foto_status'];
                        $_SESSION['userStatus'] = $row['user_status'];
                        $_SESSION['acountStatus'] = $row['acount_status'];
                        $_SESSION['newsletter_status'] = $row['newsletter_status'];
                        

                        header('Location:  ../index.php?login=sucess');
                        exit();

                }

                else{
                     header("Location: ../autenticar.php?passErrada");
                     exit();
                 }

             }
             else{
                header("Location: ../autenticar.php?noUser");
                exit();
             }


             
        }
    }
   
}
else{
    header("Location: ../autenticar.php");
    exit();
}