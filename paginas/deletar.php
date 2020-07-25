<?php

include("resources/conexao.php");
include("protect.php");
protect();
if(isset($_GET['p']) && isset($_GET['usuario'])){  

    //1 - resgatar dados

    $sql_code = "SELECT * FROM `usuario` WHERE id IN($_GET[usuario])";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    $linha = $sql_query->fetch_assoc();
    $sexo = ["Indefinido","Masculino","Feminino"];
    $userid = $linha['id'];
    $niveldeacesso = ["Indefinido","Básico","Admin"];      

    //2 - confirmar usuario      

      if(is_null($linha['nome'])){
        ?>
            <h1>Usuário não encontrado!</h1>
            <a href="index.php?p=inicial">Voltar o início</a>        
        <?php
      }elseif(!isset($_GET['confirmar']) && !isset($_GET['deletar'])){    

    //3 - mostrar dados do usuario
            ?>  <h1>Dados do usuário</h1>
                <a href="index.php?p=inicial">Voltar o início</a>
                <p class="espaco"></p>    
                <table border=1 cellpadding=10>
                    <tr class=titulo>
                        <td>Nome</td>
                        <td>Sobrenome</td>
                        <td>Sexo</td>
                        <td>E-mail</td>
                        <td>Nível de Acesso</td>
                        <td>Data de Cadastro</td>        
                    </tr>
                    <?php
                        do{
                    ?>
                    <tr>
                        <td><?php echo $linha['nome'];?></td>
                        <td><?php echo $linha['sobrenome'];?></td>
                        <td><?php echo $sexo[$linha['sexo']];?></td>
                        <td><?php echo $linha['email'];?></td>
                        <td><?php echo $niveldeacesso[$linha['niveldeacesso']];?></td>
                        <td><?php echo $linha['datadecadastro'];?></td>        
                    </tr>
                    <?php 
                        } while($linha = $sql_query->fetch_assoc());
                    ?>
                </table>
            <?php

            $linha = $sql_query->fetch_assoc();
    
        //3 - confirmar deleta

            ?>
            
            <br>
            <h2>Deseja realmente deletar este usuário?</h2>
            <div class="confirmardeletar">
                <Button class="button" id="editar"><a href="index.php">Cancelar</a></Button>            
                <Button class="button" id="deletar" name="confirmar" type="submit"><a  href="index.php?p=deletar&usuario=<?php echo $userid;?>">Deletar Permanentemente</a></Button>            
            </div>

            <?php

        }elseif(isset($_GET['confirmar'])){
        //4  - deletar 
        ?>
        <h1>Confirme sua senha para deletar este usuário</h1>
        <input  type="password">
        <br>
        <button class="button" id="deletar"> <a href="index.php?p=deletar&usuario=<?php echo $userid;?>&deletar"> Deletar</a></button>
        <?php }elseif(isset($_GET['deletar'])){
            $delete_code = "DELETE FROM `usuario` WHERE `usuario`.`id` = $userid";            

            if($mysqli->query($delete_code)){
                ?>
                <h1>Usuário deletado com Sucesso</h1>
                <a href="index.php?p=inicial">Voltar o início</a>
                <?php
            }else{
                ?>
                <h1>Houve um erro ao deletar este usuário</h1>
                <a href="index.php?p=inicial">Voltar o início</a>
                <?php
            }
        }

}

?>  