{* 2_newsletter_system_tree.tpl
alle systeme
*}
{let $newsletterRootNodeId = ezini( 'NewsletterSettings', 'RootFolderNodeId', 'newsletter.ini' )
		 newsletterRootNode = fetch( 'content', 'node', hash( 'node_id', $newsletterRootNodeId ) )
         children       = fetch( 'content', 'tree', hash('parent_node_id', $newsletterRootNodeId,
                                                        'class_filter_type', 'include',
                                                        'class_filter_array', array('newsletter_system'),
                                                        'sort_by', array( 'name', true() ), ))
         numChildren    = fetch( 'content', 'tree_count', hash('parent_node_id', $newsletterRootNodeId,
                                                        'class_filter_type', 'include',
                                                        'class_filter_array',
                                                        array('newsletter_system') ))
         haveChildren   = $numChildren|gt(0)
         showToolTips   = ezini( 'TreeMenu', 'ToolTips' , 'contentstructuremenu.ini' )
         translation    = ezini( 'URLTranslator', 'Translation', 'site.ini' )
         toolTip        = ""
         visibility     = 'Visible'
         isRootNode     = false() }

{default classIconsSize = ezini( 'TreeMenu', 'ClassIconsSize', 'contentstructuremenu.ini' )
                 last_item      = false() }

{if is_set($class_icons_size)}
	{set classIconsSize=$class_icons_size}
{/if}

{if is_set($is_root_node)}
	{set isRootNode=$is_root_node}
{/if}
<li id="n0_{$newsletterRootNodeId}" {cond( $:last_item, 'class="lastli"', '' )}>

	{* Fold/Unfold/Empty: [-]/[+]/[ ] *}
	{if or($:haveChildren, $:isRootNode)}
		<a class="openclose" href="#" title="{'Fold/Unfold'|i18n('design/admin/contentstructuremenu')|wash}"
		   onclick="ezpopmenu_hideAll(); ezcst_onFoldClicked( this.parentNode ); return false;"></a>
	 {/if}

	{* Label *}
	{set toolTip = ''}

	{* Text *}                
	{if or( eq($ui_context, 'browse')|not(), eq($:parentNode.object.is_container, true()))}
		<a class="nodetext" href={concat( 'content/view/full/',$newsletterRootNodeId )|ezurl} title="{$:toolTip}"><span class="node-name-normal">{$$newsletterRootNode.name}</span></a>
		{else}
		<span class="node-name-normal">{$$newsletterRootNode.name}</span>
	{/if}

	{* Show children *}
	{if $:haveChildren}
		<ul>
			{foreach $:children as $:child}
				{include name=SubMenu uri="design:contentstructuremenu/3_newsletter_system.tpl" newsletter_system_node=$:child csm_menu_item_click_action=$:csm_menu_item_click_action last_item=eq( $child.number, $:numChildren ) ui_context=$ui_context}
			{/foreach}
		</ul>
	{/if}
</li>
{/default}
{/let}
