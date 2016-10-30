<?php 	 
  
class mainClass
{
        
    public function __construct()
    {
        $glade = new GladeXML('C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\MyGladeFiles\FormPrincipal.glade');
        $windowPrincipal = new GtkWindow();             
               
        $windowPrincipal = $glade->get_widget('windowPrincipal');
        $windowPrincipal->connect_simple('destroy', array('Gtk', 'main_quit'));
        $windowPrincipal->set_size_request( 600 , 260);
        $windowPrincipal->show_all();
        
        
        $menuSobre = new GtkImageMenuItem();        
        $menuSobre = $glade->get_widget('menuSobre');
        $menuSobre->connect_simple('activate' ,array($this, 'on_menuSobreClicked'));

        $Downloadbutton = new GtkButton();
        $Downloadbutton = $glade->get_widget('buttonDownload');
        $Downloadbutton->connect_simple('clicked' ,array($this, 'on_buttonClicked'));
                       
    }

    public function on_menuSobreClicked() 
    {    
            
        $aboutWindow = new GtkAboutDialog();
        $aboutWindow->set_modal(1);        
        $aboutWindow->set_name('Slide it!!!');
        $aboutWindow->set_version('0.3');                
        $aboutWindow->set_copyright('Copyright (C) 2016 - ?? Desenvolvido por Helio Ferreira'."\n(Usando o glade como ferramenta para construir o Form)");                   
        $aboutWindow->set_logo($aboutWindow->render_icon(Gtk::STOCK_CDROM, Gtk::ICON_SIZE_LARGE_TOOLBAR));        
        $aboutWindow->run();      
    }                  

    public function on_buttonClicked()
    {
    	/*
    	
    	//echo "passei";
    	$key = "3551865-6e82c33b15bb737c30d00e864" ;
		$response = file_get_contents("http://pixabay.com/api/?key=" . $key . "&q=Guitarra&image_type=photo&per_page=20");
		$response = json_decode($response,true);
		$imagem = array();
		$cont = 0;
		foreach ($response["hits"] as &$value)
		{
			$cont++;
			//echo "<img src =\"" . $value["webformatURL"] . "\" >";
			/*if ($value["imageWidth"] / $value["imageHeight"] = 1.6) 
			{
				//$getImage = file_get_contents($value["webformatURL"]);
				//echo $getImage;
				//@copy($value["webformatURL"],'/' .$cont . ".jpg");
				//readfile($value["webformatURL"]);
				echo "passei por aqui";
				exec("php -r \"readfile('".$value["imageWidth"]."');\" > C:\Users\aluno\Desktop\projeto pw\trunk\TesteGlade".$cont.".jpg"." ");
			}

			$ch = curl_init();
			//echo "curl_init()";
			curl_setopt($ch, CURLOPT_URL, $value["webformatURL"]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//echo "curl_setopt()";
			$data = curl_exec($ch);
			//echo "curl_exec()";
			echo $data;
			
			*/
			
			
            $postImageName = 'programa-imagem-som';
            $postImageUrl = 'http://publicador.tvcultura.com.br/upload/tvcultura/programas/programa-imagem-som.jpg';
            //$postImageExt = '.jpg';
            
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
                file_put_contents("C:\\Users\\helio\\Desktop\\GitHubCollegeProjects\\PwSlideCrossPlataform\\TesteGlade\\images\\"  , $rawImage);
                echo "Imagem salva!";
            } else {
                echo "Erro ao pegar imagem da url";
            }
			
		
     
    }
}

$mainObject = new mainClass();
Gtk::Main();

 ?>
