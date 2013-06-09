<?php

class Denkmal_Model_Event extends CM_Model_Abstract {

	const TYPE = 101;

	/**
	 * @return Denkmal_Model_Venue
	 */
	public function getVenue() {
		$venueId = $this->_get('venueId');
		return new Denkmal_Model_Venue($venueId);
	}

	/**
	 * @param Denkmal_Model_Venue $venue
	 */
	public function setVenue(Denkmal_Model_Venue $venue) {
		CM_Db_Db::update('denkmal_event', array('venueId' => $venue->getId()), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return int
	 */
	public function getFrom() {
		return (int) $this->_get('from');
	}

	/**
	 * @param int $from
	 */
	public function setFrom($from) {
		$from = (int) $from;
		CM_Db_Db::update('denkmal_event', array('from' => $from), array('id' => $this->getId()));
	}

	/**
	 * @return int|null
	 */
	public function getUntil() {
		$until = $this->_get('until');
		if (null === $until) {
			return null;
		}
		return (int) $until;
	}

	/**
	 * @param int|null $until
	 */
	public function setUntil($until) {
		$until = isset($until) ? (int) $until : null;
		CM_Db_Db::update('denkmal_event', array('until' => $until), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return (string) $this->_get('description');
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$description = (string) $description;
		CM_Db_Db::update('denkmal_event', array('description' => $description), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return Denkmal_Model_Song|null
	 */
	public function getSong() {
		$songId = $this->_get('songId');
		if (null === $songId) {
			return null;
		}
		return new Denkmal_Model_Song($songId);
	}

	/**
	 * @param Denkmal_Model_Song $song
	 */
	public function setSong(Denkmal_Model_Song $song = null) {
		$songId = isset($song) ? (int) $song->getId() : null;
		CM_Db_Db::update('denkmal_event', array('songId' => $songId), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return boolean
	 */
	public function getQueued() {
		return (boolean) $this->_get('queued');
	}

	/**
	 * @param boolean $queued
	 */
	public function setQueued($queued) {
		$queued = (boolean) $queued;
		CM_Db_Db::update('denkmal_event', array('queued' => $queued), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return boolean
	 */
	public function getEnabled() {
		return (boolean) $this->_get('enabled');
	}

	/**
	 * @param boolean $enabled
	 */
	public function setEnabled($enabled) {
		$enabled = (boolean) $enabled;
		CM_Db_Db::update('denkmal_event', array('enabled' => $enabled), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return boolean
	 */
	public function getHidden() {
		return (boolean) $this->_get('hidden');
	}

	/**
	 * @param boolean $hidden
	 */
	public function setHidden($hidden) {
		$hidden = (boolean) $hidden;
		CM_Db_Db::update('denkmal_event', array('hidden' => $hidden), array('id' => $this->getId()));
		$this->_change();
	}

	/**
	 * @return boolean
	 */
	public function getStarred() {
		return (boolean) $this->_get('starred');
	}

	/**
	 * @param boolean $starred
	 */
	public function setStarred($starred) {
		$starred = (boolean) $starred;
		CM_Db_Db::update('denkmal_event', array('starred' => $starred), array('id' => $this->getId()));
		$this->_change();
	}

	protected function _loadData() {
		return CM_Db_Db::select('denkmal_event', array('*'), array('id' => $this->getId()))->fetch();
	}

	protected function _onDelete() {
		CM_Db_Db::delete('denkmal_event', array('id' => $this->getId()));
	}

	protected static function _create(array $data) {
		$data = Denkmal_Params::factory($data);

		$venue = $data->getVenue('venue');
		$from = $data->getInt('from');
		$until = $data->has('until') ? $data->getInt('until') : null;
		$description = $data->getString('description');
		$song = $data->has('song') ? $data->getSong('song') : null;
		$queued = $data->getBoolean('queued');
		$enabled = $data->getBoolean('enabled');
		$hidden = $data->getBoolean('hidden', false);
		$star = $data->getBoolean('starred', false);

		$songId = isset($song) ? $song->getId() : null;

		$id = CM_Db_Db::insert('denkmal_event', array(
			'venueId'     => $venue->getId(),
			'from'        => $from,
			'until'       => $until,
			'description' => $description,
			'songId'      => $songId,
			'queued'      => $queued,
			'enabled'     => $enabled,
			'hidden'      => $hidden,
			'starred'     => $star,
		));

		return new static($id);
	}
}