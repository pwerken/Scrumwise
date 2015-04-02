<?php

class Sprint
	extends ScrumwiseObject
{
	public function __construct($name) {
		parent::__construct($name);

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

	public function hasTag(Tag $tag) {
		foreach($this->tagIDs as $key => $tagID) {
			if($tagID == $tag->id)
				return true;
		}
		return false;
	}
	public function tag(Tag $tag) {
		if($this->hasTag($tag))
			return;

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
