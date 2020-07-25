<?php

    include("resources/conexao.php");
    include("protect.php");
    protect();

	if(!isset($_SESSION)){
		session_start();
	}
	
	var_dump($_SESSION);
    $sql_code = "SELECT * FROM usuario";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    $linha = $sql_query->fetch_assoc();

    if(isset($linha)){
            
    $sexo = ["Indefinido","Masculino","Feminino"];
    $niveldeacesso = ["Indefinido","Básico","Admin"];

?>
<div>
<h1>Usuários Cadastrados</h1>
<a href="index.php?p=cadastrar">Cadastrar um Usuário</a>
<p class="espaco"></p>
<table>
    <tr class="titulo">        
        <td>Id</td>
        <td>Nome</td>
        <td>Sobrenome</td>
        <td>Sexo</td>
        <td>E-mail</td>
        <td>Nível de Acesso</td>
        <td>Data de Cadastro</td>
        <?php if($_SESSION['niveldeacesso'] == 2){?>
        <td>Ação</td>
        <?php }?>        
    </tr>
    <?php
        do{
    ?>
    <tr>
        <td><?php echo $linha['id'];?></td>
        <td><?php echo $linha['nome'];?></td>
        <td><?php echo $linha['sobrenome'];?></td>
        <td><?php echo $sexo[$linha['sexo']];?></td>
        <td><?php echo $linha['email'];?></td>
        <td><?php echo $niveldeacesso[$linha['niveldeacesso']];?></td>
        <td><?php 
        $d = explode(" ", $linha['datadecadastro']);
        $data = explode("-", $d[0]);        
        echo "$data[2]/$data[1]/$data[0] às $d[1]"; ?></td>
        <?php if($_SESSION['niveldeacesso'] == 2){?>
        <td>
            <button class="button" id="editar"><a href="index.php?p=editar&usuario=<?php echo $linha['id'];?>"> Editar</a></button>
            <button class="button" id="deletar"><a href="index.php?p=deletar&usuario=<?php echo $linha['id'];?>"> Deletar</a></buton>
        </td>
        <?php }?>
    </tr>
    <?php 
        } while($linha = $sql_query->fetch_assoc());
    ?>
</table>
</div>
<?php }else{
    ?>
    <h1>Nenhum usuário cadastrado</h1>
    <a href="index.php?p=cadastrar">Cadastrar um Usuário</a>
    <?php
}


?>