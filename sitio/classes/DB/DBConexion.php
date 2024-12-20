<?php
namespace App\DB;

use Exception;
use PDO;

class DBConexion
{
    private string $db_host     = "localhost";
    private string $db_name     = "dw3_crupnicoff_lara";
    private string $db_charset  = "utf8mb4";
    private string $db_user     = "root";
    private string $db_pass     = "";

    private PDO $db;

    public function __construct()
    {
        $db_dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=" . $this->db_charset;

        try {
            $this->db = new PDO($db_dsn, $this->db_user, $this->db_pass);
        } catch(Exception $e) {
            echo "Error al conectar con la base de datos. Por favor, intentá de nuevo más tarde.";
            exit;
        }
    }

    public function getDB(): PDO
    {
        return $this->db;
    }
}
