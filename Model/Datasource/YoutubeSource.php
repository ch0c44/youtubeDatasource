<?php

App::uses('HttpSocket', 'Network/Http');

/**
* Youtube api
*/
class YoutubeSource extends DataSource
{
	/**
	 * Description of datasource
	 *
	 * @var string
	 */
	public $description = 'Youtube Api';

	/**
	 * HttpSocket object
	 *
	 * @var HttpSocket
	 */
	public $Http = null;

	/**
	 * Type string to pass to Url
	 *
	 * @var string
	 */
	protected $_type = null;

	/**
	 * Query array
	 *
	 * @var array
	 */
	protected $_query=null;

	/**
	 * Request string to pass to Youtube
	 *
	 * @var string
	 */
	protected $_request = null;

	/**
	 * Constructor
	 *
	 * Creates new HttpSocket
	 *
	 * @param array $config Configuration array
	 */
	public function __construct($config)
	{
		parent::__construct($config);
		App::import('HttpSocket');
		$this->Http = new HttpSocket();
	}

	public function activitiesList($query=array(), $part=null, $fields=null)
	{
		$query['part'] = ($part==null) ? 'id,snippet,contentDetails' : $part ;

		$query['fields'] = ($fields==null) ? '*' : $fields; 

		$this->_type ='activities';

		return $this->__request($query);
	}

	public function channelsList($query=array(), $part=null, $fields=null)
	{
		$query['part'] = ($part==null) ? 'id,snippet,brandingSettings,contentDetails,invideoPromotion,statistics,topicDetails' : $part;

		$query['fields'] = ($fields==null) ? '*' : $fields; 

		$this->_type ='channels';

		return $this->__request($query);
	}

	public function guideCategoriesList($query=array(), $part=null, $fields=null)
	{
		$query['part'] = ($part==null) ? 'id,snippet' : $part;

		$query['fields'] = ($fields==null) ? '*' : $fields; 

		$this->_type ='guideCategories';

		return $this->__request($query);
	}

	public function playlistItemsList($query=array(), $part=null, $fields=null)
	{
		$query['part'] = ($part==null) ? 'id,snippet,contentDetails,status' : $part;

		$query['fields'] = ($fields==null) ? '*' : $fields; 

		$this->_type ='playlistItems';

		return $this->__request($query);
	}

	public function playlistsList($query=array(), $part=null, $fields=null)
	{
		$query['part'] = ($part==null) ? 'id,snippet,status' : $part;

		$query['fields'] = ($fields==null) ? '*' : $fields; 

		$this->_type ='playlists';

		return $this->__request($query);
	}

	public function searchList($query=array(), $part=null, $fields=null)
	{

		$query['part'] = ($part==null) ? 'id,snippet' : $part ;

		$query['fields'] = ($fields==null) ? '*' : $fields;

		$this->_type = 'search';

		return $this->__request($query);

	}

	public function videoCategoriesList($query=array(), $part=null, $fields=null)
	{
		$query['part'] = ($part==null) ? 'id,snippet' : $part ;

		$query['fields'] = ($fields==null) ? '*' : $fields;
		
		$this->_type = 'videoCategories';

		return $this->__request($query);
	}

	public function videoList($query=array(), $part=null, $fields=null)	
	{
		$query['part'] = ($part==null) ? 'id,snippet,contentDetails,player,recordingDetails,statistics,status,topicDetails' : $part ;

		$query['fields'] = ($fields==null) ? '*' : $fields;

		$this->_type = 'videos';

		return $this->__request($query);
	}

	private function __request($query=array())
	{
		$this->_query = array_merge(
			array(
				'key' 	=> $this->config['keyApi'],
			),
			$query
		);

		$this->_request = $this->__url();
		$retval = $this->Http->get($this->_request);
		
		return json_decode($retval, true);
	}

	private function __url()
	{
		$host = 'https://www.googleapis.com/youtube/v3';

		ksort($this->_query);

		$query = array();
		foreach ($this->_query as $k => $v) 
		{
			$query[] = $k .'='. $v;
		}

		$query = implode('&', $query);

		return sprintf('%s/%s?%s', $host, $this->_type, $query);
	}

	public function query($method, $params, $Model) 
	{
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
        	return false;
        }
    }
}
