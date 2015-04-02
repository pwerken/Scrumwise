<?php

class Task
	extends ScrumwiseObject
{
	public function __construct($name) {
		parent::__construct($name);

		$this->data['externalID'] = NULL;
		$this->data['taskNumber'] = NULL;
		$this->data['projectID'] = NULL;
		$this->data['backlogItemID'] = NULL;
		$this->data['description'] = NULL;
		$this->data['link'] = NULL;
		$this->data['status'] = NULL;
		$this->data['boardColumnID'] = NULL;
		$this->data['estimate'] = NULL;
		$this->data['usedTime'] = NULL;
		$this->data['remainingWork'] = NULL;

		$this->data['assignedPersonIDs'] = [];
		$this->data['tagIDs'] = [];
		$this->data['comments'] = [];
		$this->data['attachments'] = [];
		$this->data['timeEntries'] = [];
		$this->data['commits'] = [];

		$this->canCreate['externalID'] = true;
		$this->canCreate['backlogItemID'] = true;
		$this->canCreate['name'] = true;
		$this->canCreate['description'] = true;
		$this->canCreate['link'] = true;

		$this->canDelete = true;

		$this->hasSetter['description'] = true;
		$this->hasSetter['externalID'] = true;
		$this->hasSetter['link'] = true;
		$this->hasSetter['name'] = true;
	}

	public function hasTag(Tag $tag) {
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
}
