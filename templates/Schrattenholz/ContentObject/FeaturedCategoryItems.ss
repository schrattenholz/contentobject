<!-- Carousel item-->
              <div> 
                <div class="row mx-n2">
				<% loop $LimitedEntries.Limit(3) %>
                  <div class="col-lg-4 col-6 px-0 px-sm-2 mb-sm-4">
                    <div class="card product-card card-static">
                      <!--<button class="btn-wishlist btn-sm" type="button" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class="czi-heart"></i></button>
					  -->
					  <a class="card-img-top d-block overflow-hidden" href="<% if $DeepLink %>$DeepLink.Link<% else %> $Link <% end_if %>"><img src="$DefaultImage.Fill(278,278).URL" alt="Product"></a>
                      <div class="card-body py-2"><a class="product-meta d-block font-size-xs pb-1" href="$Parent.Link">$Parent.MenuTitle</a>
                        <h3 class="product-title font-size-sm"><a href="<% if $DeepLink %>$DeepLink.Link<% else %> $Link <% end_if %>">$Title</a></h3>
                        <div class="d-flex justify-content-between">
                          <div class="product-price"><span class="text-accent">
						  <% if $DeepLink %>
							<% if $DeepLink.GroupPreise %>
								ab <% if $DeepLink.GroupPreise.Sort('Price','ASC').First.CaPrice %>ca. <% end_if %>$Top.formattedNumber($DeepLink.GroupPreise.Sort('Price','ASC').First.PriceObject.Price) &euro;
								
							<% else_if $KiloPrice.Price %>
								<% if $DeepLink.CaPrice %>ca. <% end_if %>$formattedNumber($DeepLink.KiloPrice.Price) &euro;
							<% end_if %>
						  <% else %>
							<% if $GroupPreise %>
								ab <% if $GroupPreise.Sort('Price','ASC').First.CaPrice %>ca. <% end_if %>$Top.formattedNumber($GroupPreise.Sort('Price','ASC').First.PriceObject.Price) &euro;
								
							<% else_if $KiloPrice.Price %>
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