<?php
namespace App\Modelos;

class Carrito 
{
    public function __construct()
    {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public function agregar(int $jugadorId, int $cantidad = 1): void
    {
        // Si el jugador ya está en el carrito, sumar la cantidad
        if (isset($_SESSION['carrito'][$jugadorId])) {
            $_SESSION['carrito'][$jugadorId] += $cantidad;
        } else {
            // Si no está en el carrito, agregar con la cantidad inicial
            $_SESSION['carrito'][$jugadorId] = $cantidad;
        }
    }

    public function quitar(int $jugadorId): void
    {
        if (isset($_SESSION['carrito'][$jugadorId])) {
            unset($_SESSION['carrito'][$jugadorId]);
        }
    }

    public function getItems(): array
    {
        return $_SESSION['carrito'];
    }

    public function vaciar(): void
    {
        $_SESSION['carrito'] = [];
    }

    public function getCantidadItems(): int
    {
        return array_sum($_SESSION['carrito']);
    }

    public function getTotal(): float
    {
        $total = 0;
        $jugador = new Jugador();
        
        foreach($_SESSION['carrito'] as $jugadorId => $cantidad) {
            $item = $jugador->porId($jugadorId);
            if($item) {
                $total += $item->getPrecio() * $cantidad;
            }
        }
        
        return $total;
    }
}
