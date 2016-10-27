<?php
        /*
         * @autor: Giliarde Martins
         * 26/10/2016
         */
        
        //verifica se os parâmetros foram passados
        if (isset($_POST['nome']) && !empty($_POST['url'])) {
            //recupera os parâmetros via POST
            $postImageName = ($_POST['nome']);
            $postImageUrl = ($_POST['url']);
            $postImageExt = ($_POST['ext']);
            
            //renomeando a imagem
            $postImageName = str_replace(" ", "", $postImageName);
            
            //abre uma session curl
            $ch = curl_init();
            //seta a imagem dentro da session
            $rawImage = curl_setopt($ch, CURLOPT_URL, $postImageName);
            //executa
            curl_exec($ch);
            //se de fato a imagem for uma imagem, então pega o nome da imagem concatena com a extensão e salva
            //a imagem dentro do diretório images/
            if ($rawImage) {
                file_put_contents("images/" . $postImageName . $postImageExt, $rawImage);
                echo "Imagem salva!";
            } else {
                echo "Erro ao pegar imagem da url";
            }
        }
?>