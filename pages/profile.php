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
    <title>Meu Perfil</title>
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
                <a href="dashboard.php" class="menu-item">
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
                <a href="profile.php" class="menu-item active">
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
                    <h1>Meu Perfil</h1>
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

            <?php if(!empty($message)): ?>
            <div class="alert <?php echo $message_type; ?>">
                <i class="fas <?php echo $message_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <div class="stats">
                <div class="stat-card">
                    <i class="fas fa-file-invoice"></i>
                    <div class="info">
                        <h3><?php echo $stats['total_invoices'] ?? 0; ?></h3>
                        <p>Notas fiscais</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <div class="info">
                        <h3><?php echo date('d/m/Y', strtotime($user['creation_date'])); ?></h3>
                        <p>Membro desde</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-id-card"></i>
                    <div class="info">
                        <h3>#<?php echo str_pad($user['id'], 4, '0', STR_PAD_LEFT); ?></h3>
                        <p>ID do usuário</p>
                    </div>
                </div>
            </div>

            <div class="forms">
                <!-- DADOS PESSOAIS -->
                <div class="form-box">
                    <h2><i class="fas fa-user-edit"></i> Dados Pessoais</h2>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label>Nome completo <span class="required">*</span></label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>E-mail <span class="required">*</span></label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Idade <span class="optional">(opcional)</span></label>
                                <input type="number" name="age" value="<?php echo $user['age'] ?? ''; ?>" min="1" max="120">
                            </div>
                            
                            <div class="form-group">
                                <label>Sexo <span class="optional">(opcional)</span></label>
                                <select name="gender">
                                    <option value="">Selecione...</option>
                                    <option value="masculino" <?php echo ($user['gender'] ?? '') == 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="feminino" <?php echo ($user['gender'] ?? '') == 'feminino' ? 'selected' : ''; ?>>Feminino</option>
                                    <option value="outro" <?php echo ($user['gender'] ?? '') == 'outro' ? 'selected' : ''; ?>>Outro</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>CEP <span class="optional">(opcional)</span></label>
                                <input type="text" name="cep" value="<?php echo htmlspecialchars($user['cep'] ?? ''); ?>" maxlength="9" id="cep">
                            </div>
                            
                            <div class="form-group">
                                <label>Endereço <span class="optional">(opcional)</span></label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" id="address">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Cidade <span class="optional">(opcional)</span></label>
                                <input type="text" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" id="city">
                            </div>
                            
                            <div class="form-group">
                                <label>UF <span class="optional">(opcional)</span></label>
                                <input type="text" name="state" value="<?php echo htmlspecialchars($user['state'] ?? ''); ?>" maxlength="2" style="text-transform: uppercase;" id="state">
                            </div>
                        </div>
                        
                        <button type="submit" name="update_profile" class="btn">
                            <i class="fas fa-save"></i>
                            Salvar Alterações
                        </button>
                    </form>
                </div>

                <!-- ALTERAR SENHA -->
                <div class="form-box">
                    <h2><i class="fas fa-lock"></i> Alterar Senha</h2>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label>Senha atual <span class="required">*</span></label>
                            <input type="password" name="current_password" placeholder="••••••••" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Nova senha <span class="required">*</span></label>
                            <input type="password" name="new_password" placeholder="Mínimo 6 caracteres" required minlength="6">
                        </div>
                        
                        <div class="form-group">
                            <label>Confirmar senha <span class="required">*</span></label>
                            <input type="password" name="confirm_password" placeholder="Digite novamente" required>
                        </div>
                        
                        <button type="submit" name="change_password" class="btn">
                            <i class="fas fa-key"></i>
                            Alterar Senha
                        </button>
                    </form>
                </div>
            </div>
            
            <div style="margin-top: 20px; text-align: center; color: #666; font-size: 13px;">
                <i class="fas fa-info-circle"></i> 
                Campos marcados com <span class="required">*</span> são obrigatórios. 
                Os demais campos são opcionais.
            </div>
        </div>
    </div>

    <script>
    document.getElementById('cep').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if(value.length > 5) {
            value = value.substring(0,5) + '-' + value.substring(5,8);
        }
        e.target.value = value;
    });
    </script>
</body>
</html>