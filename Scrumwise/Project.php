<?php

class Project
	extends ScrumwiseObject
{
	public function __construct($name) {
		parent::__construct($name);

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
		$obj = new BacklogItem($name);
		$this->backlogItems[] = $obj;
		$obj->create($this->id);
		return $obj;
	}
	public function getBacklogItem($name) {
		foreach($this->backlogItems as $obj) {
			if($obj->name == $name)
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

	public function getSprint($name) {
		foreach($this->sprints as $obj) {
			if($obj->name == $name)
				return $obj;
		}
		return NULL;
	}

	public function addTag($name) {
		$obj = new Tag($name);
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
}
