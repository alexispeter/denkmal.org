<?php

class Admin_Page_Venues extends Admin_Page_Abstract {

    public function prepare(CM_Frontend_Environment $environment, CM_Frontend_ViewResponse $viewResponse) {
        $searchTerm = $this->_params->has('searchTerm') ? $this->_params->getString('searchTerm') : null;
        if ('' === $searchTerm) {
            $searchTerm = null;
        }
        $region = $this->_hasRegion() ? $this->_getRegion() : null;

        $viewResponse->set('region', $region);
        $viewResponse->set('searchTerm', $searchTerm);
    }
}
