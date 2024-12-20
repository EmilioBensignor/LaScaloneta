<?php

use App\Modelos\Usuario;

$db = (new \App\DB\DBConexion())->getDB();

$searchTerm = $_GET['search'] ?? '';

$query = "SELECT u.*, COUNT(c.compra_id) as total_compras 
          FROM usuarios u 
          LEFT JOIN compras c ON u.usuario_id = c.usuario_fk";

if (!empty($searchTerm)) {
    $query .= " WHERE u.nombre LIKE :search 
                OR u.apellido LIKE :search 
                OR u.email LIKE :search";
}

$query .= " GROUP BY u.usuario_id ORDER BY u.usuario_id";

$stmt = $db->prepare($query);

if (!empty($searchTerm)) {
    $searchParam = "%" . $searchTerm . "%";
    $stmt->bindParam(':search', $searchParam);
}

$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$roles = [
    1 => 'Administrador',
    2 => 'Normal'
];
?>

<main>
    <div class="headerAdmin">
        <h1>Administración de Usuarios</h1>
    </div>

    <form class="buscadoForm" method="get" action="index.php">
        <input type="hidden" name="s" value="usuarios">
        <div class="buscadorContainer">
            <input
                type="text"
                name="search"
                placeholder="Buscar por nombre, apellido o email..."
                value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="botonPrimario">Buscar</button>
        </div>
    </form>

    <?php if (empty($usuarios)): ?>
        <p class="no-resultados">No se encontraron usuarios que coincidan con tu búsqueda.</p>
    <?php else: ?>
        <div class="tablaAdminContainer">
            <table class="tablaAdmin">
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
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['usuario_id']) ?></td>
                            <td><?= htmlspecialchars($roles[$usuario['rol_fk']] ?? 'Rol desconocido') ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                            <td><?= htmlspecialchars($usuario['apellido']) ?></td>
                            <td><?= htmlspecialchars($usuario['total_compras']) ?></td>
                            <td>
                                <?php if ($usuario['total_compras'] > 0): ?>
                                    <a href="index.php?s=usuario-compras&id=<?= $usuario['usuario_id'] ?>" class="botonPrimario botonUnderline">Ver compras</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>