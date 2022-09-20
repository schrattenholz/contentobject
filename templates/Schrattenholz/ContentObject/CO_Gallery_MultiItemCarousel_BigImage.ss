<div class="colorSet{$ColorSetID}">
<section class="container-fluid mb-4 pb-3 pb-sm-0 mb-sm-5 px-0">
<div class="row no-gutters">
	<div class="col-md-6 bg-position-center bg-size-cover">
		<div class="row">
			<div class="card border-0 p-0">
				<div class="card-body p-0">
					<div  id="thumbCarousel$ID" class="carousel slide cz-carousel cz-dots-disabled">
					  <div class="cz-carousel-inner" data-carousel-options='{"loop": true, "autoplay": false,"nav":false}'>
						<% loop $Images %>
							<img src="$Image.Fill(400,300).URL" >
						<% end_loop %>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- Product grid (carousel)-->
			<div class="card border-0 col-12 py-0 px-4">
				<div class="cz-carousel ">
					<div class="card-body cz-carousel-inner " data-carousel-options='{"items": 4, "nav": false, "gutter":20}'>
						<% loop $Images %>		
						<div data-slide-to="$Pos" data-target="#carouselExampleIndicators">
							<a style="cursor:pointer;" onclick="javascript:var index$ID=$Pos-1;window['thumbCarousel$Up.ID'].goTo(index$ID);""><img src="$Image.Fill(278,278).URL" alt="Product"></a>
							
						
						</div>
						<% end_loop %>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 bg-position-center bg-size-cover <% if $ImageLeft %>order-md-2<% else %>order-md-1<% end_if %>">
		<div class="mx-auto py-lg-5 font-size-sm" style="max-width: 35rem;">
		<% if $ShowTitle %>
					<h2  class="<% if $SubHead %>mb-0<% end_if %>">$Title</h2>
					<% if $SubTitle %>
					<h6 class="font-size-lg font-weight-normal  pb-4">$SubTitle</h6>
					<% end_if %>
				<% end_if %>
				$Content
		</div>
	</div>
</div>
</section></div>