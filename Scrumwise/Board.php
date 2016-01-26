<?php

class Board
	extends ScrumwiseObject
{
	public function __construct($project, $name) {
		parent::__construct($project, $name);

		$this->data['externalID'] = NULL;
		$this->data['projectID'] = NULL;
		$this->data['description'] = NULL;
		$this->data['type'] = NULL;
		$this->data['status'] = NULL;

		$this->data['columns'] = [];
		$this->data['assignedBacklogItemIDs'] = [];

		$this->hasSetter['externalID'] = true;
	}

	public function getBoardColumnById($boardColumnID) {
		if(is_null($boardColumnID))
			return NULL;
		foreach($this->columns as $obj) {
			if($obj->id == $boardColumnID)
				return $obj;
		}
		return NULL;
	}
}
