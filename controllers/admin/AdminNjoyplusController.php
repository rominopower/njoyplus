<?php 
class AdminNjoyplusController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->display = 'view';
        $this->id_lang = $this->context->language->id;
        $this->default_form_language = $this->context->language->id;
        $this->records_per_page = 100;

    }

    public function initContent()
    {
        parent::initContent();
        $this->context->controller->bootstrap=true;
         $this->context->smarty->assign('token', Tools::getAdminToken('AdminNjoyplus'.(int)(Tab::getIdFromClassName('AdminNjoyplus')).(int)$this->context->employee->id));

       

        if(isset($_GET["action"])) {
            $action = $_GET["action"];
           switch($action) {
                case "messages":
                    $this->getLastMessages();
                    break;
                case "virtual_tickets":
                    $this->getVirtualTickets();
                    break;
                case "info_about_tickets":
                    $this->getInfoAboutTickets();
                    break;
                default:
                    $this->setTemplate('admin2.tpl');
                    break;
            }
        } else {
        $this->setTemplate('admin2.tpl');
        }        
    } 



private function getLastMessages() {
    if(isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }


    $offset = ($page-1) * $this->records_per_page;

    $tsql = "SELECT COUNT(*) FROM "._DB_PREFIX_."themepark_tickets";
    $tot = Db::getInstance()->getValue($tsql);
    $total_pages = ceil($tot / $this->records_per_page);

    $sql = sprintf("select * from "._DB_PREFIX_."themepark_tickets order by id desc limit %s,%s", $offset, $this->records_per_page);
    $r = Db::getInstance()->executeS($sql);
    $rows = [];
$x= 0;
    foreach ($r as $_row) {

         $_error = strstr($_row['comment'],"reactivado correctamente");
         if (empty($_error)){
            $_row['comment'] = '<div style="color:red">' .$_row["comment"]. '</div>';
         } 
 
        //$_rows_in_html .= get_column($_row['ip']);
        $rows[$x] = $_row;
        $x++;
    }
    

    $this->context->smarty->assign('db', $rows);
    $this->context->smarty->assign('tot', $total_pages);
    $this->context->smarty->assign('page', $page);
    $this->setTemplate('admin3.tpl');

}

private function getInfoAboutTickets() {
    $sql = "select l.name,v.ean13,v.restantes as stock from v_njoy_tickets_free_stock v, "._DB_PREFIX_."product p,"._DB_PREFIX_."product_lang l where v.ean13=p.reference and p.id_product=l.id_product and l.id_lang=1 and v.ean13 like '84%' and p.is_virtual=1 UNION select l.name,v.ean13,v.restantes from v_njoy_tickets_free_stock v, "._DB_PREFIX_."product p,"._DB_PREFIX_."product_lang l where v.ean13=p.reference and p.id_product=l.id_product and l.id_lang=1 and v.ean13 like '1234%' and p.is_virtual=1";
    $r = Db::getInstance()->executeS($sql);
    $rows = [];
$x= 0;
    foreach ($r as $_row) {
        //$_rows_in_html .= get_column($_row['ip']);
        $rows[$x] = $_row;
        $x++;
    }
    
    $this->context->smarty->assign('db', $rows);
   $this->setTemplate('admin5.tpl');
}

public function getVirtualTickets() {

    $sql = sprintf("select * from njoy_tickets order by order_id desc LIMIT %s,%s", 0, 400);
    $r = Db::getInstance()->executeS($sql);
    $rows = [];
$x= 0;
    foreach ($r as $_row) {
        //$_rows_in_html .= get_column($_row['ip']);
        $rows[$x] = $_row;
        $x++;
    }
    
    $this->context->smarty->assign('db', $rows);
   $this->setTemplate('admin4.tpl');
}


    public function hookActionAdminControllerSetMedia($params)
    { 
        // Adds your's CSS file from a module's directory
        $this->context->controller->addCSS($this->_path . 'views/css/example.css'); 
    
        // Adds your's JavaScript file from a module's directory
        $this->context->controller->addJS($this->_path . 'views/js/example.js');
    } 
    
}