<?php 
class njoyplus extends Module
{
    public function __construct(Context $context = null)
    {
        $this->name = 'njoyplus';
        $this->version = '1.2';
        $this->bootstrap = true;
        $this->author = 'Fabrizio Giannone + Toni Parada';
        $this->displayName = $this->l('Admin Njoy+');
        $this->description = $this->l('Manage tickets and more');
        
        parent::__construct();
    }

    public function install()
    {
        $tab = new Tab();
        $tab->class_name = 'AdminNjoyplus';
        $tab->module = 'njoyplus';
        $tab->name[1] = 'Admin Njoy+';
        $tab->id_parent = 2;
        $tab->active = 1;
        if (!$tab->save()) {
            return false;
        }
        return parent::install() && $this->registerHook('actionAdminControllerSetMedia');
    }

    public function uninstall()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminNjoyplus');
        $tab = new Tab($id_tab);

        if (Validate::isLoadedObject($tab)) {
            if (!$tab->delete()) {
                return false;
            }
        } else {
            return false;
        }
        return parent::uninstall();
    }
}