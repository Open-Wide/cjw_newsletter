{* 4_newsletter_mailing_lists.tpl
    alle mailing lists
*}

    {let $newsletter_root_node_id = $newsletter_mailing_lists_node.node_id
         children       = fetch( 'content', 'tree', hash('parent_node_id', $newsletter_root_node_id,
                                                        'class_filter_type', 'include',
                                                        'class_filter_array', array('cjw_newsletter_list'),
                                                        'sort_by', array( 'name', true() ), ))
         numChildren    = fetch( 'content', 'tree_count', hash('parent_node_id', $newsletter_root_node_id,
                                                        'class_filter_type', 'include',
                                                        'class_filter_array',
                                                        array('cjw_newsletter_list') ))
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

        <li id="n0_{$newsletter_root_node_id}" {cond( $:last_item, 'class="lastli"', '' )}>

            {* Fold/Unfold/Empty: [-]/[+]/[ ] *}
                   <a class="openclose" href="#" title="{'Fold/Unfold'|i18n('cjw_newsletter/contentstructuremenu')}"
                      onclick="ezpopmenu_hideAll(); ezcst_onFoldClicked( this.parentNode ); return false;"></a>

            {* Label *}
				{set toolTip = ''}

                {* Text *}
				{'cjw_newsletter_system'|class_icon( small )}
                {if or( eq($ui_context, 'browse')|not(), eq($:parentNode.object.is_container, true()))}
                    <a class="nodetext" href={concat( 'content/view/full/',$newsletter_root_node_id )|ezurl} title="{$:toolTip}"><span class="node-name-normal">{$newsletter_mailing_lists_node.name}</span></a>
                {else}
					<span class="node-name-normal">{$newsletter_mailing_lists_node.name}</span>
                {/if}

                {* Show children *}
                {if $:haveChildren}
                    <ul>
{*
                        <li><span class="openclose"></span> systeme link 1 alle</li>
                        <li><span class="openclose"></span> systeme link 2 alle</li>
*}
                        {foreach $:children as $:child }
                            {include name=SubMenu uri="design:contentstructuremenu/5_newsletter_list.tpl" newsletter_list_node=$:child csm_menu_item_click_action=$:csm_menu_item_click_action last_item=eq( $child.number, $:numChildren ) ui_context=$ui_context}
                        {/foreach}
                    </ul>
                {/if}
        </li>
        {/default}
    {/let}
