<?php
    /* Conexão com BD MySQL (usuário 'root', senha 'root', banco 'uniasselvi') */
    $link = mysqli_connect("localhost", "root", "", "uniasselvi");

    // Valida conexão com o banco de dados
    if($link === false){
        die("ERRO: Não foi possível conectar ao BD!" . mysqli_connect_error());
    }

    // Variáveis criadas para obter valores dos parâmetros do formulário
    $nome = mysqli_real_escape_string($link, $_REQUEST['nomesobrenome']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $telefone = mysqli_real_escape_string($link, $_REQUEST['telefone']);
    $mensagem = mysqli_real_escape_string($link, $_REQUEST['mensagem']);
    $contato = mysqli_real_escape_string($link, $_REQUEST['contato']);
    $horario = mysqli_real_escape_string($link, $_REQUEST['horario']);
    $novidade = mysqli_real_escape_string($link, $_REQUEST['novidade']);

    $codigo = 1;
    // Pega o próximo código (sem utilização de sequence do banco)
    $sql = "SELECT MAX(CODIGO) AS CODIGO FROM clientes";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            if($row = mysqli_fetch_array($result)){
                if (intval($row['CODIGO']) > 0){
                    $codigo = intval($row['CODIGO']) + 1;
                }
            }
        }
    }
    
    // Realiza inserção do novo registro na tabela do banco de dados
    $sql = "INSERT INTO 
                clientes (CODIGO, NOME, EMAIL, TELEFONE, MENSAGEM, CONTATO, HORARIO, NOVIDADE) 
            VALUES 
                ('$codigo', '$nome', '$email', '$telefone', '$mensagem', '$contato', '$horario', '$novidade')";

    if(mysqli_query($link, $sql)){
        header('refresh:1;url=index.html');
        echo '<script type="text/javascript">alert("Cliente adicionado com sucesso.")</script>';
    }else{
        echo "Erro ao adicionar cliente: $sql. " . mysqli_error($link);
    }

    // Close connection
    mysqli_close($link);
?>
