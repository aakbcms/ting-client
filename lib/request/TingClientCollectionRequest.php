<?php

class TingClientCollectionRequest extends TingClientSearchRequest {
  protected $id;
  protected $agency;

  public function getObjectId() {
    return $id;
  }

  public function setObjectId($id) {
    $this->id = $id;
  }

  public function getAgency() {
    return $this->agency;
  }

  public function setAgency($agency) {
    $this->agency = $agency;
  }

  public function getRequest() {
    if ($this->agency && variable_get('ting_filter_by_local_holdings', 0)) {
      $this->setQuery('rec.id=' . $this->id . ' and holdingsitem.agencyid=' . $this->agency);
    }
    else {
      $this->setQuery('rec.id=' . $this->id);
    }
    $this->setAgency($this->agency);
    $this->setAllObjects(true);
    $this->setNumResults(1);

    return parent::getRequest();
  }

  public function processResponse(stdClass $response) {
    $response = parent::processResponse($response);

    if (isset($response->collections[0])) {
      return $response->collections[0];
    }
  }
}

