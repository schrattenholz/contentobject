     <div  class="$ColorSet.Class py-5">
	<!-- Featured category -->
    <section class="container mb-4 pb-3 pb-sm-0 mb-sm-5">
		<div class="row">
			<div class="col-12">
					<div class="mb-1 ">
					<h2 class="bg-headline bg-headline-before <% if $SubHead %>mb-0 <% end_if %>"><span>$Title</span></h2>
					<p class="mb-5">$SubHead</p>
				  </div>
			</div>
		</div>
      <div class="row">
        <% include Schrattenholz\ContentObject\FeaturedCategoryBanner %>
        <!-- Product grid (carousel)-->
        <div class="col-md-7 pt-4 pt-md-0">
          <div class="cz-carousel">
            <div class="cz-carousel-inner" data-carousel-options='{"items": $Limit, "nav": true, "responsive": {"0":{"items":1},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"gutter": 24}}}'>
              <% include Schrattenholz\ContentObject\FeaturedCategoryItems %>
            </div>
          </div>
        </div>
      </div>
    </section>
	</div>