{extends file="parent:frontend/index/header.tpl"}
{block name='frontend_index_header_title'}{strip}
{if $sCategoryContent.attribute.attribute1}{$sCategoryContent.attribute.attribute1}
{elseif $sArticle.attr1}{$sArticle.attr1} | {config name=sShopname}
{elseif $Controller == "custom"}{if $sBreadcrumb}{foreach from=$sBreadcrumb|array_reverse item=breadcrumb}{$breadcrumb.name}{/foreach}{/if}
{elseif $Controller == "blog"}{if $sBreadcrumb}{foreach from=$sBreadcrumb|array_reverse item=breadcrumb}{$breadcrumb.name}{break}{/foreach}{/if}
{else}{if $sBreadcrumb}{foreach from=$sBreadcrumb|array_reverse item=breadcrumb}{$breadcrumb.name} | {/foreach}{/if} {config name=sShopname}{/if}
{/strip}{/block}