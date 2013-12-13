{* icon for websitetoolbar to access newsletter index *}
{def $newsletter_access = fetch( 'user', 'has_access_to', hash( 'module', 'newsletter', 'function', 'index' ) )}
{if $newsletter_access}

    <a href={'newsletter/index'|ezurl} class="newsletter"><img class="ezwt-input-image" src={"websitetoolbar/ezwt-icon-newsletter.png"|ezimage} alt="{'Newsletter dashboard'|i18n( 'newsletter/index' )}" title="{'Newsletter dashboard'|i18n( 'newsletter/index' )}" border="0" /></a>
{/if}