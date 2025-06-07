<?php 
class Conexao{
    public static function conectar(){
        $host = 'localhost';
        $dbname = 'delivery';
        $user = 'root';
        $pass = '';
        
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch(PDOException $e){
            echo "Erro de conexão: " . $e->getMessage();
        }
    }
}
Conexao::conectar();
?>