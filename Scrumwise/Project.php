<?php

class Project
	extends ScrumwiseObject
{
	public function __construct($name) {
		parent::__construct(NULL, $name);

		$this->data['description'] = NULL;
		$this->data['externalID'] = NULL;
		$this->data['link'] = NULL;
		$this->data['status'] = NULL;
		$this->data['detailedEstimateUnit'] = NULL;
		$this->data['roughEstimateUnit'] = NULL;
		$this->data['timeTrackingUnit'] = NULL;

		$this->data['comments'] = [];
		$this->data['attachments'] = [];
		$this->data['tags'] = [];
		$this->data['productOwnerIDs'] = [];
		$this->data['stakeholderIDs'] = [];
		$this->data['teams'] = [];
		$this->data['backlogItems'] = [];
		$this->data['releases'] = [];
		$this->data['sprints'] = [];
		$this->data['boards'] = [];

		$this->hasSetter['externalID'] = true;
	}

	public static function instantiate($data) {
		return parent::instantiate(NULL, $data);
	}

	protected function validateDetailedEstimateUnit($unit) {
		return $this->validateUnit($unit);
	}
	protected function validateRoughEstimateUnit($unit) {
		return $this->validateUnit($unit);
	}
	protected function validateTimeTrackingUnit($unit) {
		return $this->validateUnit($unit);
	}
	protected function validateUnit($unit) {
		switch($unit) {
		case 'Points':
		case 'Days':
		case 'Hours':
			return $unit;
		}
		return NULL;
	}

	public function addBacklogItem($name) {
		$obj = new BacklogItem($this, $name);
		$this->backlogItems[] = $obj;
		$obj->create($this->id);
		return $obj;
	}
	public function getBacklogItem($name) {
		$id = is_numeric($name) ? (int)$name : -1;
		foreach($this->backlogItems as $obj) {
			if($id != -1 && $obj->itemNumber == $id)
				return $obj;
			if($id == -1 && $obj->name == $name)
				return $obj;
		}
		return NULL;
	}
	public function getBacklogItemsByRelease($release) {
		if(is_string($release)) {
			$release = $this->getRelease($release);
		}
		if($release instanceof Release) {
			$releaseID = $release->id;
		} else {
			echo "Could not find release '$release'\n";
			die;
		}

		$bs = [];
		foreach($this->backlogItems as $b) {
			if($b->releaseID == $releaseID) {
				$bs[] = $b;
			}
		}

		return $bs;
	}
	public function getBacklogItemsBySprint($sprint) {
		if(is_string($sprint)) {
			$sprint = $this->getSprint($sprint);
		}
		if($sprint instanceof Sprint) {
			$sprintID = $sprint->id;
		} else {
			echo "Could not find sprint '$sprint'\n";
			die;
		}

		$bs = [];
		foreach($this->backlogItems as $b) {
			if($b->sprintID == $sprintID) {
				$bs[] = $b;
			}
		}

		return $bs;
	}

	public function getRelease($name) {
		foreach($this->releases as $obj) {
			if($obj->name == $name)
				return $obj;
		}
		return NULL;
	}
	public function getReleaseById($releaseID) {
		if(is_null($releaseID))
			return NULL;
		foreach($this->releases as $obj) {
			if($obj->id == $releaseID)
				return $obj;
		}
		return NULL;
	}

	public function getCurrentSprint() {
		foreach($this->sprints as $obj) {
			if($obj->isInProgress())
				return $obj;
		}
		return NULL;
	}
	public function getSprint($name) {
		foreach($this->sprints as $obj) {
			if($obj->name == $name)
				return $obj;
		}
		return NULL;
	}
	public function getSprintById($sprintID) {
		if(is_null($sprintID))
			return NULL;
		foreach($this->sprints as $obj) {
			if($obj->id == $sprintID)
				return $obj;
		}
		return NULL;
	}

	public function addTag($name) {
		$obj = new Tag($this, $name);
		$this->tags[] = $obj;
		$obj->create($this->id);
		return $obj;
	}
	public function getTag($name) {
		foreach($this->tags as $obj) {
			if($obj->name == $name)
				return $obj;
		}
		return NULL;
	}

	public function getTeamByID($teamID) {
		if(is_null($teamID))
			return NULL;
		foreach($this->teams as $obj) {
			if($obj->id == $teamID)
				return $obj;
		}
		return NULL;
	}
}
