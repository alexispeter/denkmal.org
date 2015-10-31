<?php

class Denkmal_Elasticsearch_Type_Event extends CM_Elasticsearch_Type_Abstract {

    protected $_mapping = array(
        'from'        => array('type' => 'date'),
        'until'       => array('type' => 'date'),
        'description' => array('type' => 'string'),
        'queued'      => array('type' => 'boolean'),
        'enabled'     => array('type' => 'boolean'),
        'hidden'      => array('type' => 'boolean'),
        'starred'     => array('type' => 'boolean'),
    );

    protected $_indexParams = array(
        'number_of_shards'   => 1,
        'number_of_replicas' => 0
    );

    protected function _getQuery($ids = null, $limit = null) {
        $query = '
            SELECT `event`.*
            FROM `denkmal_model_event` `event`
        ';

        if (is_array($ids)) {
            $query .= ' WHERE event.id IN (' . implode(',', $ids) . ')';
        }
        if (($limit = (int) $limit) > 0) {
            $query .= ' LIMIT ' . $limit;
        }
        return $query;
    }

    protected function _getDocument(array $data) {
        $doc = new CM_Elasticsearch_Document($data['id'],
            array(
                'from'        => $this->convertDate((int) $data['from']),
                'description' => (string) $data['description'],
                'queued'      => (bool) $data['queued'],
                'enabled'     => (bool) $data['enabled'],
                'hidden'      => (bool) $data['hidden'],
                'starred'     => (bool) $data['starred'],
            )
        );
        if (null !== $data['until']) {
            $doc->set('until', $this->convertDate((int) $data['until']));
        }
        return $doc;
    }

    public static function getAliasName() {
        return 'event';
    }

    /**
     * @param Denkmal_Model_Event $item
     * @return int
     */
    protected static function _getIdForItem($item) {
        return $item->getId();
    }
}
