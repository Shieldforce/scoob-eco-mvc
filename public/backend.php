<?php

if (isset($_POST['screenshot'])) {
    $imgData = $_POST['screenshot'];

    // Remove o prefixo 'data:image/png;base64,'
    $imgData = str_replace('data:image/png;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);

    // Decodifica a imagem
    $data = base64_decode($imgData);

    // Salva no servidor
    $fileName = 'screenshot_' . time() . '.png';
    $path = str_replace('/public', '/assets/imgs/screenshots', __DIR__);
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }

    file_put_contents( $path . '/' . $fileName, $data);

    echo "Imagem salva com sucesso como: $fileName";
} else {
    echo "Nenhuma imagem recebida.";
}