<div>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=$PlaylistID" frameborder="0" allowfullscreen></iframe>
    <div class="clear"></div>
    <% if $DataValue('snippet.channelTitle') %>
        <strong>$DataValue('snippet.channelTitle')</strong>
    <% end_if %>
</div>