<?php
// Carrega o autoload do Composer
require __DIR__ . '/../vendor/autoload.php';
// Inicia a sessão
session_start();

//Load simples, carrega as classes automaticamente quando são instanciadas.
spl_autoload_register(function ($class) {

    // Array de diretórios
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/core/' . $class . '.php',
    ];

    // Loop pelos diretorios
    foreach ($paths as $file) {
        // Checa se existe o arquivo    
        if (file_exists($file)) {
            // Requer o arquivo e sai do loop
            require_once $file;
            return;
        }
    }
});

//Router
require __DIR__ . '/../app/core/Router.php';


//Verificar se faltou algo no index.php: Parece tá tudo ok, testar depois
