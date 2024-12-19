<?php
use App\Modelos\Usuario;

$db = (new \App\DB\DBConexion())->getDB();

// Get all users first
$query = "SELECT u.*, COUNT(c.compra_id) as total_compras 
          FROM usuarios u 
          LEFT JOIN compras c ON u.usuario_id = c.usuario_fk 
          GROUP BY u.usuario_id 
          ORDER BY u.usuario_id";
$stmt = $db->query($query);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$roles = [
    1 => 'Administrador',
    2 => 'Normal'
];
?>

<div class="container">
    <h1>Administración de Usuarios</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Compras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['usuario_id'])?></td>
                <td><?= htmlspecialchars($roles[$usuario['rol_fk']] ?? 'Rol desconocido')?></td>
                <td><?= htmlspecialchars($usuario['email'])?></td>
                <td><?= htmlspecialchars($usuario['nombre'])?></td>
                <td><?= htmlspecialchars($usuario['apellido'])?></td>
                <td><?= htmlspecialchars($usuario['total_compras'])?></td>
                <td>
                    <?php if($usuario['total_compras'] > 0): ?>
                        <a href="index.php?s=usuario-compras&id=<?= $usuario['usuario_id']?>" class="btn-view">Ver compras</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.compras-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.compras-list li {
    margin-bottom: 5px;
    padding: 5px;
    background-color: #f8f9fa;
    border-radius: 4px;
}
</style>
