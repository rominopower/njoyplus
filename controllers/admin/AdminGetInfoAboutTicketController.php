<?php 
class AdminGetInfoAboutTicketController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->display = 'view';
        $this->id_lang = $this->context->language->id;
        $this->default_form_language = $this->context->language->id;
    }

    public function initContent()
    {
        parent::initContent();
        $this->context->controller->bootstrap=true;
         $this->context->smarty->assign('cantidad', 'gne');


        $this->setTemplate('admin2.tpl');
    } 

    public function hookActionAdminControllerSetMedia($params)
    { 
        // Adds your's CSS file from a module's directory
        $this->context->controller->addCSS($this->_path . 'views/css/example.css'); 
    
        // Adds your's JavaScript file from a module's directory
        $this->context->controller->addJS($this->_path . 'views/js/example.js');
    } 
    
}