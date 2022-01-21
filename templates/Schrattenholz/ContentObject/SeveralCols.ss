<div  class="$ColorSet.Class py-5">
	<!-- Featured category -->
	<section class="container ">
<div class="row">
			<!-- Product grid (carousel)-->
			<div class="col pt-4 pt-md-0 d-flex">
				<div style="align-self:center;">
					<h2 class="bg-headline bg-headline-before"><span>$Title</span></h2>
					$Content
				</div>
			</div>
		</div>
		<div class="row">
			<% loop $ContentObjects.Sort('SortID') %>
			<div class="col-md-6 pt-4 pt-md-0 d-flex">
				$renderIt
			</div>
			<% end_loop %>
		
		</div>
	</section>
</div>