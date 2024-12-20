<?php

namespace App\Modelos;

use App\DB\DBConexion;
use PDO;

class EstadoPublicacion
{
    protected int $estado_publicacion_id;
    protected string $estado;

    public function __construct()
    {
        $this->estado = '';
    }


    public function cargarDatosDeArray(array $data): void
    {
        if (isset($data['estado_publicacion_id'])) {
            $this->setEstadoPublicacionId($data['estado_publicacion_id']);
        }
    
        if (isset($data['estado'])) {
            $this->setEstado($data['estado']);
        }
    }

    /**
     * @return array|self[]
     */
    public function todos(): array
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT * FROM estados_publicacion";
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $estados = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $estado = new self();
            $estado->cargarDatosDeArray($row);
            $estados[] = $estado;
        }
        
        return $estados;
    }

    public function traerPorId(int $id): ?self
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT * FROM estados_publicacion WHERE estado_publicacion_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) return null;
        
        $this->cargarDatosDeArray($row);
        return $this;
    }

    public function getEstadoPublicacionId(): int
    {
        return $this->estado_publicacion_id;
    }

    public function setEstadoPublicacionId(int $estado_publicacion_id): void
    {
        $this->estado_publicacion_id = $estado_publicacion_id;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }
}

?>