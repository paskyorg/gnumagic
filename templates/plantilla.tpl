{include file='cabecera.tpl'}
{*menu*}
{if isset($admin)}
    {include file='admin-menu.tpl'}
{else}
    {include file='menu.tpl'}
{/if}
{*/menu*}
{*principal*}
{if isset($principal)}
    {include file=$principal}
{/if}
{*/principal*}
{include file='pie.tpl'}