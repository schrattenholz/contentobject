	<section class="container position-relative pt-3 pt-lg-0 pb-5 mt-lg-n10 $ColorSet.Class" style="z-index: 10;">
      <div class="row">
        <div class="col-xl-6 col-lg-9">
          <div class="card border-0 box-shadow-lg">
            <div class="card-body px-3 pt-grid-gutter pb-0">
              <div class="row no-gutters pl-1">
				<% loop $LimitedEntries %>
				<div class="col-sm-6">
					<a class="d-block text-center text-decoration-none mr-1" href="$DeepLink.Link">
						<img class="d-block rounded mb-3" src="$DefaultImage.Fill(278,278).URL" alt="$Title">
						<h3 class="font-size-base pt-1 mb-0"><% if $TeaserTitle %>$TeaserTitle<% else %>$Title<% end_if %></h3>
						$Content
					</a>
				</div>
				<% end_loop %>
            </div>
          </div>
        </div>
      </div>
    </section>