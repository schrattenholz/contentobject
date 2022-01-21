    <!-- Featured category (Hoodie)-->
    <section class="container mb-4 pb-3 pb-sm-0 mb-sm-5">
      <div class="row">
        <!-- Banner with controls-->
        <div class="col-md-5">
          <div class="d-flex flex-column h-100 overflow-hidden rounded-lg" style="background-color: #e2e9ef;">
            <div class="d-block position-absolute justify-content-between px-grid-gutter py-grid-gutter">
              <div class="mb-1 ">
                <h3 ><span style="background-color:rgba(105,105,105,0.7);color:#ffe952;" class="py-1 px-2">$Title</span></h3>
              </div>
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
        <!-- Product grid (carousel)-->
        <div class="col-md-7 pt-4 pt-md-0">
          <div class="cz-carousel">
            <div class="cz-carousel-inner" data-carousel-options="{&quot;nav&quot;: false, &quot;controlsContainer&quot;: &quot;#hoodie-day&quot;}">
              <!-- Carousel item-->
              <div>
                <div class="row mx-n2">
				<% loop $LimitedEntries %>
                  <div class="col-lg-4 col-6 px-0 px-sm-2 mb-sm-4">
                    <div class="card product-card card-static">
                      <button class="btn-wishlist btn-sm" type="button" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class="czi-heart"></i></button><a class="card-img-top d-block overflow-hidden" href="<% if $DeepLink %>$DeepLink.Link<% else %> $Link <% end_if %>"><img src="$CoverImage.Fill(278,205).URL" alt="Product"></a>
                      <div class="card-body py-2"><a class="product-meta d-block font-size-xs pb-1" href="#">$Parent.MenuTitle</a>
                        <h3 class="product-title font-size-sm"><a href="shop-single-v1.html">$Title</a></h3>
                        <div class="d-flex justify-content-between">
                          <div class="product-price"><span class="text-accent">
						  <% if $DeepLink %>
							<% if $DeepLink.GroupPreise %>
								ab <% if $DeepLink.GroupPreise.Sort('Price','ASC').First.CaPrice %>ca. <% end_if %>$Top.formattedNumber($DeepLink.GroupPreise.Sort('Price','ASC').First.PriceObject.Price) &euro;
								
							<% else %>
								<% if $DeepLink.CaPrice %>ca. <% end_if %>$formattedNumber($DeepLink.KiloPrice.Price) &euro;
							<% end_if %>
						  <% else %>
							<% if $GroupPreise %>
								ab <% if $GroupPreise.Sort('Price','ASC').First.CaPrice %>ca. <% end_if %>$Top.formattedNumber($GroupPreise.Sort('Price','ASC').First.PriceObject.Price) &euro;
								
							<% else %>
								<% if $CaPrice %>ca. <% end_if %>$formattedNumber($KiloPrice.Price) &euro;
							<% end_if %>
					<% end_if %>
						  </span></div>
                          <!--<div class="star-rating"><i class="sr-star czi-star-filled active"></i><i class="sr-star czi-star-filled active"></i><i class="sr-star czi-star-filled active"></i><i class="sr-star czi-star-filled active"></i><i class="sr-star czi-star"></i>
                          </div>-->
                        </div>
                      </div>
                    </div>
                  </div>
				<% end_loop %>
                  
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>