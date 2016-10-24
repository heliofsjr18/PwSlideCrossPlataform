<?php 	 
  
class mainClass
{
        
    public function __construct()
    {
        $glade = new GladeXML('C:\php-gtk2\MyGladeFiles\FormPrincipal.glade');
        $windowPrincipal = new GtkWindow();             
               
        $windowPrincipal = $glade->get_widget('windowPrincipal');
        $windowPrincipal->connect_simple('destroy', array('Gtk', 'main_quit'));
        $windowPrincipal->set_size_request( 600 , 260);
        $windowPrincipal->show_all();
        
        
        $menuSobre = new GtkImageMenuItem();        
        $menuSobre = $glade->get_widget('menuSobre');
        $menuSobre->connect_simple('activate' ,array($this, 'on_menuSobreClicked'));
                       
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
    
}

$mainObject = new mainClass();
Gtk::Main();

 ?>
