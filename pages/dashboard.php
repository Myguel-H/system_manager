<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Sistema</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="dashboard-page">
    <div class="dashboard">
        <!-- SIDEBAR -->
        <div class="dashboard-sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cube"></i> Sistema</h2>
                <p>Gestão completa</p>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-title">PRINCIPAL</div>
                <a href="dashboard.php" class="menu-item active">
                    <i class="fas fa-home"></i> Início
                </a>
                
                <div class="menu-divider"></div>
                
                <div class="menu-title">MÓDULOS</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-file-invoice"></i> Notas Fiscais
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-chart-line"></i> Relatórios
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-users"></i> Clientes
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-box"></i> Produtos
                </a>
                
                <div class="menu-divider"></div>
                
                <div class="menu-title">SISTEMA</div>
                <a href="profile.php" class="menu-item">
                    <i class="fas fa-user"></i> Meu Perfil
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i> Configurações
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-question-circle"></i> Ajuda
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="logout.php" class="menu-item" style="color: #ff4757;">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </div>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="dashboard-content">
            <div class="dashboard-header">
                <div class="header-left">
                    <h1>Bem-vindo, <?php echo explode(' ', $user['name'])[0]; ?>!</h1>
                    <p><?php echo date('d/m/Y'); ?></p>
                </div>
                
                <a href="profile.php" class="user-profile">
                    <div class="user-info">
                        <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                        <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                    </div>
                </a>
            </div>

            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <h2>Olá, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                <p>Bem-vindo ao sistema. Utilize o menu ao lado para navegar.</p>
            </div>

            <div class="modules-grid">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3>Notas Fiscais</h3>
                    <p>Gerencie suas notas fiscais</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Relatórios</h3>
                    <p>Acompanhe relatórios</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Clientes</h3>
                    <p>Gerencie clientes</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3>Produtos</h3>
                    <p>Controle de produtos</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>