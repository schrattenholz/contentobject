<div class="row" style="" >
	<div class="col-12 home_sideinfo set_$Background<% if $OuterBlock %> pr-0<% else %> <% end_if %> <% if $Background=="none" %>pt-0<% end_if %> ">
		<% if $ShowTitle %><h2  class="<% if $OuterBlock  %> <% else %> pb-4<% end_if %>">$Title</h2><% end_if %>
		$Content
	</div>
	<% if $OuterBlock %>
	<div class="col home_sideinfo_block set_$Background">
	</div>
	<% end_if %>
</div>