<?php
namespace App\Transformadores;

use App\Modelos\Posicion;
use App\Modelos\EstadoPublicacion;
use App\Modelos\Jugador;

class DataFilaJugador
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
    protected float $precio = 0.0;
    protected int $numero_camiseta = 0;

    protected ?string $estado_publicacion_id = null;
    protected ?string $estado = null;

    protected ?string $posiciones_agrupadas = null;

    public function getInstanciaJugador(): Jugador
    {
        $jugador = new Jugador();
        $jugador->cargarDatosDeArray([
            'jugador_id'        => $this->jugador_id,
            'numero_camiseta'   => $this->numero_camiseta,
            'usuario_fk'        => $this->usuario_fk,
            'estado_publicacion_fk' => $this->estado_publicacion_fk,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'club' => $this->club,
            'descripcion' => $this->descripcion,
            'imagen_jugador' => $this->imagen_jugador,
            'alt_imagen_jugador' => $this->alt_imagen_jugador,
            'imagen_camiseta' => $this->imagen_camiseta,
            'alt_imagen_camiseta' => $this->alt_imagen_camiseta,
            'precio' => (float)$this->precio,
        ]);

        if($this->estado_publicacion_id !== null) {
            $estado = new EstadoPublicacion();
            $estado->cargarDatosDeArray([
                'estado_publicacion_id' => $this->estado_publicacion_id,
                'nombre' => $this->nombre,
            ]);

            $jugador->setEstadoPublicacion($estado);
        }

        if ($this->posiciones_agrupadas !== null) {
            $posiciones = [];
            $datosPosiciones = explode(" :: ", $this->posiciones_agrupadas);
            foreach($datosPosiciones as $datosPosicion) {
                $camposPosicion = explode(":", $datosPosicion);
                $posicion = new Posicion;
                $posicion->cargarDatosDeArray([
                    'posicion_id' => $camposPosicion[0],
                    'nombre' => $camposPosicion[1],
                ]);
                $posiciones[] = $posicion;
            }
            $jugador->setPosiciones($posiciones);
        }

        return $jugador;
    }
}
