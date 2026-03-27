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