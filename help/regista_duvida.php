<?php



    if(isset($_POST['colocar-duvida-submit'])){

        session_start();

      require '../includes/db.inc.php';

      
        
      $userid = $_SESSION['userId'];
      $username = $_SESSION['fname'] . " " .$_SESSION['lname'];
      $titulo = $_POST['titulo'];
      $categoria =  $_POST['categoria'];
      $email = $_POST['email'];
      $social = $_POST['social'];
      $descricao =  $_POST['descricao'];
    
    
    
        if( empty($titulo) || empty($categoria) || empty($descricao) || empty($email)  ){                                                                          
            
            header("Location: menu_duvidas.php?emptyfields");
            exit();
        }
    
        else {
    
            $sql = "SELECT 	id_user, username , titulo  FROM duvidas WHERE id_user=? and email=? and titulo=? ";
            $stmt = mysqli_stmt_init($conn);
        
            if(!mysqli_stmt_prepare($stmt , $sql)){

                header("Location: menu_duvidas.php?error=sqlierror"); 
                exit();
            }
            else {
    
                mysqli_stmt_bind_param($stmt, "sss" , $userid, $email, $titulo);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = mysqli_stmt_num_rows($stmt);

                if($result > 0){
                    header("Location: .colocar_duvida.php?error=duvidaTaken");
                    exit();
                 }

                else{
                    $sql = "INSERT INTO duvidas (id_user, username,titulo ,categoria,email, social, descricao) VALUES ( ? , ? ,  ?, ? , ? , ? ,?)";
                    $stmt = mysqli_stmt_init($conn);
        
                    if(!mysqli_stmt_prepare($stmt , $sql)){
                        header("Location: menu_duvidas.php?eraaaaaror=sqlierror");
                        exit();
                    }
                    else{
                     
        
                        mysqli_stmt_bind_param($stmt, 'sssssss',  $userid,$username, $titulo, $categoria ,$email, $social , $descricao);
                        mysqli_stmt_execute($stmt);
        
                        header("Location: consultar_duvida.php?registo=success");
                        exit();
                    }
                }
            }
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    
    else{
        header("Location:   colocar_duvida.php");
        exit();
    }
    