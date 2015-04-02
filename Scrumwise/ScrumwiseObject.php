<?php

abstract class ScrumwiseObject
{
	protected $data = [];
	protected $hasSetter = [];
	protected $canCreate = [];
	protected $canDelete = false;

	protected function __construct($name) {
		$this->data['name'] = $name;
		$this->data['id'] = null;
	}

	public static function instantiate($data) {
		$class = get_called_class();
		if($data['objectType'] != $class)
			return NULL;

		$obj = new $class(NULL);

		unset($data['objectType']);
		foreach($data as $key => $val) {
			if(!isset($obj->$key)) {
				echo "skipping '$class.$key' ...\n";
				continue;
			}
			if(is_array($val)) {
				$obj->data[$key] = [];
				foreach($val as $sub) {
					if(!isset($sub['objectType'])
					|| !class_exists($sub['objectType'])) {
						$obj->data[$key][] = $sub;
						continue;
					}
					$obj->data[$key][] = $sub['objectType']::instantiate($sub);
				}
				continue;
			}
			$obj->data[$key] = $val;
		}
		return $obj;
	}

	protected function setter($method, $fields, $reqObj = false) {
		if($this->id == NULL) {
			if(!$reqObj || empty($canCreate))
				return;

			$this->create();
		}
		$class = get_class($this);

		$args = [];
		$args[lcfirst($class).'ID'] = $this->data['id'];
		foreach($fields as $field)
			$args[$field] = $this->data[$field];

		Scrumwise::call('set'.$class.$method, $args);
	}
	protected function save($field, $reqObj = false) {
		$this->setter(ucfirst($field), [$field], $reqObj);
	}

	public function create($projectID = NULL) {
		if(!is_array($this->canCreate)) {
			$trace = debug_backtrace();
			trigger_error('Illegal call to create()'
							. ' in ' . $trace[0]['file']
							.  ' on line ' . $trace[0]['line']
						, E_USER_NOTICE);
			return;
		}

		if(array_key_exists('projectID', $this->canCreate))
			$this->data['projectID'] = $projectID;

		$args = [];
		foreach($this->canCreate as $field => $val)
			$args[$field] = $this->data[$field];

		$this->data['id'] = Scrumwise::call('add'.get_class($this), $args);
	}
	public function delete() {
		if(!$this->canDelete) {
			$trace = debug_backtrace();
			trigger_error('Illegal call to delete()'
							. ' in ' . $trace[0]['file']
							.  ' on line ' . $trace[0]['line']
						, E_USER_NOTICE);
			return;
		}
		$class = get_class($this);
		$args = [];
		$args[lcfirst($class).'ID'] = $this->data['id'];
		Scrumwise::call('delete'.$class, $args);

		unset($this->data['id']);
		unset($this->data['projectID']);
	}
	public function __set($name, $value) {
		// ALLEEN in hasSetter[]:
		//		FAIL if not created	(proberen te createn ?)
		//		data[] update
		//		save()
		// ALLEEN in create[]:
		//		data[] update
		// BEIDE:
		//		data[] update
		//		save() if created

		if(!array_key_exists($name, $this->hasSetter)
		|| !array_key_exists($name, $this->data)) {
			$trace = debug_backtrace();
			trigger_error('Undefined property via __set(): ' . $name
							. ' in ' . $trace[0]['file']
							.  ' on line ' . $trace[0]['line']
						, E_USER_NOTICE);
			return;
		}

		$m = 'validate'.ucfirst($name);
		if(method_exists($this, $m))
			$value = call_user_method($m, $this, $value);

		$this->data[$name] = $value;
		$this->save($name);
	}
	public function &__get($name) {
		if(!array_key_exists($name, $this->data)) {
			$trace = debug_backtrace();
			trigger_error('Undefined property via __get(): ' . $name
							. ' in ' . $trace[0]['file']
							.  ' on line ' . $trace[0]['line']
						, E_USER_NOTICE);
			return NULL;
		}

		return $this->data[$name];
	}
	public function __isset($name) {
		return array_key_exists($name, $this->data);
	}
	public function __unset($name) {
		return $this->__set($name, NULL);
	}
}
