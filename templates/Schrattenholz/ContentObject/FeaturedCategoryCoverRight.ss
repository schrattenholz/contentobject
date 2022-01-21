     <div  class="$ColorSet.Class py-5">
	<!-- Featured category (Hoodie)-->
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

        <!-- Product grid (carousel)-->
        <div class="col-md-7 pt-4 pt-md-0">
          <div class="cz-carousel">
            <div class="cz-carousel-inner" data-carousel-options="{&quot;nav&quot;: false, &quot;controlsContainer&quot;: &quot;#hoodie-day&quot;}">
              <% include Schrattenholz\ContentObject\FeaturedCategoryItems %>
              
            </div>
          </div>
        </div>
		        <!-- Banner with controls-->
        <div class="col-md-5">
          <div class="d-flex flex-column h-100 overflow-hidden rounded-lg" style="background-color: #e2e9ef;">
            <div class="d-block position-absolute justify-content-between px-grid-gutter py-grid-gutter">
			  <div class="mb-1 ">
			  <a class="font-size-md " href="$Category.Link"><span class=" py-1 px-2" style="background-color:rgba(105,105,105,0.7);color:#ffe952;">$SubHead<i class="czi-arrow-right font-size-xs align-middle ml-1"></i></span></a>
              </div>
              <div class="cz-custom-controls" id="hoodie-day">
                <button type="button"><i class="czi-arrow-left"></i></button>
                <button type="button"><i class="czi-arrow-right"></i></button>
              </div>
            </div><a class="d-none d-md-block " href="$Category.Link" ><img class="d-block w-100" src="$Category.CoverImage.Fill(500,350).URL" alt="$Category.Title"></a>
          </div>
        </div>
      </div>
    </section>
	</div>