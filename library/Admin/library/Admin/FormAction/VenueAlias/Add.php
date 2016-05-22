<?php

class Admin_FormAction_VenueAlias_Add extends Admin_FormAction_Abstract {

    protected function _getRequiredFields() {
        return array('name');
    }

    protected function _checkData(CM_Params $params, CM_Http_Response_View_Form $response, CM_Form_Abstract $form) {
        parent::_checkData($params, $response, $form);
        $name = $params->getString('name');
        if ($venue = Denkmal_Model_Venue::findByNameOrAlias($name)) {
            $response->addError($response->getRender()->getTranslation('Name already in use.'), 'name');
        }
    }

    protected function _process(CM_Params $params, CM_Http_Response_View_Form $response, CM_Form_Abstract $form) {
        /** @var Denkmal_Params $params */
        $venue = $params->getVenue('venueId');
        $name = $params->getString('name');

        Denkmal_Model_VenueAlias::create($venue, $name);

        $response->reloadComponent();
    }
}
