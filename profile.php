<?php
session_start();
require_once 'config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$message = '';
$message_type = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(isset($_POST['update_profile'])) {
        
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $age = !empty($_POST['age']) ? (int)$_POST['age'] : null;
        $gender = !empty($_POST['gender']) ? $_POST['gender'] : null;
        $cep = !empty($_POST['cep']) ? trim($_POST['cep']) : null;
        $address = !empty($_POST['address']) ? trim($_POST['address']) : null;
        $city = !empty($_POST['city']) ? trim($_POST['city']) : null;
        $state = !empty($_POST['state']) ? trim($_POST['state']) : null;
        
        $errors = [];
        
        if(empty($name)) $errors[] = "Nome é obrigatório";
        if(empty($email)) $errors[] = "Email é obrigatório";
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido";
        
        if(empty($errors)) {
            $check = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $check->execute([$email, $_SESSION['user_id']]);
            
            if($check->rowCount() > 0) {
                $errors[] = "Este email já está em uso";
            }
        }
        
        if(empty($errors)) {
            $sql = "UPDATE users SET name=?, email=?, age=?, gender=?, cep=?, address=?, city=?, state=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            
            if($stmt->execute([$name, $email, $age, $gender, $cep, $address, $city, $state, $_SESSION['user_id']])) {
                $_SESSION['user_name'] = $name;
                $message = "Perfil atualizado com sucesso!";
                $message_type = "success";
                
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch();
            } else {
                $message = "Erro ao atualizar perfil";
                $message_type = "error";
            }
        } else {
            $message = implode("<br>", $errors);
            $message_type = "error";
        }
    }
    
    if(isset($_POST['change_password'])) {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        if(empty($current)) $errors[] = "Senha atual é obrigatória";
        if(empty($new)) $errors[] = "Nova senha é obrigatória";
        elseif(strlen($new) < 6) $errors[] = "Nova senha deve ter pelo menos 6 caracteres";
        if($new !== $confirm) $errors[] = "As senhas não conferem";
        
        if(empty($errors)) {
            if(password_verify($current, $user['password'])) {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                
                if($stmt->execute([$hash, $_SESSION['user_id']])) {
                    $message = "Senha alterada com sucesso!";
                    $message_type = "success";
                } else {
                    $message = "Erro ao alterar senha";
                    $message_type = "error";
                }
            } else {
                $message = "Senha atual incorreta";
                $message_type = "error";
            }
        } else {
            $message = implode("<br>", $errors);
            $message_type = "error";
        }
    }
}

$stmt = $pdo->prepare("SELECT COUNT(*) as total_invoices FROM invoices WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetch();

include 'profile_template.php';
?>