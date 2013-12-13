{* Children window.*}
{if $node.object.content_class.is_container}
    {include uri='design:newsletter_list_children.tpl'}
{else}
    {include uri='design:no_children.tpl'}
{/if}