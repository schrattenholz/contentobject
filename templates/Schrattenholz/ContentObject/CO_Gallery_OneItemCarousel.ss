<!-- One item + Static controls + Dots inside + No loop -->
<div class="colorSet{$ColorSetID}">
	<div class="card border-0 box-shadow ">
		<% if $Content || $ShowTitle %>
			<div class="card-header">
				<% if $ShowTitle %>
						<h3  class="pb-3"><span>$Title</span></h3>
						<% if $SubTitle %>
							<h6 class="font-size-lg font-weight-normal  pb-4">$SubTitle</h6>
							<% end_if %>
				<% end_if %>
				$Content
			</div>
		<% end_if %>
		<div class="card-body">
			<div class="cz-carousel cz-dots-inside">
			  <div class="cz-carousel-inner" data-carousel-options='{"loop": true, "autoplay": true}'>
				<% loop $Images %>
					<img src="$Image.Fill(400,300).URL" >
				<% end_loop %>
			  </div>
			</div>
		</div>
	</div>
</div>