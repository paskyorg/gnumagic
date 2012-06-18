{include file='cabecera.tpl'}
{*menu*}
{if isset($admin)}
    {include file='admin-menu.tpl'}
{else}
    {include file='menu.tpl'}
{/if}
{*/menu*}
{*principal*}
{if $principal == 'inicio'}
    {include file='inicio.tpl'}
{elseif $principal == 'incidencias'}
    {include file='incidencias.tpl'}
{elseif $principal == 'nueva-incidencia'}
    {include file='nueva-incidencia.tpl'}
{elseif $principal == 'incidencia'}
    {include file='incidencia.tpl'}
{*administracion*}
{elseif $principal == 'admin-inicio.tpl'}
    {include file=$principal}
{elseif $principal == 'admin-incidencia.tpl'}
    {include file=$principal}
{elseif $principal == 'admin-incidencias.tpl'}
    {include file=$principal}
{else}
    {include file=$principal}
{/if}
{*/principal*}
{include file='pie.tpl'}