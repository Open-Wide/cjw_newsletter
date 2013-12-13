{* DO NOT EDIT THIS FILE! Use an override template instead.
    content/datatype/view/newslettersubscription.tpl

    show all List and the usersubscription
       if subscription is_removed or no set => no
       otherwise => yes
*}


{def $attribute_base = 'ContentObjectAttribute'}

{def $newsletter_root_node_id = ezini( 'NewsletterSettings', 'RootFolderNodeId', 'newsletter.ini' )
     $attribute_content = $attribute.content
     $newsletter_user = $attribute_content.existing_newsletter_user
     $subscription_array = array()
     }

{if is_object( $newsletter_user ) }
    {set $subscription_array = $newsletter_user.subscription_array}
{/if}

{def $newsletter_list_node_list = fetch( 'content', 'tree',
                                                                hash('parent_node_id', $newsletter_root_node_id,
                                                                     'extended_attribute_filter',
                                                                          hash( 'id', 'NewsletterListFilter',
                                                                                'params', hash( 'siteaccess', array( 'current_siteaccess' ) ) ),
                                                                     'class_filter_type', 'include',
                                                                     'class_filter_array', array('newsletter_list'),
                                                                     'limitation', hash( ) )) }

<ul>
{foreach $newsletter_list_node_list as $list_node}
    {def $subscription_string = 'no'|i18n( 'newsletter/datatype/newslettersubscription' )}

    {if and( is_set( $subscription_array[ $list_node.contentobject_id ] ),
             $subscription_array[ $list_node.contentobject_id ].is_removed|not)}
        {set $subscription_string = 'yes'|i18n( 'newsletter/datatype/newslettersubscription' )}
    {/if}
    <li>{$list_node.data_map.title.content|wash} ({$subscription_string|wash})</li>
    {undef $subscription_string}
{/foreach}
</ul>

{*$attribute_content|attribute(show,3)*}
{undef $attribute_base $attribute_content $subscription_array $newsletter_list_node_list}