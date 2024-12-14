<?php

namespace App\Modelos;

use App\DB\DBConexion;
use App\Transformadores\DataFilaJugador;
use PDO;

class Jugador
{
    protected int $jugador_id = 0;
    protected int $usuario_fk = 0;
    protected int $estado_publicacion_fk = 0;
    protected string $nombre = "";
    protected string $apellido = "";
    protected string $club = "";
    protected string $descripcion = "";
    protected string $imagen_jugador = "";
    protected string $alt_imagen_jugador = "";
    protected string $imagen_camiseta = "";
    protected string $alt_imagen_camiseta = "";

    protected array $posicionesId = [];

    protected EstadoPublicacion $estadoPublicacion;
    /** @var Posicion[] */
    protected array $posiciones = [];

    public function cargarDatosDeArray(array $data): void
    {
        $this->setNumeroCamiseta($data['jugador_id']);
        $this->setUsuarioFk($data['usuario_fk']);
        $this->setEstadoPublicacionFk($data['estado_publicacion_fk']);
        $this->setNombre($data['nombre']);
        $this->setApellido($data['apellido']);
        $this->setClub($data['club']);
        $this->setDescripcion($data['descripcion']);
        $this->setImagenJugador($data['imagen_jugador']);
        $this->setAltImagenJugador($data['alt_imagen_jugador']);
        $this->setImagenCamiseta($data['imagen_camiseta']);
        $this->setAltImagenCamiseta($data['alt_imagen_camiseta']);
    }
    /**
     * @return array|self[]
     */
    public function todos(): array
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT 
                        j.*,
                        ep.*,
                        GROUP_CONCAT(p.posicion_id, ':', p.nombre SEPARATOR ' :: ') AS 'posiciones_agrupadas'
                    FROM jugadores j
                    INNER JOIN estados_publicacion ep
                        ON ep.estado_publicacion_id = j.estado_publicacion_fk
                    LEFT JOIN jugadores_tienen_posiciones jtp
                        ON j.jugador_id = jtp.jugador_fk
                    LEFT JOIN posiciones p
                        ON p.posicion_id = jtp.posicion_fk
                    GROUP BY j.jugador_id
                    ORDER BY j.jugador_id";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, DataFilaJugador::class);

        return array_map(function (DataFilaJugador $registro) {
            return $registro->getInstanciaJugador();
        }, $stmt->fetchAll());
    }

    /**
     * @return array|self[]
     */
    public function publicados(): array
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT 
                        j.*,
                        GROUP_CONCAT(p.posicion_id, ':', p.nombre SEPARATOR ' :: ') AS 'posiciones_agrupadas'
                    FROM jugadores j
                    LEFT JOIN jugadores_tienen_posiciones jtp
                        ON j.jugador_id = jtp.jugador_fk
                    LEFT JOIN posiciones p
                        ON p.posicion_id = jtp.posicion_fk
                    WHERE estado_publicacion_fk = 1
                    GROUP BY j.jugador_id";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);

        return $stmt->fetchAll();
    }

    /**
     * @param int $id
     * @return self|null
     */
    public function porId(int $id): ?self
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT * FROM jugadores
                WHERE jugador_id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);

        $jugador = $stmt->fetch();

        if (!$jugador) return null;

        $jugador->cargarPosiciones();

        return $jugador;
    }

    public function cargarPosicionesId(): void
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT * FROM jugadores_tienen_posiciones
                WHERE jugador_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->getNumeroCamiseta()]);

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->posicionesId[] = $fila['posicion_fk'];
        }
    }

    public function cargarPosiciones(): void
    {
        $db = (new DBConexion())->getDB();
        $query = "SELECT p.* 
                FROM jugadores_tienen_posiciones jtp
                INNER JOIN posiciones p
                    ON jtp.posicion_fk = p.posicion_id
                WHERE jugador_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->getNumeroCamiseta()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Posicion::class);

        $this->setPosiciones($stmt->fetchAll());
    }

    public function crear(array $data): void
    {
        $db = (new DBConexion())->getDB();
        $query = "INSERT INTO jugadores (usuario_fk, estado_publicacion_fk, nombre, apellido, club, descripcion, imagen_jugador, alt_imagen_jugador, imagen_camiseta, alt_imagen_camiseta)
                VALUES (:usuario_fk, :estado_publicacion_fk, NOW(), :nombre, :apellido, :club, :descripcion, :imagen_jugador, :alt_imagen_descripcion, :imagen_camiseta, :alt_imagen_camiseta)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'usuario_fk'                => $data['usuario_fk'],
            'estado_publicacion_fk'     => $data['estado_publicacion_fk'],
            'nombre'                    => $data['nombre'],
            'apellido'                  => $data['apellido'],
            'club'                      => $data['club'],
            'descripcion'               => $data['descripcion'],
            'imagen_jugador'            => $data['imagen_jugador'],
            'alt_imagen_jugador'        => $data['alt_imagen_jugador'],
            'imagen_camiseta'           => $data['imagen_camiseta'],
            'alt_imagen_camiseta'       => $data['alt_imagen_camiseta'],
        ]);

        $jugadorId = $db->lastInsertId();
        $this->asociarPosiciones($jugadorId, $data['posiciones']);
    }

    public function asociarPosiciones(int $idJugador, array $posiciones) : void
    {
        if(count($posiciones) > 0) {
            $paresInsercion = []; 
            $valoresInsercion = []; 

            foreach($posiciones as $posicion) {
                $paresInsercion[] = "(?, ?)";
                array_push($valoresInsercion, $idJugador, $posicion);
            }
            $db = (new DBConexion())->getDB();
            $query = "INSERT INTO jugadores_tienen_posiciones (jugador_fk, posicion_fk)
                    VALUES " . implode(', ', $paresInsercion);
            $stmt = $db->prepare($query);
            $stmt->execute($valoresInsercion);
        }
    }

    public function editar(int $id, array $data): void
    {
        $db = (new DBConexion())->getDB();
        $query = "UPDATE jugadores
                SET estado_publicacion_fk   = :estado_publicacion_fk,
                    nombre                  = :nombre,
                    apellido                = :apellido,
                    club                    = :club,
                    descripcion             = :descripcion,
                    imagen_jugador          = :imagen_jugador,
                    alt_imagen_jugador      = :alt_imagen_jugador
                    imagen_camiseta         = :imagen_camiseta
                    alt_imagen_camiseta     = :alt_imagen_camiseta
                WHERE jugador_id = :jugador_id";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'estado_publicacion_fk'     => $data['estado_publicacion_fk'],
            'nombre'                    => $data['nombre'],
            'apellido'                  => $data['apellido'],
            'club'                      => $data['club'],
            'descripcion'               => $data['descripcion'],
            'imagen_jugador'            => $data['imagen_jugador'],
            'alt_imagen_jugador'        => $data['alt_imagen_jugador'],
            'imagen_camiseta'           => $data['imagen_camiseta'],
            'alt_imagen_camiseta'       => $data['alt_imagen_camiseta'],
            'jugador_id'                => $id,
        ]);

        $this->desasociarPosiciones($id);
        $this->asociarPosiciones($id, $data['posiciones']);
    }

    public function eliminar(int $id): void
    {
        $this->desasociarPosiciones($id);
        $db = (new DBConexion())->getDB();
        $query = "DELETE FROM jugadores
                WHERE jugador_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
    }

    public function desasociarPosiciones(int $id) : void
    {
        $db = (new DBConexion())->getDB();
        $query = "DELETE FROM jugadores_tienen_posiciones
                WHERE jugador_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
    }

    public function getPosicionId() : array
    {
        if(count($this->posicionesId) > 0) return $this->posicionesId;

        $ids = [];
        foreach($this->posiciones as $posicion) {
            $ids[] = $posicion->getPosicionId();
        }
        return $ids;
    }

    /* Getter y Setters */

    public function getNumeroCamiseta(): int
    {
        return $this->jugador_id;
    }
    public function setNumeroCamiseta(int $jugador_id): void
    {
        $this->jugador_id = $jugador_id;
    }

    public function getUsuarioFk(): int
    {
        return $this->usuario_fk;
    }
    public function setUsuarioFk(int $usuario_fk): void
    {
        $this->usuario_fk = $usuario_fk;
    }

    public function getEstadoPublicacionFk(): int
    {
        return $this->estado_publicacion_fk;
    }

    public function setEstadoPublicacionFk(int $estado_publicacion_fk): void
    {
        $this->estado_publicacion_fk = $estado_publicacion_fk;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }
    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function getClub(): string
    {
        return $this->club;
    }
    public function setClub(string $club): void
    {
        $this->club = $club;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getImagenJugador(): string
    {
        return $this->imagen_jugador;
    }
    public function setImagenJugador(string $imagen_jugador): void
    {
        $this->imagen_jugador = $imagen_jugador;
    }

    public function getAltImagenJugador(): string
    {
        return $this->alt_imagen_jugador;
    }
    public function setAltImagenJugador(string $alt_imagen_jugador): void
    {
        $this->alt_imagen_jugador = $alt_imagen_jugador;
    }

    public function getImagenCamiseta(): string
    {
        return $this->imagen_camiseta;
    }
    public function setImagenCamiseta(string $imagen_camiseta): void
    {
        $this->imagen_camiseta = $imagen_camiseta;
    }

    public function getAltImagenCamiseta(): string
    {
        return $this->alt_imagen_camiseta;
    }
    public function setAltImagenCamiseta(string $alt_imagen_camiseta): void
    {
        $this->alt_imagen_camiseta = $alt_imagen_camiseta;
    }

    public function getEstadoPublicacion(): EstadoPublicacion
    {
        return $this->estadoPublicacion;
    }
    public function setEstadoPublicacion(EstadoPublicacion $estadoPublicacion): void
    {
        $this->estadoPublicacion = $estadoPublicacion;
    }

    public function getPosiciones(): array
    {
        return $this->posiciones;
    }
    public function setPosiciones(array $posiciones): void
    {
        $this->posiciones = $posiciones;
    }
}