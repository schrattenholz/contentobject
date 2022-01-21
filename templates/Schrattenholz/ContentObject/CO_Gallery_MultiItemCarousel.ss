<div  class="$ColorSet.Class py-5">
	<!-- Featured category -->
	<section class="container ">
	<% if $Content || $ShowTitle %>
	<div class="row justify-content-center">
		<div class="col text-center pb-1 pb-md-4">
			<% if $ShowTitle %>
					<h2  class="bg-headline pb-3"><span>$Title</span></h2>
			<% end_if %>
			$Content
		</div>
	</div>
	<% end_if %>
		<div class="cz-carousel cz-dots-enabled cz-gallery">
			<div class="cz-carousel-inner" data-carousel-options='{"responsive": {"0":{"items":1},"576":{"items":2, "gutter": 20},"767":{"items":3, "gutter": 24},"1200":{"items":4, "gutter": 30}}}'>
				<% loop $Images %>
				<div>
					<a href="$Image.ScaleWidth(1400).URL" class="gallery-item rounded-lg" data-sub-html='<h6 class="font-size-sm text-light">$Title</h6>'>
						<img src="$Image.Fill(420,280).URL" alt="$Title">
						<span class="gallery-item-caption">$Title</span>
					</a>
				</div>
				<% end_loop %>
			</div>
		</div>
	</section>
</div>
