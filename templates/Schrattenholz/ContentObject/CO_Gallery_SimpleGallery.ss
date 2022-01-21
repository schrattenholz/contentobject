<div  class="$ColorSet.Class py-5">
	<!-- Featured category -->
	<section class="container ">
		<% if $ShowTitle || $Content %>
			<div class="row">
				<!-- Product grid (carousel)-->
				<div class="col-md-12 pt-4 pt-md-0 d-flex">
					<div style="align-self:center;">
						<h2>$Title</h2>
						$Content
					</div>
				</div>
			</div>
		<% end_if %>
		<div class="row cz-gallery">

					<% loop $Images %>
					  <div class="col-xl-3 col-sm-4 mb-grid-gutter">
							 <a href="$Image.ScaleWidth(1400).URL" class="gallery-item rounded-lg" data-toggle="lightbox" data-gallery="gallery$Up.ID" data-sub-html='<h6 class="font-size-sm text-light">$Title</h6>'>
						 <img src="$Image.Fill(420,280).URL">
						<span class="gallery-item-caption">$Title</span>
						</a>
					  </div>
					<% end_loop %>

		</div>
	</section>
</div>