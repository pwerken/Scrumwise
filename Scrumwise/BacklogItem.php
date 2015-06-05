<?php

class BacklogItem
	extends ScrumwiseObject
{
	use Taggable;

	public function __construct($name) {
		parent::__construct($name);

		$this->data['externalID'] = NULL;
		$this->data['itemNumber'] = NULL;
		$this->data['projectID'] = NULL;
		$this->data['description'] = NULL;
		$this->data['link'] = NULL;
		$this->data['priority'] = NULL;
		$this->data['type'] = NULL;
		$this->data['creatorID'] = NULL;
		$this->data['releaseID'] = NULL;
		$this->data['status'] = NULL;
		$this->data['roughEstimate'] = (float)-1;
		$this->data['estimate'] = NULL;
		$this->data['usedTime'] = NULL;
		$this->data['remainingWork'] = NULL;
		$this->data['sprintID'] = NULL;
		$this->data['teamID'] = NULL;
		$this->data['boardID'] = NULL;
		$this->data['boardColumnID'] = NULL;

		$this->data['assignedPersonIDs'] = [];
		$this->data['tagIDs'] = [];
		$this->data['comments'] = [];
		$this->data['attachments'] = [];
		$this->data['timeEntries'] = [];
		$this->data['commits'] = [];
		$this->data['tasks'] = [];

		$this->canCreate['externalID'] = true;
		$this->canCreate['projectID'] = true;
		$this->canCreate['name'] = true;
		$this->canCreate['description'] = true;
		$this->canCreate['link'] = true;
		$this->canCreate['priority'] = true;
		$this->canCreate['type'] = true;
		$this->canCreate['roughEstimate'] = true;
		$this->canCreate['roughEstimateUnit'] = true;

		$this->canDelete = true;

		$this->hasSetter['creatorID'] = true;
		$this->hasSetter['description'] = true;
		$this->hasSetter['externalID'] = true;
		$this->hasSetter['link'] = true;
		$this->hasSetter['name'] = true;
		$this->hasSetter['priority'] = true;
		$this->hasSetter['type'] = true;
	}

	public function getEstimate() {
		if($this->estimate > 0)
			return $this->estimate;

		return $this->roughEstimate;
	}
	public function getRemainingWork() {
		if($this->isDone())
			return 0;
		if($this->remainingWork < 0)
			return $this->getEstimate();

		return $this->remainingWork;
	}
	public function setRoughEstimate($estimate, $unit) {
		$this->data['roughEstimate'] = (float)$estimate;
		$this->data['roughEstimateUnit'] = $this->validateRoughEstimateUnit($unit);
		$this->setter('RoughEstimate', ['roughEstimate', 'roughEstimateUnit']);
	}

	public function addTask($name) {
		$obj = new Task($this->project, $name);
		$this->tasks[] = $obj;
		$obj->create($this->id);
		return $obj;
	}
	public function getTask($name) {
		foreach($this->tasks as $obj) {
				if($obj->name == $name)
				return $obj;
		}
		return NULL;
	}
	public function getTasks() {
		return $this->tasks;
	}

	public function isDone() {
		switch($this->status) {
		case 'Done':
		case 'Sprint completed':
		case 'Released':
			return true;
		default:
			return false;
		}
	}

	protected function validatePriority($priority) {
		switch($priority) {
		case 'Low':
		case 'Medium':
		case 'High':
		case 'Urgent':
			return $priority;
		}
		return NULL;
	}
	protected function validateRoughEstimateUnit($unit) {
		switch($unit) {
		case 'Points':
		case 'Days':
		case 'Hours':
			return $unit;
		}
		return NULL;
	}
	protected function validateType($type) {
		switch($type) {
		case 'Feature':
		case 'Bug':
		case 'Spike':
		case 'Other':
			return $type;
		}
		return NULL;
	}
}
