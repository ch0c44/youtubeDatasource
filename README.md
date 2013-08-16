youtubeDatasource
=================

Youtube Datasource for Cakephp

INSTALL
-------

Add Model/Datasource/YoutubeSource.php in your projet (app/) and add this line in Config/database.php

<pre>
	public $youtube = array(
		'datasource' 	=> 'YoutubeSource',
		'keyApi' 		=> '/* YOUR API KEY */',
		'database' 		=> null
	);
</pre>