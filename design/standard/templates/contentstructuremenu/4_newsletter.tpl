{* 4_newsletter_mailing_lists.tpl
alle mailing lists
*}
{let $newsletter_root_node_id = $newsletter_node.node_id
         children       = fetch( 'content', 'tree', hash('parent_node_id', $newsletter_root_node_id,
                                                        'class_filter_type', 'include',
                                                        'class_filter_array', array('newsletter_edition'),
                                                        'sort_by', array( 'name', true() ), ))
         numChildren    = fetch( 'content', 'tree_count', hash('parent_node_id', $newsletter_root_node_id,
                                                        'class_filter_type', 'include',
                                                        'class_filter_array',
                                                        array('newsletter_edition') ))
         haveChildren   = $numChildren|gt(0)
         showToolTips   = ezini( 'TreeMenu', 'ToolTips' , 'contentstructuremenu.ini' )
         translation    = ezini( 'URLTranslator', 'Translation', 'site.ini' )
         toolTip        = ""
         visibility     = 'Visible'
         isRootNode     = false() }

{default classIconsSize = ezini( 'TreeMenu', 'ClassIconsSize', 'contentstructuremenu.ini' )
                 last_item      = false() }

{section show=is_set($class_icons_size)}
	{set classIconsSize=$class_icons_size}
{/section}

{section show=is_set($is_root_node)}
	{set isRootNode=$is_root_node}
{/section}

<li id="n0_{$newsletter_root_node_id}" {cond( $:last_item, 'class="lastli"', '' )}>

	{* Fold/Unfold/Empty: [-]/[+]/[ ] *}
	<a class="openclose" href="#" title="{'Fold/Unfold'|i18n('newsletter/contentstructuremenu')}"
	   onclick="ezpopmenu_hideAll();
			   ezcst_onFoldClicked(this.parentNode);
			   return false;"></a>

	{* Label *}
	{set toolTip = ''}

	{* Text *}
	{'newsletter'|class_icon( small )}
	{if or( eq($ui_context, 'browse')|not(), eq($:parentNode.object.is_container, true()))}
		<a class="nodetext" href={concat( 'content/view/full/',$newsletter_root_node_id )|ezurl} title="{$:toolTip}"><span class="node-name-normal">{$newsletter_node.name}</span></a>
	{else}
		<span class="node-name-normal">{$newsletter_node.name}</span>
	{/if}

	{* Show children *}
	<ul>

		{* draft *}
		{def $editionObjectListDraftCount = fetch('content','list_count',
                                                                hash('parent_node_id', $newsletter_root_node_id,
                                                                        'extended_attribute_filter',
                                                                        hash( 'id', 'NewsletterEditionFilter',
                                                                              'params', hash( 'status', 'draft' ) )
                                                                                 ) )}
		<li id="n{$newsletter_root_node_id}_draft">
			<img src={'images/newsletter/icons/crystal-newsletter/16x16/newsletter_draft.png'|ezdesign} />
			<a class="nodetext" href={concat('content/view/full/',$newsletter_root_node_id, '/(status)/draft')|ezurl}>
				<span class="node-name-normal">{'Draft'|i18n('newsletter/contentstructuremenu')} ({$editionObjectListDraftCount})</span>
			</a>
		</li>
		{* process *}
		{def $editionObjectListProcessCount = fetch('content','list_count',
                                                                hash('parent_node_id', $newsletter_root_node_id,
                                                                        'extended_attribute_filter',
                                                                        hash( 'id', 'NewsletterEditionFilter',
                                                                              'params', hash( 'status', 'process' ) )
                                                                                 ) )}
		<li id="n{$newsletter_root_node_id}_process">
			<img src={'images/newsletter/icons/crystal-newsletter/16x16/newsletter_process.png'|ezdesign} />
			<a class="nodetext" href={concat('content/view/full/',$newsletter_root_node_id, '/(status)/process')|ezurl}>
				<span class="node-name-normal">{'Sending'|i18n('newsletter/contentstructuremenu')} ({$editionObjectListProcessCount})</span>
			</a>
		</li>
		{* Archive *}
		{def $editionObjectListArchiveCount = fetch('content','list_count',
                                                                hash('parent_node_id', $newsletter_root_node_id,
                                                                        'extended_attribute_filter',
                                                                        hash( 'id', 'NewsletterEditionFilter',
                                                                              'params', hash( 'status', 'archive' ) )
                                                                                 ) )}
		<li id="n{$newsletter_root_node_id}_archive">
			<img src={'images/newsletter/icons/crystal-newsletter/16x16/newsletter_archive.png'|ezdesign} />
			<a class="nodetext" href={concat('content/view/full/',$newsletter_root_node_id, '/(status)/archive')|ezurl}>
				<span class="node-name-normal">{'Archived'|i18n('newsletter/contentstructuremenu')} ({$editionObjectListArchiveCount})</span>
			</a>
		</li>
		{* Abort *}
		{def $editionObjectListAbortCount = fetch('content','list_count',
                                                                hash('parent_node_id', $newsletter_root_node_id,
                                                                        'extended_attribute_filter',
                                                                        hash( 'id', 'NewsletterEditionFilter',
                                                                              'params', hash( 'status', 'abort' ) )
                                                                                 ) )}
		<li class="lastli" id="n{$newsletter_root_node_id}_abort">
			<img src={'images/newsletter/icons/crystal-newsletter/16x16/newsletter_abort.png'|ezdesign} />
			<a class="nodetext" href={concat('content/view/full/', $newsletter_root_node_id, '/(status)/abort')|ezurl}>
				<span class="node-name-normal">{'Aborted'|i18n('newsletter/contentstructuremenu')} ({$editionObjectListAbortCount})</span>
			</a>
		</li>

		{undef}
	</ul>
</li>
{/default}
{/let}
