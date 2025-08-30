return{
    'driver' => 's3',
    'bucket' => env('AWS_BUCKET'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'version' => 'latest',
    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),],
};

/*Mantive para mostrar onde ficaria as configurações do S3 ou Cloudflare R2 ou Backblaze B2
* mas tive problemas em utilizá-los, ou bloqueio ou com pagamento utilizando cartão internacional.*/