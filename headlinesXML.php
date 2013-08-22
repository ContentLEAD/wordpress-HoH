<?php
class HeadlinesXMLRPC {

    /**
     * uses XMLRPC to get HOH code
	 * needs a certain level of credentials to work, I believe it's editor.
     * credit to xmlrpc-fetching function Brian Corey 
	 * see http://codex.wordpress.org/XML-RPC_MetaWeblog_API
	 */
	 
    private $user;
    private $pass;
    private $url;
    private $posts;
	
    public function __construct($user, $pass,$url,$posts){
	$this->user=$user;
	$this->pass=$pass;
	$this->url=$url;
	$this->posts=$posts;
	}
	
	//returns headlines code with images 
	//	defaults to latest news, link is the link to the blog.  No default.
	
	public function getHeadlines($title, $link){
		if (!$title){
			$title="Latest News";
		}
		return $this->Headlines($title,$link);
	}
	
	//returns default stylesheet inside <style> tags
	public function getStyles(){
		$styles="<style></style>";
		return $styles;
	}
	
	//uses xmlrpc
	private function Headlines($title,$link){
		
		if(!$title) $title="Latest News";
	
		//user
		$username = $this->user;
		/**
		 * The WordPress user's password.
		 */
		$password = $this->pass;
		/**
		 * The URL of the Metaweblog interface. Ends with xmlrpc.php.
		 */
		$metaWeblogUrl = $this->url;
		/**
		 * @var maxPosts The maximum amount of posts to load from WordPress.
		 */
		$maxPosts = $this->posts;
		
		/* That's it! Stop editing. */
		
		$format =
			'<methodCall>
			<methodName>metaWeblog.getRecentPosts</methodName>
			<params>
				<param><value><int>1</int></value></param>
				<param><value><string>%s</string></value></param>
				<param><value><string>%s</string></value></param>
				<param><value><int>%d</int></value></param>
			</params>
			</methodCall>';
		
		$requestXml = sprintf($format, $username, $password, $maxPosts);
		$ch = curl_init($metaWeblogUrl);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		$results = new SimpleXMLElement($response);
		$posts = array();
		$stringFields = array('title', 'permaLink');
		$dateFields = array('dateCreated');
		$dateFormat = 'F jS, Y';
		
		foreach ($results->xpath('//methodResponse/params/param/value/array/data/value') as $item)
		{
			$row = simplexml_load_string($item->asXML());
			$v = $row->xpath('struct/member');
			
			$post = array();
			
			for ($i = 0; $i < count($v); $i++)
			if ($v[$i])
			{
				$name = (string)$v[$i]->name;
				
				if (in_array($name, $dateFields))
					$post[$name] = date($dateFormat, strtotime((string)$v[$i]->value->{'dateTime.iso8601'}));
				else if (in_array($name, $stringFields))
					$post[$name] = trim((string)$v[$i]->value->string);
			}
			
			$posts[] = $post;
		}
		$headlines= "<div id='headlines'>";
		if($link){
			echo "<a href='$link'><h2>$title</h2><a/>\n<ol>";
		} else echo "<h2>$title</h2>\n<ol>";
				

		foreach ($posts as $post){
			$headlines = $headlines . "<li>\n" . '<h3 class="post-title">';
			$headlines = $headlines . '<a href="' . $post['permaLink'] . '" target="_parent">' . $post['title'] . '</a></h3>';
			$headlines = $headlines . '<span class="post-date">' . $post['dateCreated'] . '</span>';
			$headlines = $headlines . "</li>";
		}
		$headlines = $headlines . "</ol>\n";
		$headlines = $headlines . "</div>";
		return $headlines;
	}
	
}

?>