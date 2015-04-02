<?php

class Release
	extends ScrumwiseObject
{
	public function __construct($name) {
		parent::__construct($name);

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

	public function hasBacklogItem(BacklogItem $backlogItem) {
		foreach($this->assignedBacklogItemIDs as $key => $backlogItemID) {
			if($backlogItemID == $backlogItem->getID())
				return true;
		}
		return false;
	}
}
