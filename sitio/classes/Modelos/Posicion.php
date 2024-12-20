<?php

namespace App\Modelos;

use App\DB\DBConexion;

class Posicion
{
    protected int $posicion_id;
    protected string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setPosicionId($data['posicion_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|self[]
     */
    public function todas(): array
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT * FROM posiciones
                    ORDER BY nombre";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);

        return $stmt->fetchAll();
    }

    public function getPosicionId(): int
    {
        return $this->posicion_id;
    }

    public function setPosicionId(int $posicion_id): void
    {
        $this->posicion_id = $posicion_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
}
