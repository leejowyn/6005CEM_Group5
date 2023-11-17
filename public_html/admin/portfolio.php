<?php

	function validateImage($image_type, $isSingle) {
		$err = "";

		if ($isSingle) {
			if ($image_type != "image/jpeg" && $image_type != "image/png") 
				$err = "* Only JPEG/PNG are allowed.";
		}
		else {
			foreach ($image_type as $key => $img_type) {
				if ($img_type != "image/jpeg" && $img_type != "image/png") 
					$err = "* Only JPEG/PNG are allowed.";
			}
		}

		return $err;
	}

	$page = "portfolios";
	session_start();

	$dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

	$thumbnailErr = $panoramaErr = $imagesErr = $success_alert = $fail_alert = "";
	$portfolio_id = $category = $style = $description = $thumbnail = $panorama = $images = "";

	if (!empty($_GET['portfolio_id'])) {
		$portfolio_id = $_GET['portfolio_id'];
		$url = "portfolio.php?portfolio_id=" . $portfolio_id;

		$query = 'SELECT * FROM portfolio WHERE portfolio_id = ' . $portfolio_id;
		
		if ($result = mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_assoc($result);
			$category = $row['portfolio_category'];
			$style = $row['portfolio_style'];
			$description = $row['portfolio_description'];
			$thumbnail_path = $row['portfolio_thumbnail'];
			$panorama_path = $row['portfolio_panorama'];
			$images_path = explode(",", $row['portfolio_images']);
			$views = $row['portfolio_views'];
		}
		else {
			$fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
		}
	}
	else {
		$url = "portfolio.php";
	}

	if (isset($_POST['updated'])) {
		$category = $_POST['category'];
		$style = $_POST['style'];
		$description = $_POST['description'];

		if (isset($_POST['imagecheck'])) {
			// old images chosen
			$imagecheck = $_POST['imagecheck'];
			$images_list = implode(",", $imagecheck);
		}
		else {
			$images_list = "";
		}

		// validate file type and upload file if not empty
		if (!empty($_FILES['thumbnail']['name'])) {
			$thumbnail = $_FILES['thumbnail'];
			$thumbnailErr = validateImage($thumbnail['type'], 1);

			if (empty($thumbnailErr)) {
				$thumbnail_name = $thumbnail['name'];
				$target = "assets/img/".basename($thumbnail_name); 
				move_uploaded_file($thumbnail['tmp_name'], $target);
				$thumbnail_path = $thumbnail_name;
			}
		}

		if (!empty($_FILES['panorama']['name'])) {
			$panorama = $_FILES['panorama'];
			$panoramaErr = validateImage($panorama['type'], 1);

			if (empty($panoramaErr)) {
				$panorama_name = $panorama['name'];
				$target = "assets/img/".basename($panorama_name); 
				move_uploaded_file($panorama['tmp_name'], $target);
				$panorama_path = $panorama_name;
			}
		}

		

		// new images uploaded
		if (!empty($_FILES['images']['name'][0])) {
			$images = $_FILES['images'];
			$imagesErr = validateImage($images['type'], 0);

			foreach ($images['name'] as $key => $img_name) {
				$target = "assets/img/".basename($img_name); 
				move_uploaded_file($images['tmp_name'][$key], $target);
				$images_list .= "," . $img_name;
			}
		}
		
		// update database
		$query = "UPDATE portfolio SET 
				portfolio_category = '$category', 
				portfolio_style = '$style', 
				portfolio_description = '$description', 
				portfolio_thumbnail = '$thumbnail_path', 
				portfolio_panorama = '$panorama_path', 
				portfolio_images = '$images_list' 
				WHERE portfolio_id = '$portfolio_id'";

		if (mysqli_query($dbc, $query)) {
			$images_path = explode(",", $images_list);
			$success_alert = "Portfolio has been updated successfully.";
		}
		else {
			$fail_alert = "Could not update the portfolio because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
		}

	}
		
	if (isset($_POST['submitted'])) {

		$category = $_POST['category'];
		$style = $_POST['style'];
		$description = $_POST['description'];
		$thumbnail = $_FILES['thumbnail'];
		$panorama = $_FILES['panorama'];
		$images = $_FILES['images'];

		// echo "<pre>";
		// echo $category;
		// echo $style;
		// echo $description;
		// echo $thumbnailErr;
		// echo $imagesErr;
		// print_r($thumbnail);
		// print_r($images);
		// echo "</pre>";

		// validate thumbnail file type
		$thumbnailErr = validateImage($thumbnail['type'], 1);

		// validate panorama file type
		$panoramaErr = validateImage($panorama['type'], 1);

		// validate images file type
		$imagesErr = validateImage($images['type'], 0);

		if (empty($thumbnailErr) && empty($panoramaErr) && empty($imagesErr)) {

			$thumbnail_name = $thumbnail['name'];
			$target = "assets/img/".basename($thumbnail_name); // image file directory
			
			//Upload image
			//move the uploaded file in the temporary directory on the web server to destination file
			move_uploaded_file($thumbnail['tmp_name'], $target);
			// if (move_uploaded_file($thumbnail['tmp_name'], $target)) {
			// 	$thumbnail_upload_success = "&#10003; &nbsp;&nbsp; Thumbnail uploaded successfully!";
			// }
			// else {
			// 	$thumbnail_upload_fail = "&#10003; &nbsp;&nbsp; Failed to upload thumbnail.";
			// }

			$panorama_name = $panorama['name'];
			$target = "assets/img/".basename($panorama_name); 
			move_uploaded_file($panorama['tmp_name'], $target);

			foreach ($images['name'] as $key => $img_name) {
				$target = "assets/img/".basename($img_name); // image file directory
				
				//Upload image
				//move the uploaded file in the temporary directory on the web server to destination file
				move_uploaded_file($images['tmp_name'][$key], $target);
				// if (move_uploaded_file($images['tmp_name'][$key], $target)) {
				// 	$images_upload_success = "&#10003; &nbsp;&nbsp; Images uploaded successfully!";
				// }
				// else {
				// 	$images_upload_fail = "&#10003; &nbsp;&nbsp; Failed to upload images.";
				// }
			}

			$images_list = implode(",", $images['name']);

			$query = "INSERT INTO portfolio (portfolio_id, portfolio_category, portfolio_style, portfolio_description, portfolio_thumbnail, portfolio_panorama, portfolio_images, portfolio_views) 
						VALUES ('', '$category', '$style', '$description', '$thumbnail_name', '$panorama_name', '$images_list', '')";
			
			if (mysqli_query($dbc, $query)) {
				$portfolio_id = mysqli_insert_id($dbc);
				header('Location: portfolio.php?portfolio_id=' . $portfolio_id);
			}
			else {
				$fail_alert = "Could not insert the portfolio because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
			}
		}

	}

	mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("head.php"); ?>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

	<!-- CSS Libraries -->
	<link rel="stylesheet" href="assets/modules/chocolat/dist/css/chocolat.css">

	<!-- Template CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/components.css">
	<!-- Start GA -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

	<!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-94034622-3');
	</script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <?php include("navbar.php") ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Portfolio</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
				<form action="<?php echo $url; ?>" method="post" enctype="multipart/form-data">
					<div class="card">
						<?php if (!empty($success_alert)): ?>
						<div class="alert alert-success alert-dismissible show fade">
							<div class="alert-body">
								<button class="close" data-dismiss="alert">
									<span>×</span>
								</button>
								<?php echo $success_alert; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if (!empty($fail_alert)): ?>
						<div class="alert alert-danger alert-dismissible show fade">
							<div class="alert-body">
								<button class="close" data-dismiss="alert">
									<span>×</span>
								</button>
								<?php echo $fail_alert; ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="card-header">
							<?php if (!empty($portfolio_id)): ?>
							<button type="submit" class="btn btn-icon icon-left btn-primary mr-2"><i class="fas fa-check"></i> Save Changes</button> 
							<input type="hidden" name="updated" value="true">
							<?php else: ?>
							<button type="submit" class="btn btn-icon icon-left btn-primary mr-2"><i class="fas fa-check"></i> Save</button> 
							<input type="hidden" name="submitted" value="true">
							<?php endif; ?>
							<a href="portfolios.php" class="btn btn-icon icon-left btn-danger"><i class="fas fa-times"></i> Close</a>
						</div>
						
						<div class="card-body">
						<?php if (!empty($portfolio_id)): ?>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">ID</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" value="<?php echo $portfolio_id; ?>" disabled>
							</div>
						</div>
						<?php endif; ?>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Category</label>
							<div class="col-sm-9 selectgroup selectgroup-pills">
								<?php 
									$category_arr = array("Residential", "Commercial");

									if (empty($category))
										$category = $category_arr[0];

									foreach ($category_arr as $c) {
										if ($c == $category) {
											echo
											'<label class="selectgroup-item">
												<input type="radio" name="category" value="' .  $c . '" class="selectgroup-input" checked>
												<span class="selectgroup-button">' . $c . '</span>
											</label>';
										}
										else {
											echo
											'<label class="selectgroup-item">
												<input type="radio" name="category" value="' .  $c . '" class="selectgroup-input">
												<span class="selectgroup-button">' . $c . '</span>
											</label>';
										}
									}
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Style</label>
							<div class="col-sm-9 selectgroup selectgroup-pills">
								<?php 
									$style_arr = array("Modern Minimalist", "Industrial Style", "Traditional / Classic Style", "Art Deco Style", 
														"English Country Style", "Coastal Style", "Eclectic Style", "Asian / Zen Style", "Rustic Style", "Hi-Tech Style");

									if (empty($style))
										$style = $style_arr[0];

									foreach ($style_arr as $s) {
										if ($s == $style) {
											echo
											'<label class="selectgroup-item">
												<input type="radio" name="style" value="' .  $s . '" class="selectgroup-input" checked>
												<span class="selectgroup-button">' . $s . '</span>
											</label>';
										}
										else {
											echo
											'<label class="selectgroup-item">
												<input type="radio" name="style" value="' .  $s . '" class="selectgroup-input">
												<span class="selectgroup-button">' . $s . '</span>
											</label>';
										}
									}
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Description</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="description" cols="30" rows="10" required><?php echo $description; ?></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Thumbnail</label>
							<?php if (!empty($portfolio_id)): ?>
							<div class="col-sm-3">
								<div class="gallery gallery-fw" data-item-height="100">
									<div class="gallery-item" data-image="assets/img/<?php echo empty($thumbnail_path) ? 'news/img09.jpg' : $thumbnail_path; ?>" data-title="" href="assets/img/<?php echo empty($thumbnail_path) ? 'news/img09.jpg' : $thumbnail_path; ?>" title="" style="height: 100px; background-image: url(&quot;assets/img/<?php echo empty($thumbnail_path) ? 'news/img09.jpg' : $thumbnail_path; ?>&quot;);"></div>
								</div>
							</div>
							<?php endif; ?>
							<div class="<?php echo empty($portfolio_id) ? "col-sm-9" : "col-sm-5 ml-4"; ?> custom-file">
								<input type="file" name="thumbnail" class="custom-file-input" id="thumbnail" <?php echo empty($portfolio_id) ? "required" : ""; ?> onchange="changeFileLabel(this.id)">
								<label class="custom-file-label" for="thumbnail">Choose file</label>
								<div class="text-danger pt-3"><?php echo $thumbnailErr; ?></div>
							</div>
						</div>
						<div class="form-group row pt-3">
							<label class="col-sm-3 col-form-label">Panorama</label>
							<?php if (!empty($portfolio_id)): ?>
							<div class="col-sm-3">
								<div class="gallery gallery-fw" data-item-height="100">
									<div class="gallery-item" data-image="assets/img/<?php echo empty($panorama_path) ? 'news/img09.jpg' : $panorama_path; ?>" data-title="" href="assets/img/<?php echo empty($panorama_path) ? 'news/img09.jpg' : $panorama_path; ?>" title="" style="height: 100px; background-image: url(&quot;assets/img/<?php echo empty($panorama_path) ? 'news/img09.jpg' : $panorama_path; ?>&quot;);"></div>
								</div>
							</div>
							<?php endif; ?>
							<div class="<?php echo empty($portfolio_id) ? "col-sm-9" : "col-sm-5 ml-4"; ?> custom-file">
								<input type="file" name="panorama" class="custom-file-input" id="panorama" <?php echo empty($portfolio_id) ? "required" : ""; ?> onchange="changeFileLabel(this.id)">
								<label class="custom-file-label" for="panorama">Choose file</label>
								<div class="text-danger pt-3"><?php echo $panoramaErr; ?></div>
							</div>
						</div>
						<div class="form-group row pt-3">
							<label class="col-sm-3 col-form-label">Images</label>
							<?php if (!empty($portfolio_id)): ?>
							<div class="col-sm-9">
								<div class="form-group row">
									<div class="row gutters-sm">
									<?php foreach ($images_path as $img_path): ?>
									<div class="col-6 col-sm-4">
										<label class="imagecheck mb-4">
										<input name="imagecheck[]" type="checkbox" value="<?php echo $img_path; ?>" class="imagecheck-input" onchange="checkImagesField(this)" checked="">
										<figure class="imagecheck-figure">
											<img src="assets/img/<?php echo $img_path; ?>" alt="" class="imagecheck-image">
										</figure>
										</label>
									</div>
									<?php endforeach; ?>
									</div>
								</div>
							</div>
							<label class="col-sm-3 col-form-label"></label>
							<?php endif; ?>
							<div class="col-sm-9 custom-file">
								<input type="file" name="images[]" class="custom-file-input" id="images" onchange="checkImagesField(this);showImagesList()" multiple <?php echo empty($portfolio_id) ? "required" : ""; ?>>
								<label class="custom-file-label" for="images">Choose file</label><br/>
								<div class="text-danger pt-3"><?php echo $imagesErr; ?></div>
								
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 col-form-label"></div>
							<pre class="col-sm-9" id="imagesList" style="display:none;"></pre>
						</div>
						<?php if (!empty($portfolio_id)): ?>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Views</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" value="<?php echo $views; ?>" disabled>
							</div>
						</div>
						<?php endif; ?>
						</div>
					</div>
				</form>
                </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

	<!-- General JS Scripts -->
	<script src="assets/modules/jquery.min.js"></script>
	<script src="assets/modules/popper.js"></script>
	<script src="assets/modules/tooltip.js"></script>
	<script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
	<script src="assets/modules/moment.min.js"></script>
	<script src="assets/js/stisla.js"></script>

	<!-- JS Libraies -->
	<script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
	<script src="assets/modules/sweetalert/sweetalert.min.js"></script>

	<!-- Page Specific JS File -->
	<script>

		function checkImagesField(checkbox_element) {
			var checkboxes = document.querySelectorAll('input[type="checkbox"]');
			var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);

			if (!checkedOne && document.getElementById("images").files.length == 0) {
				swal('Warning', 'You need to select at least one images.', 'warning');
				checkbox_element.checked = true;
			}
		}

		function changeFileLabel(id) {
			var label = document.querySelector('label[for="' + id + '"]');
			label.textContent = document.getElementById(id).files.item(0).name;
		}

		function showImagesList() {
			var input = document.getElementById('images');
			var list = document.getElementById('imagesList');
			list.innerHTML = '';

			for (var i = 0; i < images.files.length; i++) {
				list.innerHTML += (i + 1) + '. ' + images.files[i].name + '\n';
			}

			if (list.innerHTML == '') 
				list.style.display = 'none';
			else 
				list.style.display = 'block';
		}
		
	</script>

	<!-- Template JS File -->
	<script src="assets/js/scripts.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>