<?php

class Team
	extends ScrumwiseObject
{
	public function __construct($project, $name) {
		parent::__construct($project, $name);

		$this->data['externalID'] = NULL;
		$this->data['projectID'] = NULL;
		$this->data['description'] = NULL;
		$this->data['teamMemberIDs'] = [];

		$this->hasSetter['description'] = true;
	}
}
