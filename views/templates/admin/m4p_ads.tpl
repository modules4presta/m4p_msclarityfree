<div class="alert alert-warning d-print-none" role="alert">
    <div class="alert-text">
        <p>
            {l s='This module collects data for analysis purposes. Consider adding it to the analytical cookie files.' mod='m4p_msclarityfree'}
        </p>
    </div>
</div>

{if isset($modules_ads) && $modules_ads}
<div class="panel">
    <div class="panel-heading" style="background:#2d2d2d;color:#fff;">
        <img class="logo img-fluid" src="https://modules4presta.io/img/logo-1686239238.jpg" alt="Modules4Presta.io" width="200" height="50">
        <h2><a href="https://modules4presta.io" target="_blank" style="color:#fff;">Modules4Presta.io</a> {l s='Poleca' mod='m4p_msclarityfree'}</h2>
    </div>
    <div class="row">
        {foreach $modules_ads as $module}
            {if isset($module.name[1]) && $module.name[1]}
                <div class="col-12 col-md-3">
                    <a href="{$module.link|escape:'html':'UTF-8'}" target="_blank">
                        <img src="https://{$module.image_link|escape:'html':'UTF-8'}" alt="{$module.name[1]|escape:'html':'UTF-8'}">
                        <h4 style="color:#000;">{$module.name[1]|escape:'html':'UTF-8'}</h4>

                        {if $module.price == 0}
                            <p style="color:#000;">{l s='FREE' mod='m4p_msclarityfree'}</p>
                        {else}
                            <p style="color:#000;">{Tools::displayPrice($module.price)}</p>
                        {/if}
                    </a>
                </div>
            {/if}
        {/foreach}
    </div>
</div>
{/if}
