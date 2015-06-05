<?php

class Tag
	extends ScrumwiseObject
{
	public function __construct($project, $name) {
		parent::__construct($project, $name);

		$this->data['externalID'] = NULL;
		$this->data['projectID'] = NULL;
		$this->data['description'] = NULL;
		$this->data['color'] = NULL;

		$this->canCreate['externalID'] = true;
		$this->canCreate['projectID'] = true;
		$this->canCreate['name'] = true;
		$this->canCreate['description'] = true;
		$this->canCreate['color'] = true;
#		$this->canCreate['index'] = true;
	}

	protected function validateColor($color) {
		switch($color) {
		case 'Red':
		case 'Light red':
		case 'Dark orange':
		case 'Orange':
		case 'Yellow':
		case 'Light green':
		case 'Green':
		case 'Dark green':
		case 'Light blue':
		case 'Blue':
		case 'Dark blue':
		case 'Purple':
		case 'Pink':
		case 'Light brown':
		case 'Dark brown':
		case 'Light gray':
		case 'Dark gray':
			return $color;
		}
		return NULL;
	}
}
