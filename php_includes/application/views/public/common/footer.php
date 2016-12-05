		</div>

		<div class="confirmation-modal-container"></div>

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
						<div class="col-lg-12 col-md-12">
							<div class="pull-right">
								<button class="btn btn-success create-new-post">
									<i class="fa fa-save" aria-hidden="true"></i> Create New
								</button>
							</div>
						</div>
						<ul>
							{{#posts}}
								<li class="post-item">
									{{{ content }}}
									<div class="clear"></div>
									<p class="desc-icons">
										<span><i class="fa fa-user" aria-hidden="true"></i> Posted by: {{ created_by }}</span> &nbsp;&nbsp;&nbsp;
										<span><i class="fa fa-calendar" aria-hidden="true"></i> Date created: {{ date_created }}</span>
									</p>
									<div class="col-lg-12 col-md-12">
										<div class="my-post-button pull-left">
											<button class="btn btn-info post-edit">
												<i class="fa fa-info" aria-hidden="true"></i> Edit
											</button>
										</div>
										<div class="my-post-button pull-left">
											<button class="btn btn-danger post-delete" data-post-id="{{ id }}">
												<i class="fa fa-trash" aria-hidden="true"></i> Delete
											</button>
										</div>
										{{ #is_published }}
										<div class="my-post-button pull-left">
											<button class="btn btn-warning post-unpublish" data-post-id="{{ id }}" data-status-update="UnPublished">
												<i class="fa fa-minus" aria-hidden="true"></i> UnPublish
											</button>
										</div>
										{{ /is_published }}
										{{ ^is_published }}
										<div class="my-post-button pull-left">
											<button class="btn btn-primary post-publish" data-post-id="{{ id }}" data-status-update="Published">
												<i class="fa fa-plus" aria-hidden="true"></i> Publish
											</button>
										</div>
										{{ /is_published }}
									</div>
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
			<!-- Modal Template -->
			<script id="modal-template-confirmation" type="mustache-template">
				<div class="confirmation-modal modal-{{ size }}">
					<div class="create-update-modal-header">
						<h3 class="create-update-modal-header-title">
							{{ title }}
						</h3>
					</div>

					<div class="create-update-modal-body" data-module="{{ module }}">{{{ content }}}</div>

					<div class="create-update-modal-footer">
						<div class="pull-left">
							{{#cancel}}
								<button class="btn btn-default confirm-modal-close" data-dismiss="confirmation-modal">
									<i class="fa fa-times" aria-hidden="true"></i> Cancel
								</button>
							{{/cancel}}
						</div>
						<div class="pull-right">
							{{#save}}
								<button class="btn btn-success modal-save-confirmation" data-post-id="{{ post_id }}">
									<i class="fa fa-save" aria-hidden="true"></i> Yes
								</button>
							{{/save}}
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
	<script src="<?php echo base_url('js/modal.js')?>"></script>
	<script src="<?php echo base_url('js/user.js')?>"></script>
	<script src="<?php echo base_url('js/post.js')?>"></script>
	<script src="<?php echo base_url('js/dashboard.js')?>"></script>
	<script src="<?php echo base_url('js/markdown.js')?>"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>