<?php

session_start();

require "vendor/autoload.php";


use Google\Cloud\Vision\VisionClient;
$vision = new VisionClient(['keyFile' => json_decode(file_get_contents("key.json"), true)]);

$familyPhotoResource = fopen($_FILES['image']['tmp_name'], 'r');

$image = $vision->image($familyPhotoResource, 
    ['FACE_DETECTION',
     'LABEL_DETECTION'
    ]);
$result = $vision->annotate($image);

if (!$result) {
    header("location: index.php");
    die();
}

$faces = $result->faces();
$labels = $result->labels();
	
if ($faces){
	if(strcmp($faces[0]->info()['joyLikelihood'], "VERY_LIKELY") == 0){
		$mood = "joy";
	} elseif (strcmp($faces[0]->info()['sorrowLikelihood'], "VERY_LIKELY") == 0){
		$mood = "sorrow";
	} elseif (strcmp($faces[0]->info()['angerLikelihood'], "VERY_LIKELY") == 0){
		$mood = "anger";
	} elseif (strcmp($faces[0]->info()['surpriseLikelihood'], "VERY_LIKELY") == 0){
		$mood = "surprise";
	} elseif(strcmp($faces[0]->info()['joyLikelihood'], "LIKELY") == 0 || $_POST['feelslike'] == 'joy'){
		$mood = "joy";
	} elseif (strcmp($faces[0]->info()['sorrowLikelihood'], "LIKELY") == 0 || $_POST['feelslike'] == 'sorrow'){
		$mood = "sorrow";
	} elseif (strcmp($faces[0]->info()['angerLikelihood'], "LIKELY") == 0 || $_POST['feelslike'] == 'anger'){
		$mood = "anger";
	} elseif (strcmp($faces[0]->info()['surpriseLikelihood'], "LIKELY") == 0){
		$mood = "surprise";
	} elseif(strcmp($faces[0]->info()['joyLikelihood'], "POSSIBLE") == 0){
		$mood = "joy";
	} elseif (strcmp($faces[0]->info()['sorrowLikelihood'], "POSSIBLE") == 0){
		$mood = "sorrow";
	} elseif (strcmp($faces[0]->info()['angerLikelihood'], "POSSIBLE") == 0){
		$mood = "anger";
	} elseif (strcmp($faces[0]->info()['surpriseLikelihood'], "POSSIBLE") == 0){
		$mood = "surprise";
	} elseif(strcmp($faces[0]->info()['joyLikelihood'], "UNLIKELY") == 0){
		$mood = "joy";
	} elseif (strcmp($faces[0]->info()['sorrowLikelihood'], "UNLIKELY") == 0){
		$mood = "sorrow";
	} elseif (strcmp($faces[0]->info()['angerLikelihood'], "UNLIKELY") == 0){
		$mood = "anger";
	} elseif (strcmp($faces[0]->info()['surpriseLikelihood'], "UNLIKELY") == 0){
		$mood = "surprise";
	} else {
		$mood = "unknown";
	}	
} else {
		$tags[0] = $labels[0]->info()['description'];
		$tags[1] = $labels[1]->info()['description'];
		$tags[2] = $labels[2]->info()['description'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="shortcut icon" type="image/jpg" href="favicon.webp"/>
    <meta charset="UTF-8">
    <title>CINEPLIX</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
        }
        .bg {
			background-image: url("https://i.pinimg.com/originals/4a/94/26/4a94268541d7a0ed95a8be5138e8a288.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .container-fluid  {
            margin-bottom: 50px;
        }
    </style>
</head>
<body class="bg">
    <div class="container-fluid" style="max-width: 1080px;">
        <br><br><br>
        <div class="row">
            <div class="col-md-12" style="border-radius: 10px; margin: auto; background: white; padding: 20px; box-shadow: 10px 10px 5px #888">
                <div class="panel-heading" style="display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-outline-primary" onClick="window.location.href='index.php';">Generate with another image</button>
					<button type="button" class="btn btn-outline-secondary" onClick="window.location.reload();">Refresh</button>
				</div>
                <hr>
                   
				<div class="row">
					<div class="col-12">
						<ol>
						<script>
							const APIKEY = '5d61bcb43fcd91d28ae9513c1b508b7e';
							let baseURL = 'https://api.themoviedb.org/3/';
							let configData = null;
							
							let runKeywordSearch = function (genre, keyword) {
								let genre_id;
								let url = ''.concat(baseURL, 'genre/movie/list?api_key=', APIKEY, '&language=en-US');
								fetch(url)
								.then(result=>result.json())
								.then((data)=>{
									for (i in data.genres){
										if (data.genres[i].name == genre){
											genre_id = data.genres[i].id;
										}
									}
								})
								.then(()=>{
									url = ''.concat(baseURL, 'search/keyword?api_key=', APIKEY, '&query=', keyword, '&language=en-US');
									let keyword_id;
									let keywords;
									fetch(url)
									.then(result=>result.json())
									.then((data)=>{
										if(data.total_results != '0'){
											var rndId = Math.floor(Math.random() * data.total_results);
											while(rndId > 19){
												rndId = Math.floor(Math.random() * data.total_results);
											}
											keyword_id = data.results[rndId].id;
											keywords = data.results[rndId].name;
										}
									})
									.then(() => {
										if(keyword_id === undefined){
											
										} else {
										url = ''.concat(baseURL, 'discover/movie?api_key=', APIKEY, '&language=en-US&with_genres=',genre_id , '&with_keywords=', keyword_id);
										fetch(url)
										.then(result=>result.json())
										.then((data)=>{
											if(data.total_results != '0'){
												var resultId;
												resultId = Math.floor(Math.random() * data.total_results);
												while(resultId > 19){
													resultId = Math.floor(Math.random() * data.total_results);
												}
												console.log(resultId);
												var div = document.createElement("div");
												var div = document.createElement("div");
												div.className = "column";
												div.style = "flex: 33%; padding: 10px;";
												
												var h4 = document.createElement("h4");
												h4.style = "text-align: center";
												var t = document.createTextNode(data.results[resultId].title); 
												h4.appendChild(t);										
												div.appendChild(h4); 
												
												
												var img = document.createElement('img');
												img.style = "display: block; margin-left: auto; margin-right: auto";
												if(data.results[resultId].poster_path === null){ 
													img.src = 'data:image/png;base64,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';
													img.style="width:154px; display: block; margin-left: auto; margin-right: auto";
												}else{
													img.src = 'https://image.tmdb.org/t/p/w154' + data.results[resultId].poster_path;
												}
												div.appendChild(img);
												
												var inner_div = document.createElement("div");
												inner_div.className = "column";
												inner_div.style = "display: flex; column-gap: 10px; margin-top: 10px;";
												
												var s = document.createElement('strong');
												t = document.createTextNode('Year: '); 
												s.appendChild(t);
												inner_div.appendChild(s);
												var l = document.createElement('label');
												t = document.createTextNode(data.results[resultId].release_date.substring(0, 4)); 
												l.appendChild(t);
												inner_div.appendChild(l);
												
												s = document.createElement('strong');
												t = document.createTextNode('Genre: '); 
												s.appendChild(t);
												inner_div.appendChild(s);
												l = document.createElement('label');
												t = document.createTextNode(genre); 
												l.appendChild(t);
												inner_div.appendChild(l);
												
												div.appendChild(inner_div);
												
												s = document.createElement('strong');
												t = document.createTextNode('Keyword: '); 
												s.appendChild(t);
												div.appendChild(s);
												l = document.createElement('label');
												t = document.createTextNode(keywords); 
												l.appendChild(t);
												div.appendChild(l);
												
												var p = document.createElement("P");
												p.style = "text-align: justify;";
												if(data.results[resultId].overview === ''){
													t = document.createTextNode('N/A overview');
												}else{
													t = document.createTextNode(data.results[resultId].overview);
												}      
												p.appendChild(t);                                          
												div.appendChild(p);
												
												document.getElementById("movie-result").appendChild(div);    
											}
											})
										}
									})
								})
							}
							let getKeywordConfig = function (genre, tag) {
								let url = "".concat(baseURL, 'configuration?api_key=', APIKEY); 
								fetch(url)
								.then((result)=>{
									return result.json();
								})
								.then((data)=>{
									baseImageURL = data.images.secure_base_url;
									configData = data.images;
									console.log('config:', data);
									console.log('config fetched');
									runKeywordSearch(genre, tag)
								})
								.catch(function(err){
									alert(err);
								});
							}
						</script>
						<?php if ($faces):?>
							<div class="row">
								<div class="col-12">
									<script>
										let runGenreSearch = function (genre) {
											let genre_id;
											let url = ''.concat(baseURL, 'genre/movie/list?api_key=', APIKEY, '&language=en-US');
											fetch(url)
											.then(result=>result.json())
											.then((data)=>{
												for (i in data.genres){
													if (data.genres[i].name == genre){
														genre_id = data.genres[i].id;
													}
												}
											})
											.then(()=>{
												url = ''.concat(baseURL, 'discover/movie?api_key=', APIKEY, '&language=en-US&with_genres=', genre_id);
												fetch(url)
												.then(result=>result.json())
												.then((data)=>{
													console.log(genre_id);
													var resultId;
													do{
														resultId = Math.floor(Math.random() * data.total_results);
														while(resultId > 19){
															resultId = Math.floor(Math.random() * data.total_results);
														}
													}while(data.results[resultId].poster_path === null);
													var div = document.createElement("div");
													div.className = "column";
													
													div.style = "flex: 33%; padding: 10px;";
													
													var h4 = document.createElement("h4");
													h4.style = "text-align: center";
													var t = document.createTextNode(data.results[resultId].title); 
													h4.appendChild(t);										
													div.appendChild(h4); 
													
													var img = document.createElement('img');
													img.style = "display: block; margin-left: auto; margin-right: auto";
													img.src = 'https://image.tmdb.org/t/p/w185' + data.results[resultId].poster_path;
													div.appendChild(img);
													
													var inner_div = document.createElement("div");
													inner_div.className = "column";
													inner_div.style = "display: flex; column-gap: 10px; margin-top: 10px;";
													
													var s = document.createElement('strong');
													t = document.createTextNode('Year: '); 
													s.appendChild(t);
													inner_div.appendChild(s);
													var l = document.createElement('label');
													t = document.createTextNode(data.results[resultId].release_date.substring(0, 4)); 
													l.appendChild(t);
													inner_div.appendChild(l);
													
													s = document.createElement('strong');
													t = document.createTextNode('Genre: '); 
													s.appendChild(t);
													inner_div.appendChild(s);
													l = document.createElement('label');
													t = document.createTextNode(genre); 
													l.appendChild(t);
													inner_div.appendChild(l);
													
													div.appendChild(inner_div);
													
													var p = document.createElement("P");
													p.style = "text-align: justify;";
													t = document.createTextNode(data.results[resultId].overview);      
													p.appendChild(t);                                          
													div.appendChild(p);
													
													document.getElementById("movie-result").appendChild(div);    
												})
											})
										}
										let getGenreConfig = function (genre) {
											let url = "".concat(baseURL, 'configuration?api_key=', APIKEY); 
											fetch(url)
											.then((result)=>{
												return result.json();
											})
											.then((data)=>{
												baseImageURL = data.images.secure_base_url;
												configData = data.images;
												console.log('config:', data);
												console.log('config fetched');
												runGenreSearch(genre)
											})
											.catch(function(err){
												alert(err);
											});
										}
										var mood = '<?php echo $mood ?>';
										if(mood == 'joy'){
											document.addEventListener('DOMContentLoaded', getGenreConfig('Comedy'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Family'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Adventure'));
										} else if(mood == 'sorrow'){
											document.addEventListener('DOMContentLoaded', getGenreConfig('Romance'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Drama'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Comedy'));
										}else if(mood == 'anger'){
											document.addEventListener('DOMContentLoaded', getGenreConfig('Action'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('War'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Crime'));
										}else if(mood == 'surprise'){
											document.addEventListener('DOMContentLoaded', getGenreConfig('Mystery'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Horror'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Crime'));
										}else{
											document.addEventListener('DOMContentLoaded', getGenreConfig('Fantasy'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Science Fiction'));
											document.addEventListener('DOMContentLoaded', getGenreConfig('Mystery'));
										}
									</script>
								</div>
							</div>
						<?php else:?>
								<script>
									if('<?php echo $_POST['feelslike']?>' == 'joy'){
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Comedy', '<?php echo $tags[0] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Comedy', '<?php echo $tags[1] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Comedy', '<?php echo $tags[2] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Family', '<?php echo $tags[0] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Family', '<?php echo $tags[1] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Family', '<?php echo $tags[2] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Adventure', '<?php echo $tags[0] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Adventure', '<?php echo $tags[1] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Adventure', '<?php echo $tags[2] ?>'));
									} else if('<?php echo $_POST['feelslike']?>' == 'sorrow'){
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Romance', '<?php echo $tags[0] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Drama', '<?php echo $tags[1] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Comedy', '<?php echo $tags[2] ?>'));
									}else if('<?php echo $_POST['feelslike']?>' == 'anger'){
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Action', '<?php echo $tags[0] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('War', '<?php echo $tags[1] ?>'));
										document.addEventListener('DOMContentLoaded', getKeywordConfig('Crime', '<?php echo $tags[2] ?>'));
									}
								</script>
						<?php endif ?>
						</ol>
                    </div>
                </div>
				<div class="row" id="movie-result" style="display: flex;"></div>
            </div>
        </div>
    </div>
	<<div id="attribution" style="padding: 10px; position: fixed; bottom: 0; width: 100%;">
		<lablel style="color: white">Powered by</label>
		<img src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_square_2-d537fb228cf3ded904ef09b136fe3fec72548ebc1fea3fbbd1ad9e36364db38b.svg" alt="TheMovieDB.org API" style="max-width:2.5%; max-height:2.5%;"/>
		<img src="https://images.g2crowd.com/uploads/product/image/social_landscape/social_landscape_0c51d2c2e5f85fe45126eb818f748267/google-cloud-vision-api.png" alt="TheMovieDB.org API" style="max-width:3.75%; max-height:3.75%;"/>
	</div>
</body>
</html>