<?php

class BacklogItem
	extends ScrumwiseObject
{
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
		if($this->remainingWork > 0)
			return $this->remainingWork;

		return $this->getEstimate();
	}
	public function setRoughEstimate($estimate, $unit) {
		$this->data['roughEstimate'] = (float)$estimate;
		$this->data['roughEstimateUnit'] = $this->validateRoughEstimateUnit($unit);
		$this->setter('RoughEstimate', ['roughEstimate', 'roughEstimateUnit']);
	}

	public function addTask($name) {
		$obj = new Task($name, $this->getID());
		$this->tasks[] = $obj;
		$obj->create();
		return $obj;
	}
	public function getTask($name) {
		foreach($this->tasks as $obj) {
			if($obj->getName() == $name)
				return $obj;
		}
		return NULL;
	}
	public function getTasks() {
		return $this->tasks;
	}

	public function hasTag(Tag $tag) {
		if(empty($this->tagIDs))
			return false;
		foreach($this->tagIDs as $key => $tagID) {
			if($tagID == $tag->id)
				return true;
		}
		return false;
	}
	public function tag(Tag $tag) {
		if($this->hasTag($tag)) return;
		$params = [];
		$params['tagID'] = $tag->getID();
		$params['objectType'] = get_class($this);
		$params['objectID'] = $this->getID();
		Scrumwise::call('addTagOnObject', $params);
	}
	public function untag(Tag $tag) {
		foreach($this->tagIDs as $key => $tagID) {
			if($tagID == $tag->getID())
				unset($this->tagIDs[$key]);
		}

		$params = [];
		$params['tagID'] = $tag->getID();
		$params['objectType'] = get_class($this);
		$params['objectID'] = $this->getID();
		Scrumwise::call('removeTagFromObject', $params);
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
