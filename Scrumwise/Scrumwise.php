<?php

require_once 'ScrumwiseObject.php';
require_once 'Taggable.php';
require_once 'BacklogItem.php';
require_once 'Project.php';
require_once 'Release.php';
require_once 'Sprint.php';
require_once 'Tag.php';
require_once 'Task.php';
require_once 'Team.php';

Scrumwise::configure(require 'config.php');

class Scrumwise
{
	private static $user = NULL;
	private static $pass = NULL;
	private static $update = true;

	private static $project = '105493-0-5';
	private static $data = [];

	public static function configure($arr) {
		self::$user = $arr['user'];
		self::$pass = $arr['key'];
	}

	public static function updateCache($update) {
		self::$update = (bool)$update;
	}

	public static function call($method, $params) {
		$data = self::apiCall($method, $params);

		if(array_key_exists('result', $data))
			return $data['result'];

		var_dump($data);
		return NULL;
	}

	public static function getProject($name = NULL) {
		$retrieve = true;
		if(empty(self::$data)) {
			if($name === NULL) {
				self::$data = self::getProjectData(self::$project);
				return Project::instantiate(self::$data['projects'][0]);
			}
			self::$data = self::call('getData', ['includeProperties' => NULL]);
		}

		$i = is_null($name) ? 0 : -1;
		foreach(self::$data['projects'] as $key => $p) {
			if($p['name'] == $name) {
				$i = $key;
				break;
			}
		}
		if($i < 0) {
			error_log("project '$name' not found");
			die;
		}
		if($retrieve) {
			$data = self::getProjectData($p['id']);
			$p = $data['projects'][0];
			self::$data['projects'][$key] = $p;
		}
		return Project::instantiate($p);
	}

	private static function apiCall($method, $params) {
		if(self::$user === NULL || self::$pass === NULL) {
			error_log("Not configured!");
			die;
		}

		$url = "https://api.scrumwise.com/service/api/v1/$method";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERPWD, self::$user.':'.self::$pass);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

		$data = json_decode(curl_exec($ch), true);
		curl_close($ch);

		if($data['objectType'] == 'Error') {
			var_dump([$method, $params]);
			var_dump($data);
			die;
		}

		return $data;
	}
	private static function getDataVersion() {
		return self::call('getDataVersion', []);
	}
	private static function getData($projectID) {
		return self::apiCall('getData',
				[ 'projectIDs' => $projectID
				, 'includeProperties' => implode(',',
						array('Project.backlogItems'
							, 'Project.teams'
							, 'Project.releases'
							, 'Project.tags'
							, 'Project.sprints'
							, 'BacklogItem.tasks'
							))
				]);
	}

	private static function getProjectData($projectID) {
		$file = $projectID.".cache";
		$data = unserialize(@file_get_contents($file));
		if($data === false
		|| ($data['dataVersion'] != self::getDataVersion() && self::$update)) {
			$data = self::getData($projectID);
			file_put_contents($file, serialize($data));
		}
		return $data['result'];
	}
}
