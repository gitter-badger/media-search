<?php 
$APIYoutube = 'YOUR_API_KEY';
if($_GET["keyword"]){
	$keyword = $_GET["keyword"];
	$keyword = preg_replace("/ /","+",$keyword);
	$response = curl("https://www.googleapis.com/youtube/v3/search?part=snippet&q=".$keyword."&type=video&key=".$APIYoutube."&maxResults=12");
	if($_GET["nextPage"]){
		$nextPage = $_GET["nextPage"];
		$response = curl("https://www.googleapis.com/youtube/v3/search?part=snippet&q=".$keyword."&type=video&key=".$APIYoutube."&maxResults=12&pageToken=".$nextPage);
	}
	if($response){
		$searchResponse = json_decode($response,true);
		if(!isset($searchResponse['error'])){
			if($searchResponse['items']){
				foreach ($searchResponse['items'] as $searchResult) {
					$idYoutube = $searchResult['id']['videoId'];
					$titleYoutube = $searchResult['snippet']['title'];
					if(isset($searchResult['snippet']['thumbnails']['medium'])){
						$thumbYoutube = $searchResult['snippet']['thumbnails']['medium']['url'];
					}else{
						$thumbYoutube = $searchResult['snippet']['thumbnails']['default']['url'];
					}
				?>
				<div id="<?php echo $idYoutube; ?>" class="col-md-6 item-search">
				  <div class="col-md-3">
					<img src="<?php echo $thumbYoutube; ?>" width="100%" height="70px" alt="" class="pull-left">
				  </div>
				  <div class="col-md-9">
					<h5><a target="_blank" href="https://www.youtube.com/watch?v=<?php echo $idYoutube; ?>"><?php echo $titleYoutube; ?></a></h5>
				  </div>
				</div>
				<?php		
				}
			}else{
				echo "<p class='text-danger'>Empty</p>";
			}
			if(isset($searchResponse['nextPageToken'])){
				$nextPage = $searchResponse['nextPageToken'];
			}
			?>
			<div class="text-right">
				<button class="btn btn-primary next" onClick="nextPage('<?php echo $keyword; ?>', '<?php if(isset($nextPage)){echo $nextPage;} ?>')">Next page</button>
			</div>
	<?php
		}else{
			echo "<p class='text-danger'>Error</p>";
		}
	}
}
function curl($url) {
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	$head[] = "Connection: keep-alive";
	$head[] = "Keep-Alive: 300";
	$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$head[] = "Accept-Language: en-us,en;q=0.5";
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	$page = curl_exec($ch);
	curl_close($ch);
	return $page;
}
?>
