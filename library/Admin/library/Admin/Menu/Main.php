<?php

class Admin_Menu_Main extends CM_Menu {

    public function __construct() {
        parent::__construct(array(
            array('label' => 'Veranstaltungen', 'page' => 'Admin_Page_Events'),
            array('label' => 'Orte', 'page' => 'Admin_Page_Venues'),
            array('label' => 'Links', 'page' => 'Admin_Page_Links'),
            array('label' => 'Lieder', 'page' => 'Admin_Page_Songs'),
            array('label' => 'Mehr…', 'page' => 'Admin_Page_Settings', 'submenu' => array(
                array('label' => 'Einstellungen', 'page' => 'Admin_Page_Settings'),
                array('label' => 'Fehler', 'page' => 'Admin_Page_Log', 'params' => array('type' => CM_Paging_Log_Error::getTypeStatic())),
                array('label' => 'Warning', 'page' => 'Admin_Page_Log', 'params' => array('type' => CM_Paging_Log_Warn::getTypeStatic())),
                array('label' => 'JS Error', 'page' => 'Admin_Page_Log', 'params' => array('type' => CM_Paging_Log_JsError::getTypeStatic())),
            )),
        ));
    }
}
