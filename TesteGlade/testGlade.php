<?php 	 
  
class mainClass
{
	private $entry;

    public function __construct()
    {
        $glade = new GladeXML('C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\MyGladeFiles\FormPrincipal.glade');
        $windowPrincipal = new GtkWindow();                    

               
        $windowPrincipal = $glade->get_widget('windowPrincipal');
        $windowPrincipal->connect_simple('destroy', array('Gtk', 'main_quit'));
        $windowPrincipal->set_size_request( 600 , 260);
        $windowPrincipal->show_all();

    	$this->entry = new GtkEntry();
        $this->entry = $glade->get_widget('entry1');        


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
    	$text = $this->entry->get_text(); 
    	$key = "3551865-6e82c33b15bb737c30d00e864" ;
		$response = file_get_contents("http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=3");

		echo "http://pixabay.com/api/?key=" . $key . "&q=".$text."&image_type=photo&per_page=20";
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

		exec('reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v Wallpaper /t REG_SZ /d C:\Users\helio\Desktop\GitHubCollegeProjects\PwSlideCrossPlataform\TesteGlade\images\2.jpg /f');		
		exec(' RUNDLL32.EXE user32.dll, UpdatePerUserSystemParameters ');

		echo "imagem Setada!!!!!!!!";     
    }
}

$mainObject = new mainClass();
Gtk::Main();

 ?>
