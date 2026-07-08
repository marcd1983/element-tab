<div class="cell">
    <% if $Title && $ShowTitle %>
        <% with $HeadingTag %>
            <{$Me} class="element-title">$Up.Title.XML</{$Me}>
        <% end_with %>
    <% end_if %>
    <% if $Content %><div class="element__content">$Content</div><% end_if %>
    <% if $Panels %>
        <ul class="tabs" data-tabs id="tab-{$ID}">
        <% loop $Panels %>
            <li class="tabs-title <% if $IsFirst %>is-active<% end_if %>">
                <a data-tabs-target="panel{$ID}" href="#panel{$ID}" aria-selected="<% if $First %>true<% else %>false<% end_if %>" data-no-swup><span>$Title</span></a>
            </li>
        <% end_loop %>
        </ul>
        <div class="tabs-content" data-tabs-content="tab-{$ID}">
            <% loop $Panels %>
                <div class="tabs-panel <% if $IsFirst %>is-active<% end_if %>" id="panel{$ID}">
                    <% if $Image %>   
                        <img src="$Image.URL" class="img-responsive" alt="$Title.ATT">
                        <p></p>
                    <% end_if %>
                    $Content
                    <% if $Links.Exists %>
                        <div class="button-group">
                        <% loop $Links %>
                            <a class="button $CssClass" href="$URL" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>$Title.XML</a>
                        <% end_loop %>
                        </div>
                    <% end_if %>
                </div>
            <% end_loop %>
        </div>
    <% end_if %>
</div>