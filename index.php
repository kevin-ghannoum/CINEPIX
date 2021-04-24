<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="shortcut icon" type="image/jpg" href="favicon.webp"/>
    <meta charset="UTF-8">
    <title>CINEPEX</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<style>
		body, html {
			height: 100%;
		}
		.bg {
			background-image: url("https://i.pinimg.com/originals/4a/94/26/4a94268541d7a0ed95a8be5138e8a288.jpg");
			height: 100%;
			background-postion: center;
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
</head>
<body class="bg">
	<div class="container">
		<br><br><br><br><br><br>
		<div class="row">
			<div class="col-md-6 offset-md-3" style="border-radius: 10px; margin: auto; background: white; padding: 20px; box-shadow: 10px 10px 5px #888">
				<div class="panel-heading">
					<div style="display: flex; ">
						<img src="favicon.webp" style="max-width:8%; max-height:8%;"/>
						<h2 style="margin-top: 12px;">CINEPIX</h2>
                    </div>
					<p>Tell me how you feel and I will generate you movies. You can upload a photo of your face or a picture of what your movies will be about. Hope that I can help!</p>
				</div>
				<hr>
				<form action="check.php" method="post" enctype="multipart/form-data">
					<div style="padding: 10px">
						<label>I feel...</label>
						<br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="feelslike" id="inlineRadio1" value="joy" checked>
							<label class="form-check-label" for="inlineRadio1">Happy</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="feelslike" id="inlineRadio2" value="anger">
							<label class="form-check-label" for="inlineRadio2">Angry</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="feelslike" id="inlineRadio3" value="sorrow">
							<label class="form-check-label" for="inlineRadio3">Sad</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="feelslike" id="inlineRadio4" value="sorrow">
							<label class="form-check-label" for="inlineRadio4">Unmotivated</label>
						</div>
                    </div>
					<br>
					<input type="file" name="image" accept="image/*" class="form-control" required/>
                    <br>
					<div class="d-grid gap-2 col-6 mx-auto">
						<button type="submit" class="btn btn-lg btn-block btn-outline-primary">Generate Movie</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="attribution" style="padding: 10px; position: fixed; bottom: 0; width: 100%;">
				<lablel style="color: white">Powered by</label>
				<img src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_square_2-d537fb228cf3ded904ef09b136fe3fec72548ebc1fea3fbbd1ad9e36364db38b.svg" alt="TheMovieDB.org API" style="max-width:2.5%; max-height:2.5%;"/>
				<img src="https://images.g2crowd.com/uploads/product/image/social_landscape/social_landscape_0c51d2c2e5f85fe45126eb818f748267/google-cloud-vision-api.png" alt="TheMovieDB.org API" style="max-width:3.75%; max-height:3.75%;"/>
	</div>
</body>
</html>