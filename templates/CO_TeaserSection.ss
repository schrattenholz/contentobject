
<h1> Teaser Secction </h1><div class="row no-gutters" >
	<div class="col-12 home_sideinfo">
		<% if $ShowTitle %><div class="row"><h2 class="py-4 rw_blau">$Title</h2></div><% end_if %>
		<% loop $LimitedEntries %>
		<% if  not $MultipleOf(2) %>
		<div class="row content mb-4" >
		<% end_if %>
			<div class="card col-12 col-sm-6 p-sm-0 <% if $even %>pl-sm-2<% else %>pr-sm-2<% end_if %> ">
			<a class="cardlink" href="$Link">
				<img class="card-img-top" src="<% if $TeaserImage %>$TeaserImage.Fill(400,266).URL<% else_if $Image %>$Image.Fill(400,266).URL<% else %>$BaseHref/public/resources/vendor/schrattenholz/contentobject/templates/images/default.jpg<% end_if %>" alt="$Image.Filename">
				<div class="card-block px-0 pt-2">
					<h5 class="card-title">$MenuTitle.XML</h5>
					<p class="card-text"><% if $TeaserText %>$TeaserText<% else_if $CuttedText(50) %>$CuttedText(50)<% else %><% end_if %></p>
				</div>
			</a>
			</div>
		<% if  not $MultipleOf(2,2) || $Last %>
		</div>
		<% end_if %> 
		<% end_loop %>
	</div>
</div>