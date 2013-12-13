{def $newsletter_list_node_id = $:newsletter_list_node.node_id}

{let children       = array()
         numChildren    = array()
         haveChildren   = $numChildren|gt(0)
         showToolTips   = ezini( 'TreeMenu', 'ToolTips'         , 'contentstructuremenu.ini' )
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
	{set isRootNode=false}
{/if}

<li id="nt{$newsletter_list_node_id}" {section show=$:last_item} class="lastli"{/section}>

	{* Fold/Unfold/Empty: [-]/[+]/[ ] *}
	<a class="openclose" href="#" title="{'Fold/Unfold'|i18n('newsletter/contentstructuremenu')}"
	   onclick="ezpopmenu_hideAll();
							  ezcst_onFoldClicked(this.parentNode);
							  return false;"></a>

	{* Label *}
	{set toolTip = ''}


	{* icon *}
	{*<img src={'share/icons/crystal-admin/16x16_indexed/actions/view_tree.png'|ezroot} />*}
	{'newsletter_mailing_list'|class_icon( small )}

	{* Text *}
	{if or( eq($ui_context, 'browse')|not(), eq($:parentNode.object.is_container, true()))}
		<a class="nodetext" href={concat( 'content/view/full/', $newsletter_list_node_id )|ezurl} title="{$:toolTip}"><span class="node-name-normal">{$:newsletter_list_node.name|wash}</span></a>
		{else}
		<span class="node-name-normal">{$:newsletter_list_node.name|wash}</span>
	{/if}
</li>
{/default}
{/let}
