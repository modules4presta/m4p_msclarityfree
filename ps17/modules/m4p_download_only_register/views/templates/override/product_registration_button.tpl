{extends file='catalog/_partials/product-add-to-cart.tpl'}

{if !$customer.is_logged}
    <a href="{$link->getPageLink('authentication')}" class="btn btn-primary">
        {$lng.Register}
    </a>
{else}
    {* Wyświetl normalny przycisk "Dodaj do koszyka" *}
    {block name='product_add_to_cart'}
        {$productPrice}
        {* Tu umieść kod przycisku "Dodaj do koszyka" *}
    {/block}
{/if}
testss