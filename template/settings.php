
<style>
	.input *{
		margin-bottom: 15px; 
	}	
	.button.preview, .button.publish, .shortcode{
		display: none;
	}
	.shortcode{
		text-align:right;
		margin-top:-12px; 
		clear:both;

	}
	p.prevw-btn {
    	margin-bottom: 47px;
	}
	.preview-col{
		border-left: 1px #000 thin;
	}
	.col-half {
		width:50%;
		float:left;
	}
	.banner-img-preview img{
		height: 120px;
		width: 120px;
		max-height: 140px;
		max-width: 140px;
		margin:2%;
		float:left;
	}
	.prevw-btn input{
		margin-right: 20px;
	}
	.code-container{
		margin-bottom: 20px;
		display: none;
	}
</style>


<h1>Photo Banner <?php echo $var; ?> </h1> 
<div class="wrap row-fluid">    
	
	<div class="row">
		<div class="col-md-12">
		 	<div class="manage-menus code-container">
 					<span class="add-edit-menu-action add-success">
						You've added a new photobanner <span class="use-code"></span> 
					</span><!-- /add-edit-menu-action -->
				</div>
			<div class="col-md-8">  
				 
				<div id="side-sortables" class="accordion-container">
					<ul class="outer-border">
						<li class="control-section accordion-section " >
							<h3 class="accordion-section-title hndle" tabindex="0">
								Add New  <span class="screen-reader-text">Press return or enter to expand</span>
							</h3>
							<div class="accordion-section-content ">
								<div class="inside">
									<div class="col-md-12">
									  	<div class="col-half" >
									  		
									  		<div class="input">
												<label for="banner-name">Banner Name <br> 
													<input type="text" name="banner_name" size="60" placeholder="This is your new banner" value="" id="banner-name" spellcheck="true" autocomplete="off">
												</label>
											</div>
											<div class="input">										 
												<label for="banner-desc">Description <br>
													<input type="text" name="banner_desc" size="60" placeholder="Add a description" value="" id="banner-desc" spellcheck="true" autocomplete="off">
												</label>	
											</div>
											<div class="add-images">
												<div id="wp-media-mgr" >												
													<input id="upload_image_button" type="button" value="Get Images" class=" button" />	
												 											
												</div>  
 
											</div>
									  	</div>
										<!-- preview images -->
										<div class="col-half preview-col">
											<p> Hold shift and select multiple images from media uploader. Add multiple shortcodes anywhere in your site. Add more images 
											for better results. <br> </p>
											<p>You can use the shortcode in WP editor or on your theme files [cwpb id="99999" ]</p>
											<p class="prevw-btn"> 
											<input type="button" value="Publish" class="button button-primary publish" />	</p>
														
											<p class="banner-img-preview"> </p>
										</div>
									</div>											
								</div><!-- .inside -->
							</div><!-- .accordion-section-content -->
						</li><!-- .accordion-section -->
						
					</ul><!-- .outer-border -->
				</div>
				<br>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
				
			<div class="col-md-8">
				<table class="wp-list-table widefat fixed striped bookmarks">
					<thead>
						<th colspan="1">ID</th>
						<th colspan="2">Banner Name</th>
						<th>Description</th>
						<th>Shortcode</th>
						<th >Date Created</th>
						<th>
							 
							<select name="" id="">
								<option value="">Bulk Actions</option>
								<option value="">Edit</option>
								<option value="">Delete</option>
							</select>
							<input id="cb-select-all-1" type="checkbox">  	

						</th>
					     	

<?php  foreach ($records as $v) { ?>
						 			<tr>
						 				<td><?php echo $v['id']; ?></td>
						 				<td><?php echo $v['name']; ?></td>
						 				<td></td>						 			   
						 				<td><?php echo $v['desc']; ?></td>
						 				<td><?php echo $v['shortcode']; ?></td>
						 				<td><?php echo $v['date_created']; ?></td>
						 			 
						 				<td><span style="float:right;"><input value="<?php echo $v['id']; ?>" type="checkbox"> </span>
						 				 	<span style="float:right; margin-right:15px;" class="dashicons dashicons-edit"></span>
											<span style="float:right; margin-right:15px" class="dashicons dashicons-trash"></span>
						 					
						 				</td>

						 			</tr>	
						<?php }?>

					 
					 

					</thead>
				</table>
		
				 
			</div>
		</div>
		 
	</div>
</div><!--- End Wrap -->
