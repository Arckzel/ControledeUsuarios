<?php
include("resources/conexao.php");
include("protect.php");
protect();
$user_id = intval($_GET['usuario']);
$erro = array();
if(isset($_POST['confirmar'])){

    //1 - Registro dos dados
    if(!isset($_SESSION))
        session_start();

    foreach($_POST as $chave=>$valor){
        $_SESSION[$chave] = $mysqli->real_escape_string($valor);
    }

    //2 - validação dos dados

    if(strlen($_SESSION['nome']) == 0){
        $erro[] = "Preencha o nome.";
    }

    if(strlen($_SESSION['sobrenome']) == 0){
        $erro[] = "Preencha o sobrenome.";
    }

    if(substr_count($_SESSION['email'], '@') != 1 || substr_count($_SESSION['email'], '.') < 1 ){
        $erro[] = "Preencha o email corretamente.";
    }

    if(strlen($_SESSION['niveldeacesso']) == 0){
        $erro[] = "Preencha o nivel de acesso.";
    }

    if(strlen($_SESSION['senha']) < 8 || strlen($_SESSION['senha']) > 16){
        $erro[] = "Preencha a senha corretamente.";
    }

    if(strcmp($_SESSION['rsenha'], $_SESSION['senha']) != 0){
        $erro[] = "As senhas estão diferentes";
    }

    //3 - inserção no banco e redirecionamento

    if(count($erro) == 0){

        $senha = md5(md5($_SESSION['senha']));

        $sql_code = "UPDATE usuario  SET
            nome = '$_SESSION[nome]' ,
            sobrenome = '$_SESSION[sobrenome]',
            email = '$_SESSION[email]',
            senha = '$senha',
            sexo = '$_SESSION[sexo]',
            niveldeacesso = '$_SESSION[niveldeacesso]'
            WHERE id = '$user_id'";

        $confirma = $mysqli->query($sql_code) or die($mysqli->error);
        
        if($confirma){
            unset($_SESSION['nome'],
            $_SESSION['sobrenome'],
            $_SESSION['email'],
            $_SESSION['senha'],
            $_SESSION['sexo'],
            $_SESSION['niveldeacesso'],
            $_SESSION['datadecadastro']
            );

            echo "<script> location.href='index.php?p=inicial'; </script>";

        }else
            $erro[] = $confirma;
    }

}else{
    $sql_code = "SELECT * FROM usuario WHERE id = '$user_id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    $linha = $sql_query->fetch_assoc();

    if(!isset($_SESSION))
        session_start();

    $_SESSION['nome'] = $linha['nome'];
    $_SESSION['sobrenome'] = $linha['sobrenome'];
    $_SESSION['email'] = $linha['email'];
    $_SESSION['senha'] = $linha['senha'];
    $_SESSION['sexo'] = $linha['sexo'];
    $_SESSION['niveldeacesso'] = $linha['niveldeacesso'];

}
?>



<h1>Cadastrar Usuário</h1>
<?php
    if(count($erro) > 0){
        echo "<div class='erro'>";
        foreach($erro as $valor)
            echo "$valor <br>";
        
        echo"</div>";
    }
?>
<a href="index.php?p=inicial">Voltar o início</a>
<form action="index.php?p=editar&usuario=<?php echo $user_id;?>" method="POST" id="cadastro">

    <label for="nome">Nome</label>
    <input name="nome" value="<?php if(isset($_SESSION)) echo $_SESSION['nome'];?>" required type="text">
    <p class="espaco"></p>

    <label for="sobrenome">Sobrenome</label>
    <input name="sobrenome" value="<?php if(isset($_SESSION)) echo $_SESSION['sobrenome'];?>" required type="text">
    <p class="espaco"></p>

    <label for="email">Email</label>
    <input name="email" value="<?php if(isset($_SESSION)) echo $_SESSION['email'];?>" required type="email">
    <p class="espaco"></p>

    <label for="senha">Senha</label>
    <p>A senha deve ter entre 8 e 16 caracteres.</p>
    <input name="senha" value="" required type="password">
    <p class="espaco"></p>

    <label for="rsenha">Confirmar Senha</label>
    <input name="rsenha" value="" required type="password">
    <p class="espaco"></p>

    <label for="sexo">Sexo</label>
    <select name="sexo">
        <option value="0">-- Selecione --</option>
        <option value="1"<?php if(isset($_SESSION)) if($_SESSION['sexo'] == 1) echo "selected"?>>Masculino</option>
        <option value="2"<?php if(isset($_SESSION)) if($_SESSION['sexo'] == 2) echo "selected"?>>Feminino</option>
    </select>
    <p class="espaco"></p>
    
    <label for="niveldeacesso">Nivel de Acesso</label>
    <select name="niveldeacesso">
        <option value="0">-- Selecione --</option>
        <option value="1"<?php if(isset($_SESSION)) if($_SESSION['niveldeacesso'] == 1) echo "selected"?>>Básico</option>
        <option value="2"<?php if(isset($_SESSION)) if($_SESSION['niveldeacesso'] == 2) echo "selected"?>>Admin</option>
    </select>
    <p class="espaco"></p>   

    <button id="salvar" name="confirmar" type="submit"><a>Salvar</a></button>

</form>