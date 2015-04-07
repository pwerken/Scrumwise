<?php

trait Taggable
{
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
		$params['tagID'] = $tag->id;
		$params['objectType'] = get_class($this);
		$params['objectID'] = $this->id;
		Scrumwise::call('addTagOnObject', $params);
	}
	public function untag(Tag $tag) {
		foreach($this->tagIDs as $key => $tagID) {
			if($tagID == $tag->id)
				unset($this->tagIDs[$key]);
		}

		$params = [];
		$params['tagID'] = $tag->id;
		$params['objectType'] = get_class($this);
		$params['objectID'] = $this->id;
		Scrumwise::call('removeTagFromObject', $params);
	}
}
