<div class="row">
	<div class="col-12 colorSet$ColorSet.ID home_sideinfo<% if $OuterBlock %> pr-0<% else %> <% end_if %> <% if $Background=="none" %>pt-0<% end_if %> ">
		<% if $ShowTitle %><h2  class="<% if $OuterBlock  %> <% else %> pb-4<% end_if %>">$Title</h2><% end_if %>
		$Content
	</div>
	<% if $OuterBlock %>
	<div class="col colorSet$ColorSet.ID home_sideinfo_block">
	</div> 
	<% end_if %>
</div>