<% if $PageID %>
<div  class="$ColorSet.Class py-5">
    <section class="container ">
<% end_if %>
		<div class="row <% if $SeveralColsID %>no-gutters<% end_if %>">
			<div class="col-12">
				<% if $ShowTitle %>
					<% if $PageID %>
					<h2  class=" pb-4">$Title</h2>
					<% else %>
					<h3  class=" pb-4">$Title</h3>
					<%  end_if %>
				<% end_if %>
				$Content
			</div>
		</div>
<% if $PageID %>
	</section>
</div>
<% end_if %>