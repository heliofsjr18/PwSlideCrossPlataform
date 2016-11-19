<?php 	 
  
class mainClass
{
    //Every Systems Component
	private $textEntry;
	private $windowPrincipal;
	private $aboutWindow;
	private $spinButtonEntry;

    public function __construct()
    {                  
            
        $glade = new GladeXML('C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\MyGladeFiles\FormPrincipal.glade');
        $this->windowPrincipal = new GtkWindow();                                    
               
               
        $this->windowPrincipal = $glade->get_widget('windowPrincipal');
        $this->windowPrincipal->connect_simple('destroy', array('Gtk', 'main_quit'));
        $this->windowPrincipal->set_size_request( 600 , 260);
        //$this->windowPrincipal->set_parent($this->aboutWindow);
        $this->windowPrincipal->show_all();              
        
                
        $this->aboutWindow = new GtkAboutDialog();
        $this->aboutWindow->set_modal(1);        
        $this->aboutWindow->set_name('Slide it!!!');
        $this->aboutWindow->set_version('0.3');                
        $this->aboutWindow->set_copyright('Copyright (C) 2016 - ?? Desenvolvido por Helio Ferreira'."\n(Usando o glade como ferramenta para construir o Form)");                   
        $this->aboutWindow->set_logo($this->aboutWindow->render_icon(Gtk::STOCK_CDROM, Gtk::ICON_SIZE_LARGE_TOOLBAR));
        //$this->aboutWindow->set_position(5000);        

    	$this->textEntry = new GtkEntry();
        $this->textEntry = $glade->get_widget('entry1');
        
        $this->spinButtonEntry = new GtkSpinButton();
        $this->spinButtonEntry = $glade->get_widget('spinbuttonQuantidade');        


        $menuSobre = new GtkImageMenuItem();        
        $menuSobre = $glade->get_widget('menuSobre');
        $menuSobre->connect_simple('activate' ,array($this, 'on_menuSobreClicked'));

        $Downloadbutton = new GtkButton();
        $Downloadbutton = $glade->get_widget('buttonDownload');
        $Downloadbutton->connect_simple('clicked' ,array($this, 'on_buttonClicked'));
                       
    }



    public function on_menuSobreClicked() 
    {                       
        $this->aboutWindow->run();      
    }
    
                      

    public function on_buttonClicked()
    {        
    	$text = $this->textEntry->get_text();
    	$textSpin = $this->spinButtonEntry->get_value_as_int(); 
    	$key = "3551865-6e82c33b15bb737c30d00e864" ;
		//$response = file_get_contents("http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=3");
        $response = file_get_contents("http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=".$textSpin);
		echo "http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=".$textSpin;
		$response = json_decode($response,true);
		$cont = 0;
		foreach ($response["hits"] as &$value)
		{
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
				
		echo "Imagem Salva!!!!!!!!";

		exec('reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v Wallpaper /t REG_SZ /d C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\images\3 /f');		
		exec(' RUNDLL32.EXE user32.dll, UpdatePerUserSystemParameters ');

		echo "imagem Setada!!!!!!!!";     
    }
}

$mainObject = new mainClass();
Gtk::Main();

 ?>
