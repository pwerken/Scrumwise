<?php

class Sprint
	extends ScrumwiseObject
{
	use Taggable;

	public function __construct($project, $name) {
		parent::__construct($project, $name);

		$this->data['externalID'] = NULL;
		$this->data['projectID'] = NULL;
		$this->data['description'] = NULL;
		$this->data['link'] = NULL;
		$this->data['status'] = NULL;
		$this->data['startDate'] = NULL;
		$this->data['endDate'] = NULL;
		$this->data['boardID'] = NULL;

		$this->data['tagIDs'] = [];
		$this->data['comments'] = [];
		$this->data['attachments'] = [];
		$this->data['teamSprintParticipations'] = [];

		$this->hasSetter['externalID'] = true;
	}

	public function isInPlanning() {
		return ($this->status == "In planning");
	}
	public function isInProgress() {
		return ($this->status == "In progress");
	}

	public function getBacklogItems() {
		return $this->project->getBacklogItemsBySprint($this);
	}

	protected static function validateStatus($status) {
		switch($status) {
		case 'In planning':
		case 'In progress':
		case 'Completed':
		case 'Aborted':
			return $status;
		}
		return NULL;
	}
}
