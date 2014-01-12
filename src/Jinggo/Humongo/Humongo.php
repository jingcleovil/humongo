<?php namespace Jinggo\Humongo;


class Humongo {

	protected $mongo;

	protected $db;

	protected $collection;

	public function __construct()
	{
		$mongo = \Config::get('humongo::mongo');

		$this->mongo = new \MongoClient("mongodb://$mongo[host]:$mongo[port]");
		$this->db = $this->mongo->$mongo['database'];

	}

	/**
	 * Set Collection
	 */
	public function collection($collection)
	{
		$this->collection = $collection;	

		return $this;
	}

	public function create($document)
	{		
		if(!$this->collection) return false;
		if(!$document) return false;

		$collection = $this->collection;

		$this->db->$collection->insert($document);
	}
	

	public function find($filter=array())
	{
		if(!$this->collection) return false;

		$collection = $this->collection;

		if(!$filter) $filter = array();

		if(!is_array($filter)) $filter = array();

		$cursor = $this->db->$collection->find($filter);

		$doc = array();

		foreach($cursor as $document)
		{
			$doc[] = $document;
		}

		return $doc;
	}
}