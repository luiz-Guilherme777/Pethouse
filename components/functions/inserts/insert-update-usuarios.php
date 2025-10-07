
<?php
require_once __DIR__ . "/../../config/conexao.php";

header('Content-Type: application/json'); // Indica que retornará JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nome = $_POST["nm_nome"] ?? '';
        $nmlogin = $_POST["nm_login"] ?? '';
        $dspassword = $_POST["ds_password"] ?? '';
        $dsemail = $_POST["ds_email"] ?? '';
        $tipo_usuario = $_POST["tipo_usuario"] ?? 'usuario';


        if (empty($nome) || empty($nmlogin) || empty($dspassword)) {
            throw new Exception("Nome, login e senha não pode ser vazio.");
        }

        if(!in_array($tipo_usuario, ['vendedor', 'admin'])) {
            throw new Exception("Tipo de usuário inválido");
        }
        $fotoPerfil = null;
        
       
        $sqlVerifica = "SELECT id FROM usuarios WHERE nm_login = :nmlogin";
        $stmtVerifica = $pdo->prepare($sqlVerifica);
        $stmtVerifica->bindParam(':nmlogin', $nmlogin);
        $stmtVerifica->execute();

        if ($stmtVerifica->rowCount() > 0) {

            if (!empty($_FILES['foto_perfil']['name'])) {
                $fotoNome = uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
                $caminhoUpload = __DIR__ . "/../../../assets/uploads/" . $fotoNome;
    
                if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoUpload)) {
                    throw new Exception("Erro ao fazer upload da imagem.");
                }
    
                $fotoPerfil = $fotoNome;
            }
            else{
                echo json_encode( "Nao tem foto" );
            } 

            // Atualizar
            $sql = "UPDATE usuarios 
                    SET nm_nome = :nome, ds_password = :dspassword, ds_email = :dsemail, tipo_usuario = :tipo_usuario";

            if ($fotoPerfil !== null) {
                $sql .= ", foto_perfil = :foto_perfil";
            }

            $sql .= " WHERE nm_login = :nmlogin";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':dspassword', $dspassword);
            $stmt->bindParam(':dsemail', $dsemail);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            $stmt->bindParam(':nmlogin', $nmlogin);

            if ($fotoPerfil !== null) {
                $stmt->bindParam(':foto_perfil', $fotoPerfil);
            }

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Usuário atualizado com sucesso!"]);
        } else {
            // Inserir

            if (!empty($_FILES['foto_cadastro']['name'])) {
                $fotoNome = uniqid() . "_" . basename($_FILES['foto_cadastro']['name']);
                $caminhoUpload = __DIR__ . "/../../../assets/uploads/" . $fotoNome;
    
                if (!move_uploaded_file($_FILES['foto_cadastro']['tmp_name'], $caminhoUpload)) {
                    throw new Exception("Erro ao fazer upload da imagem.");
                }
    
                $fotoPerfil = $fotoNome;
            }
            else{

               // echo json_encode( "Nao tem foto" );
                $fotoPerfil = 'sem-foto.jpg';
            } 

            $sql = "INSERT INTO usuarios (nm_nome, nm_login, ds_password, ds_email, tipo_usuario, foto_perfil) 
                    VALUES (:nome, :nmlogin, :dspassword, :dsemail, :tipo_usuario, :foto_perfil)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':nmlogin', $nmlogin);
            $stmt->bindParam(':dspassword', $dspassword);
            $stmt->bindParam(':dsemail', $dsemail);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            $stmt->bindParam(':foto_perfil', $fotoPerfil);
            $stmt->execute();                                                                                                      

            echo json_encode(["success" => true, "message" => "Usuário cadastrado com sucesso!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro no banco: " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Requisição inválida."]);
}
