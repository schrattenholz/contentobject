
          <div class="d-flex flex-column h-100 justify-content-center bg-size-cover bg-position-center rounded-lg">
            <div class="pb-4 my-2 px-4">
              <!-- Contacts card: Shadow -->
				<div class="card border-0 box-shadow">
				  <div class="card-body p-0">
					<% if $ShowTitle %><h5 class="card-title pl-3 my-2">$Title</h5><% end_if %>
					$Form
					<ul class="list-unstyled mb-0">
					<% loop $Elements.Sort('SortID').Filter("AfterStaticElements",0) %>
						<li class="media mb-0 pt-3<% if not $First %> pt-3 <% end_if %> <% if $Last && not $ShowAddress && not $ShowOpeningHours %>pb-2 border-bottom<% else_if not $Last %>border-bottom<% end_if %> colorSet{$ColorSetID}">
						
						<div class="media-body mt-1 px-3">
						  <h4>$Title</h4>
						  <div class="font-size-ms">
						  $Content
						  </div>
						</div>
					  </li>
					  <% end_loop %>
					<% if $ShowOpeningHours %>
						<% if $Top.Page.OrderConfig.OpeningDaysText || $Top.Page.OrderConfig.OpeningDays %> 
						  <li class="media mb-0 pt-3 pb-2 <% if $ShowAddress %>border-bottom<% end_if %>">
							
							<div class="media-body mt-1 px-3">
							  <h4>&Ouml;ffnungszeiten Hofladen</h4>
							  <% if $Top.Page.OrderConfig.OpeningDaysText %>
							   $Top.Page.OrderConfig.OpeningDaysText
							  <% else_if $Top.Page.OrderConfig.OpeningDays %>
							  <dl class="row font-size-ms mb-0">
							  
								  <% loop $Top.Page.OrderConfig.OpeningDays %>
								<dt class="col-sm-5 font-weight-normal mb-0">$DayTranslated:</dt>
								<dd class="col-sm-7 mb-0">$TimeFrom.Format('HH:mm') - $TimeTo.Format('HH:mm') Uhr</dd>
							  <% end_loop %>
							  </dl>
							  <% end_if %>
							  
							</div>
						  </li>
						  <% end_if %>
						<% end_if %>
					  <% if $ShowAddress %>
						<li class="media mb-0 pt-3 <% if $Elements.Sort('SortID').Filter("AfterStaticElements",1) %>border-bottom<% end_if %>">
							
							<div class="media-body mt-1 pl-3">
							  <h4>Adresse</h4>
							 <p class="font-size-ms"> $SiteConfig.MainContact</br>$SiteConfig.Street, $SiteConfig.ZIP $SiteConfig.City</p>
							</div>
						</li>
					  <% end_if %>
					  <% loop $Elements.Sort('SortID').Filter("AfterStaticElements",1) %>
						<li class="media mb-0 pt-3<% if not $Last %>border-bottom<% end_if %> colorSet{$ColorSetID}">
						
						<div class="media-body mt-1 px-3">
						  <h4>$Title </h4>
						  <div class="font-size-ms">
						  $Content
						  </div>
						</div>
					  </li>
					  <% end_loop %>
					</ul>
				  </div>
				</div>
            </div>
          </div>
   