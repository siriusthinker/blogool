		</div>
		<div class="template-content">
			<!-- homepage -->
			<script id="homepage-template" type="mustache-template">
				<div class="content" id="posts-homepage">
					<div class="custom-title"><h2> Recent Posts</h2></div>
					<div class="row post-list-contents">
						<ul>
							{{#posts}}
								<li class="post-item">
									{{{ content }}}
									<div class="clear"></div>
									<p class="desc-icons">
										<span><i class="fa fa-user" aria-hidden="true"></i> Posted by: {{ created_by }}</span> &nbsp;&nbsp;&nbsp;
										<span><i class="fa fa-calendar" aria-hidden="true"></i> Date created: {{ date_created }}</span>
									</p>
								</li>
							{{/posts}}
						</ul>
					</div>
					<div class="row post-list-pagination">
						<?php if (isset($pagination)) echo $pagination ?>
					</div>
				</div>
			</script>
			<!-- dashboard -->
			<script id="dashboard-template" type="mustache-template">
				<div class="content" id="posts-dashboard">
					<div class="custom-title"><h2> My Posts</h2></div>
					<div class="row post-list-contents">
						<ul>
							{{#posts}}
								<li class="post-item">
									{{{ content }}}
									<div class="clear"></div>
									<p class="desc-icons">
										<span><i class="fa fa-user" aria-hidden="true"></i> Posted by: {{ created_by }}</span> &nbsp;&nbsp;&nbsp;
										<span><i class="fa fa-calendar" aria-hidden="true"></i> Date created: {{ date_created }}</span>
									</p>
								</li>
							{{/posts}}
						</ul>
					</div>
				</div>
			</script>
			<!-- editor -->
			<script id="editor-template" type="mustache-template">
				<div class="content">
					<div class="custom-title"><h2> MarkDown Editor </h2></div>
					<div class="row" id="editor-page">
						<div class="col-lg-12 col-md-12">
							<div class="pull-right">
								<button class="btn btn-success markdown-save">
									<i class="fa fa-save" aria-hidden="true"></i> Save
								</button>
							</div>
						</div>
						<div id="editor-container" class="col-lg-6 col-md-6 editor-container" style="margin-top: 20px;">
							<textarea id="editor"></textarea>
						</div>
						<div id="preview-container" class="col-lg-6 col-md-6 preview-container" style="margin-top: 20px;">
							<div id="preview"></div>
						</div>
					</div>
				</div>
			</script>
		</div>
		<div class="account-footer">
			<div class="copyright">&copy; Blogool. All Rights Reserved 2016.</div>
		</div>
	</div>

	<script src="<?php echo base_url('js/vendor/jquery.min.js')?>"></script>
	<script src="<?php echo base_url('js/vendor/jqueryui.min.js')?>"></script>
	<script src="<?php echo base_url('js/vendor/mustache.min.js')?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('js/vendor/dataTables_plugins.min.js')?>"></script>
	<script src="<?php echo base_url('js/vendor/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('js/vendor/showdown.min.js')?>"></script>
	<script src="<?php echo base_url('js/transport.js')?>"></script>
	<script src="<?php echo base_url('js/user.js')?>"></script>
	<script src="<?php echo base_url('js/post.js')?>"></script>
	<script src="<?php echo base_url('js/dashboard.js')?>"></script>
	<script src="<?php echo base_url('js/markdown.js')?>"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>