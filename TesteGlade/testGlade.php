<?php 	 
  
class mainClass
{
    //Declaração dos componentes do sitema
	private $textEntry;
	private $windowPrincipal;
	private $aboutWindow;
	private $spinButtonEntry;
	private $progressoLabel;
	private $progressoBar;
	private $dialogInformation;


    //COMEÇO - INICIALIZAÇÃO DE COMPONENTES NO CONTRUTOR
    public function __construct()
    {                  
            
        $glade = new GladeXML('C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\MyGladeFiles\FormPrincipal.glade');
        $this->windowPrincipal = new GtkWindow();                                    
               
               
        $this->windowPrincipal = $glade->get_widget('windowPrincipal');
        $this->windowPrincipal->connect_simple('destroy', array('Gtk', 'main_quit'));
        $this->windowPrincipal->set_size_request( 600 , 260);
        $this->windowPrincipal->show_all();              
        
                
        $this->aboutWindow = new GtkAboutDialog();
        $this->aboutWindow->set_position(Gtk::WIN_POS_CENTER_ALWAYS);
        $this->aboutWindow->set_modal(1);        
        $this->aboutWindow->set_name('Slide it!!!');
        $this->aboutWindow->set_version('0.3');                
        $this->aboutWindow->set_copyright('Copyright (C) 2016 - ?? Desenvolvido por Helio Ferreira'."\n(Usando o glade como ferramenta para construir o Form)");                   
        $this->aboutWindow->set_logo($this->aboutWindow->render_icon(Gtk::STOCK_CDROM, Gtk::ICON_SIZE_LARGE_TOOLBAR));                

    	$this->textEntry = new GtkEntry();
        $this->textEntry = $glade->get_widget('entry1');
        
        $this->spinButtonEntry = new GtkSpinButton();
        $this->spinButtonEntry = $glade->get_widget('spinbuttonQuantidade'); 
        
        $this->progressoLabel = new GtkLabel();
        $this->progressoLabel = $glade->get_widget('progresso');
        
        $this->progressoBar = new GtkProgressBar();
        $this->progressoBar = $glade->get_widget('progressbar1');
        
        $this->dialogInformation = new GtkDialog();
        $this->dialogInformation->set_size_request(300, 100);
    	$this->dialogInformation->set_position(Gtk::WIN_POS_CENTER_ALWAYS);


        $menuSobre = new GtkImageMenuItem();        
        $menuSobre = $glade->get_widget('menuSobre');
        $menuSobre->connect_simple('activate' ,array($this, 'on_menuSobreClicked'));


        $menuSair = new GtkImageMenuItem();        
        $menuSobre = $glade->get_widget('menuSair');
        $menuSobre->connect_simple('activate' ,array($this, 'on_menuSairClicked'));


        $Downloadbutton = new GtkButton();
        $Downloadbutton = $glade->get_widget('buttonDownload');
        $Downloadbutton->connect_simple('clicked' ,array($this, 'on_buttonClicked'));
                       
    }    
    //FIM - INICIALIZAÇÃO DE COMPONENTES NO CONTRUTOR



//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------



    //COMEÇO - FUNÇÕES DOS ITENS DOS MENUS 
    public function on_menuSobreClicked() 
    {                       
        $this->aboutWindow->show();      
    }
    
    public function on_menuSairClicked() 
    {                       
        $this->windowPrincipal->destroy();      
    }
    //FIM - FUNÇÕES DOS ITENS DOS MENUS



//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------

    
                             
    //COMEÇO - FUNÇÃO BOTÃO DE DOWNLOAD 
    public function on_buttonClicked()
    {            
    	$text = $this->textEntry->get_text();
    	$textSpin = $this->spinButtonEntry->get_value_as_int();
    	
    	//Começo validação dos componentes de texto usado nas pesquisas
    	if(($text == "") or ($textSpin == 0))
    	{    	   
    	    $erroMessage = new GtkDialog("Invalid Operation");
    	    $erroMessage->set_size_request(300, 100);
    	    $erroMessage->set_position(Gtk::WIN_POS_CENTER_ALWAYS);
    	    $erroMessage->run();
    	    return;    	        	   
    	} 
    	//Fim validação dos componentes de texto usado nas pesquisas
    	
    	
    	//COMEÇO - Preparando a String usada no FILE_GET_CONTENS
    	$key = "3551865-6e82c33b15bb737c30d00e864" ;		
        $response = file_get_contents("http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=".$textSpin);
		echo "http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=".$textSpin;		
		$response = json_decode($response,true);
		$cont = 0;
		//FIM - Preparando a String usada no FILE_GET_CONTENS
		
		
		//COMEÇO - Validando existencia de imganes na pesquisa
		if (empty($response["hits"])) 
		{
            $erroMessage = new GtkDialog("Nenhuma Imagem encontrada");
    	    $erroMessage->set_size_request(300, 100);
    	    $erroMessage->set_position(Gtk::WIN_POS_CENTER_ALWAYS);
    	    $erroMessage->run();
    	    return;    	        		    
		}
		//FIM - Validando existencia de imganes na pesquisa
		
		
				
		//Inicio Download			
		foreach ($response["hits"] as &$value)
		{
		    $this->progressoLabel->set_text("Baixando Imagens");
			$cont++;
			echo "<img src =\"" . $value["webformatURL"] . "\" >";

		 	$ch = curl_init($value["webformatURL"]);
			$fp = fopen('C:\\Users\\helio\\Desktop\\GitHubCollegeProjects\\PwSlideCrossPlataform\\TesteGlade\\images\\' . $cont .'.jpg', 'wb');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
			
		}
		//Fim Download
				
		$this->dialogInformation->set_title( "Imagem Salva!!!!!!!!");
		$this->dialogInformation->show();


        //INICIO - Setando Imagen no WINDOWS;
		exec('reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v Wallpaper /t REG_SZ /d C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\images\3 /f');		
		exec(' RUNDLL32.EXE user32.dll, UpdatePerUserSystemParameters ');
        //FIM - Setando Imagen no WINDOWS;
        
		$this->dialogInformation->set_title( "imagem Setada!!!!!!!!");
		$this->dialogInformation->show();     
    }
}

$mainObject = new mainClass();
Gtk::Main();

 ?>
