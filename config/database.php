return {
// Configurações para se conectar ao Banco de Dados MySQL
    'host' => '192.168.0.1',
    'user' => 'root',
    'password' => '',
    'database' => 'biblioteca'
};

 public function connect() {
    // Conexão com o banco de dados usando as configurações acima
    $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
    
    if ($connection->connect_error) {
        die("Conexão falhou: " . $connection->connect_error);
    }
    
    return $connection;

    //Pelo menos esse eu consegui  instalar no WSL e rodar o banco na máquina para usar como MySQL