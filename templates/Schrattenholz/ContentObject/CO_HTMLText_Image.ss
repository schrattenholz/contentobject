<div  class="$ColorSet.Class py-5">
	<!-- Featured category -->
    <section class="container ">
		<div class="row" style="" >
			<div class="col-md-6">
			<% if $ShowTitle %>
						<h2  class="<% if $SubHead %>mb-0<% end_if %>">$Title</h2>
						<% if $SubHead %>
						<h6 class="font-size-lg font-weight-normal  pb-4">$SubHead</h6>
						<% end_if %>
					<% end_if %>
					$Content
			</div>
			<div class="offset-md-1 col-md-5 ">
				 <picture>
				  <source media="(min-width:1200px)" srcset="$Image.ScaleWidth(800).URL">
				  <source media="(min-width:768px)" srcset="$Image.ScaleWidth(500).URL">
				  <img class="rounded-big-top-left rounded-big-bottom-right" src="$Image.ScaleWidth(400).URL" alt="$Image.Title" style="width:auto;">
				</picture> 
			</div>
		</div>
	</section>
</div>