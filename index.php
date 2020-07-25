<?php
include("resources/conexao.php");

if(isset($_SESSION['usuario'])){
    $sql_code = "SELECT id, nome, sobrenome, niveldeacesso FROM usuario WHERE id = '$_SESSION[usuario]'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    $dado = $sql_query->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Usuários</title>
    <link href="css/style.css" rel="stylesheet"></link>
</head>
<body>
    <?php 
        if(isset($_SESSION['usuario'])){
            echo "<h4><?php echo $dado[nome].$dado[sobrenome];?></h4><a href='index.php?p=logout'>Logout</a>";
            
        }
    ?>
   
    <h1>Meu Banco de Usuários</h1>
    <div class="principal">
        
        <?php
        if(isset($_GET['p'])){
            $pagina = $_GET['p'].".php";
            if(is_file("paginas/$pagina")){
                include("paginas/$pagina");                
            }else
            include("paginas/404.php");
        }else
            include("paginas/inicial.php")
        ?>
    </div>
</body>
</html>