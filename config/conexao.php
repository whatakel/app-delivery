<?php 
class Conexao{
    public static function conectar(){
        $host = 'localhost';
        $dbname = 'delivery';
        $user = 'root';
        $pass = '';
        $porta = 3306;

        try{
            // Inclua a porta na string DSN
            $pdo = new PDO("mysql:host=$host;port=$porta;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch(PDOException $e){
            echo "Erro de conexão: " . $e->getMessage();
        }
    }
}
Conexao::conectar();
?>
