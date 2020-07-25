<?php

    include("resources/conexao.php");

    if(isset($_POST['email'])){

        $email = $mysqli->escape_string($_POST['email']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erro[] = "E-mail inválido";
        }else{

            $sql_code = "SELECT senha, id FROM usuario WHERE email = '$email'";
            $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
            $dado = $sql_query->fetch_assoc();
            $total = $sql_query->num_rows;

            if($total == 0){
                $erro[] = "Nenhum usuário cadastrado com esse email.";
            }

            if(!isset($erro) && $total > 0){

                $novasenha = substr(md5(time()),0,6);
                $nscriptografada = md5(md5($novasenha));
                
                if(mail($email, "Sua nova senha", "Sua nova senha é: ".$novasenha)){

                    $sql_code = "UPDATE usuario SET senha = '$nscriptografada' WHERE email = '$email'";
                    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

                    if($sql_query)
                        $erro[] = "Senha Alterada com sucesso!";

                }
            }

        }
    }

?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            if(isset($erro)){
                if(count($erro) > 0){ 
                    foreach($erro as $msg){
                        echo "<p style='color:red;'>$msg</p>";
                    }
                }
            }
        ?>
        <form method="POST" form="">
            <input value="<?php echo $email;?>" placeholder="E-mail" name="email" type="text">
            <input type="submit">
        </form>
    </body>
</html>
