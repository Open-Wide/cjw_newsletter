{*?template charset=utf-8?*}
{* DO NOT EDIT THIS FILE! Use an override template instead.
    content/datatype/edit/newsletterlist.tpl
*}
{if is_unset( $attribute_base )}
  {def $attribute_base='ContentObjectAttribute'}
{/if}

{def $datatype_name='newsletterlist'
     $list_object = $attribute.content}

{* siteaccess list *}
{def $available_siteaccess_list = $list_object.available_siteaccess_list
     $available_skin_array =  $list_object.available_skin_array
     $available_output_format_list = $attribute.class_content['available_output_format_array']
     $default_output_format = 0
     $selected_sitaccess_array = $list_object['siteaccess_array']
     $main_siteaccess = $list_object['main_siteaccess']
     $output_format_array = $list_object['output_format_array']
     $email_sender_name = $list_object['email_sender_name']
     $email_sender = $list_object['email_sender']
     $email_receiver_test = $list_object['email_receiver_test']
     $skin_name = $list_object['skin_name']
     $auto_approve_registered_user = $list_object['auto_approve_registered_user']
     $personalize_content = $list_object['personalize_content']
     }

{* default value main_siteaccess *}
{if $main_siteaccess|eq('') }
    {set $main_siteaccess = $available_siteaccess_list[0]}
{/if}

{if $email_sender|eq('') }
    {set $email_sender = ezini('MailSettings','AdminEmail')}
{/if}

{if $email_receiver_test|eq('') }
    {set $email_receiver_test = ezini('MailSettings','AdminEmail')}
{/if}

{if $output_format_array|eq('') }
    {set $output_format_array = array( $default_output_format)}
{/if}

<hr>

<label>* {'List options'|i18n('newsletter/datatype/newsletterlist')}</label>
<table class="list" cellspacing="0">
<tr>
    <th>{'Render output'|i18n('newsletter/datatype/newsletterlist')}</th>
    <th>{'Can subscribe'|i18n('newsletter/datatype/newsletterlist')}</th>
    <th>{'Siteaccess'|i18n('newsletter/datatype/newsletterlist')}</th>
</tr>
{foreach $available_siteaccess_list as $sitaccess_name => $siteaccess_info sequence array('bglight','bgdark') as $style}
<tr class="{$style}">
    <td><input type="radio" name="{$attribute_base}_NewsletterList_MainSiteaccess_{$attribute.id}" value="{$sitaccess_name}" {if $main_siteaccess|eq( $sitaccess_name )}checked{/if}></td>
    <td><input type="checkbox" name="{$attribute_base}_NewsletterList_SiteaccessArray_{$attribute.id}[]" value="{$sitaccess_name}" {if $selected_sitaccess_array|contains( $sitaccess_name )}checked{/if}></td>
    <td>{$sitaccess_name|wash( )} ( {$siteaccess_info.locale|wash} - {$siteaccess_info.site_url|wash} )</td>
</tr>
{/foreach}
</table>

<hr>
<label>{'Available newsletter output formats'|i18n('newsletter/datatype/newsletterlist')}</label>
<ul>
{foreach $available_output_format_list as $output_format_id => $output_format_name}
<li><input type="checkbox" name="{$attribute_base}_NewsletterList_OutputFormatArray_{$attribute.id}[]" value="{$output_format_id}" {if is_set( $output_format_array[ $output_format_id ] )}checked{/if}> {$output_format_name|wash}</li>
{/foreach}
</ul>

<hr>
{* auto_approve_registerd_user *}
<label>{'Automatically approve subscription after user registration?'|i18n('newsletter/datatype/newsletterlist')}</label>
<input type="radio" name="{$attribute_base}_NewsletterList_AutoApproveRegisterdUser_{$attribute.id}" value="0"{$auto_approve_registered_user|choose(' checked', '')}/> {'no'|i18n('newsletter/datatype/newsletterlist')}
<input type="radio" name="{$attribute_base}_NewsletterList_AutoApproveRegisterdUser_{$attribute.id}" value="1"{$auto_approve_registered_user|choose('', ' checked')}/> {'yes'|i18n('newsletter/datatype/newsletterlist')}


<hr>
{* email_sender *}
<label>* {'Newsletter sender email'|i18n('newsletter/datatype/newsletterlist')}</label>
<input type="text" class="halfbox" name="{$attribute_base}_NewsletterList_EmailSender_{$attribute.id}" value="{$email_sender}" />

{* email_sender_name *}
<label>{'Newsletter sender name'|i18n('newsletter/datatype/newsletterlist')}</label>
<input type="text" class="halfbox" name="{$attribute_base}_NewsletterList_EmailSenderName_{$attribute.id}" value="{$email_sender_name}" />

<hr>
{* email_reciever_test *}
<label>{'Newsletter default test receiver email'|i18n('newsletter/datatype/newsletterlist')}</label>
<input type="text" class="halfbox" name="{$attribute_base}_NewsletterList_EmailReceiverTest_{$attribute.id}" value="{$email_receiver_test}" />

<hr>
{* skin_name *}

{*def $available_skin_array=array('default', 'uemis_com', 'uemis_org')*}

<label>{'Newsletter skin name'|i18n('newsletter/datatype/newsletterlist')}</label>

{foreach $available_skin_array as $skin_name_2}
<input type="radio" name="{$attribute_base}_NewsletterList_SkinName_{$attribute.id}" value="{$skin_name_2}" {if or( eq( $skin_name, $skin_name_2), eq( $available_skin_array|count(), 1) ) }checked="checked"{/if} />{$skin_name_2|wash}
{/foreach}

<hr>
<label>{'Personalize newsletter if data are available?'|i18n('newsletter/datatype/newsletterlist')} {*# {$personalize_content} #*}</label>
<input type="radio" name="{$attribute_base}_NewsletterList_PersonalizeContent_{$attribute.id}" value="0"{$personalize_content|choose(' checked', '')} /> {'no'|i18n('newsletter/datatype/newsletterlist')}
<input type="radio" name="{$attribute_base}_NewsletterList_PersonalizeContent_{$attribute.id}" value="1"{$personalize_content|choose('', ' checked')} /> {'yes'|i18n('newsletter/datatype/newsletterlist')}

{*

<h1>class content</h1>
{$attribute.class_content|attribute(show)}

<h1>attribute.content</h1>
{$list_object|attribute(show)}

*}
{undef}
