<?php

class Release
	extends ScrumwiseObject
{
	use Taggable;

	public function __construct($project, $name) {
		parent::__construct($project, $name);

		$this->data['externalID'] = true;
		$this->data['projectID'] = true;
		$this->data['description'] = true;
		$this->data['link'] = true;
		$this->data['startDate'] = true;
		$this->data['releaseDate'] = true;
		$this->data['status'] = true;
		$this->data['bestCaseVelocityPerWeek'] = true;
		$this->data['expectedVelocityPerWeek'] = true;
		$this->data['worstCaseVelocityPerWeek'] = true;

		$this->data['tagIDs'] = [];
		$this->data['comments'] = [];
		$this->data['attachments'] = [];
		$this->data['assignedBacklogItemIDs'] = [];

		$this->hasSetter['externalID'] = true;
	}

	public function hasBacklogItem(BacklogItem $backlogItem) {
		foreach($this->assignedBacklogItemIDs as $key => $backlogItemID) {
			if($backlogItemID == $backlogItem->id)
				return true;
		}
		return false;
	}
}
