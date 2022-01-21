<div  class="$ColorSet.Class py-5">
	<!-- Featured category -->
	<section class="container ">
		<div class="row">
			<!-- Product grid (carousel)-->
			<div class="col pt-4 pt-md-0 d-flex">
				<div style="align-self:center;">
				<h2 class="bg-headline bg-headline-before "><span>$Title</span></h2>
					$Content
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col pt-4 pt-md-0">
				<div class="card-columns">
					<% loop $LimitedEntries.Limit(4) %>

						<!-- Card -->
						  <div class="card mb-4">
						  
							<div class="card-body">
							  <h5 class="card-title">$Title</h5>
							  $Content
							  <% if $Link %><a href="$Link" class="btn btn-sm btn-primary">Mehr lesen</a><% end_if %>
							</div>
						  </div>

					<% end_loop %>
				</div>
			</div>
		</div>
	</section>
</div>