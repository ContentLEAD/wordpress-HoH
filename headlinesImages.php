<?php
class HeadlinesImages {

    /**
     * uses DB connection to query database and get HOH code
     */
    private $user;
    private $pass;
    private $database;
    private $host;
	
    public function __construct($user, $pass, $database, $host){
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
	$this->host=$host;
	}
	
	//returns headlines code with images 
	//	defaults to latest news, link is the link to the blog.  No default.
	
	public function getHeadlines($title, $link){
		if (!$title){
			$title="Latest News";
		}
		return $this->HeadlinesWithImages($title,$link);
	}
	
	//returns default stylesheet inside <style> tags
	public function getStyles(){
		$styles=<<<EOT
<style>
	.article {
	width:30%;
	float:left;
	margin-right:3%;
	}
	
	#CLHeadlines a{
	color:#205c29;
	text-decoration:none;
	}
	
	#CLHeadlines a:hover  {
	text-decoration: underline;
	}
	
	.post{
	text-align:left;
	font-size:11px;
	font-weight:bold;
	font-family:Helvetica, Arial, sans-serif; 
	position:relative;
	display:inline;
	margin-right:10px;
	top:-10px;
	}
	
	.title{
	color:red;
	font-size:12px;
	font-family:Helvetica, Arial, sans-serif; 
	font-weight:bold;
	margin-bottom:-21px;
	position:relative;
	top:-10px;
	}
	
	.title:hover{}
	
	.date{
	font-size:11px;
	font-weight:bold;
	}
	#CLHeadlines{
	width:99%;
	}
	#CLHeadlines img{
	padding:0 8px 8px 0;
	}
</style>
EOT;
		return $styles;
	}
	
	//uses database connection to query the database and get HOH code with pictures
	private function HeadlinesWithImages($title,$link){
		$con = mysql_connect($this->host,$this->user,$this->pass);

		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}

		mysql_select_db($this->database) or die( "Unable to select database");

			$query = "SELECT * FROM wp_posts WHERE post_status = 'publish' and post_type = 'post' ORDER BY post_date DESC LIMIT 3";
			
			

		$result=mysql_query($query);	

		$titleLength = 90;
		
		$sitequery = "SELECT option_value FROM wp_options WHERE option_name = 'siteurl'";	
		$siteresult=mysql_query($sitequery);	
		$sitearray=mysql_fetch_array($siteresult);
		$url=$sitearray['option_value'];
		
		echo "<div id='CLHeadlines'>";
		
		while($row = mysql_fetch_array($result)){
			
			if(strlen($row["post_title"]) <= $titleLength){
				$content =  $row["post_title"];
				}else{
				$content =  substr($row["post_title"],0,$titleLength) . "...";
			}
			
			$post_content=$row["post_content"];
			$sentence_end=strpos($post_content,". ");
			$sentence=substr($post_content,0,$sentence_end+1);
			
			$excerpt = $row["post_excerpt"];
			
			$old_date =  $row["post_date"];
			$middle = strtotime($old_date);
			$date = date('d-M', $middle);	
			echo "<div class='article'><a target='_parent' style='text-decoration:none; ' class='indexWell' href='" . $row["guid"] . "'> ";
		
		
		$really = $row['ID'] + 1;
		$query2 = "SELECT * FROM wp_postmeta WHERE post_id = ". $really ." and meta_key = '_wp_attached_file'";
		$result2=mysql_query($query2);	
		$row2 = mysql_fetch_array($result2);
		if($row2['meta_value']){
		echo "<img src='$url/wp-content/uploads/". $row2['meta_value'] ."' height='150px' style='float:left;' />";
		}	
			
			echo "<b>" . date('F d, Y' , strtotime($date)) . ".</b> ";
			
			echo $content."</a><br /><div style='float:left;'>";
			if($excerpt) echo $excerpt . "";
			else echo $sentence;
			echo "</div></div>";
		}

		echo "</div>";
		mysql_close();
	}

}

?>