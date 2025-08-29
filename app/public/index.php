<?php

use App\Core\Router;

// Carrega o autoload do Composer
require __DIR__ . '/../../vendor/autoload.php';
// Inicia a sessão
session_start();

//Load simples, carrega as classes automaticamente quando são instanciadas.
?>

<h1>Meu Servidor PHP Funciona!</h1> 

<?php phpinfo(); ?>

   <?php

//Router
require __DIR__ . '/../app/core/Router.php';


//Verificar se faltou algo no index.php: Parece tá tudo ok, testar depois
