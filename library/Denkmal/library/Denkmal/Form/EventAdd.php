<?php

class Denkmal_Form_EventAdd extends CM_Form_Abstract {

    protected function _initialize() {
        $this->registerField(new Denkmal_FormField_Venue(['name' => 'venue', 'enableChoiceCreate' => true]));
        $this->registerField(new CM_FormField_Text(['name' => 'venueAddress']));
        $this->registerField(new CM_FormField_Url(['name' => 'venueUrl']));

        $this->registerField(new CM_FormField_Date(['name' => 'date', 'yearFirst' => date('Y'), 'yearLast' => (int) date('Y') + 1]));
        $this->registerField(new Denkmal_FormField_Time(['name' => 'fromTime']));
        $this->registerField(new Denkmal_FormField_Time(['name' => 'untilTime']));

        $this->registerField(new CM_FormField_Text(['name' => 'title']));
        $this->registerField(new CM_FormField_Text(['name' => 'artists']));
        $this->registerField(new CM_FormField_Text(['name' => 'genres']));
        $this->registerField(new CM_FormField_Text(['name' => 'urls']));

        $this->registerAction(new Denkmal_FormAction_EventAdd_Create($this));
        $this->registerAction(new Denkmal_FormAction_EventAdd_Preview($this));
    }

    public function prepare(CM_Frontend_Environment $environment, CM_Frontend_ViewResponse $viewResponse) {
        $this->getField('date')->setValue(new DateTime());
        $fromTime = new DateTime();
        $fromTime->setTime(22, 00);
        $this->getField('fromTime')->setValue($fromTime);
    }

    /**
     * @param Denkmal_Params $params
     * @return Denkmal_Model_Venue
     */
    public static function getVenueFromData(Denkmal_Params $params) {
        /** @var Denkmal_Params $params */
        $venue = $params->get('venue');
        if (!$venue instanceof Denkmal_Model_Venue) {
            $name = (string) $venue;
            $venue = Denkmal_Model_Venue::findByNameOrAlias($name);

            if (null === $venue) {
                $address = $params->has('venueAddress') ? $params->getString('venueAddress') : null;
                $url = $params->has('venueUrl') ? $params->getString('venueUrl') : null;

                $venue = new Denkmal_Model_Venue();
                $venue->setName($name);
                $venue->setUrl($url);
                $venue->setAddress($address);
                $venue->setCoordinates(null);
                $venue->setQueued(true);
                $venue->setIgnore(false);
                $venue->setSuspended(false);
                $venue->setEmail(null);
                $venue->setTwitterUsername(null);
            }
        }
        return $venue;
    }

    /**
     * @param Denkmal_Params $params
     * @return Denkmal_Model_Event
     */
    public static function getEventFromData(Denkmal_Params $params) {
        $date = $params->getDateTime('date');
        $from = clone $date;
        $from->add($params->getDateInterval('fromTime'));
        $until = null;
        if ($params->has('untilTime')) {
            $until = clone $date;
            $until->add($params->getDateInterval('untilTime'));
            if ($until < $from) {
                $until->add(new DateInterval('P1D'));
            }
        }

        $artists = $params->has('artists') ? $params->getString('artists') : null;
        $title = $params->has('title') ? $params->getString('title') : null;
        $genres = $params->has('genres') ? new Denkmal_Scraper_Genres($params->getString('genres')) : null;
        $description = new Denkmal_Scraper_Description($artists, $title, $genres);

        $eventDescription = $description->getAll();
        if ($params->has('urls')) {
            $eventDescription .= ' // ' . $params->get('urls');
        }

        $event = new Denkmal_Model_Event();
        $event->setDescription($eventDescription);
        $event->setEnabled(false);
        $event->setQueued(true);
        $event->setFrom($from);
        $event->setUntil($until);
        $event->setSong(null);
        $event->setHidden(false);
        $event->setStarred(false);

        return $event;
    }
}
