<div class="panel">
   <b>
       {l s='Please check the PRO version of the MS Clarity module.' mod='m4p_msclarityfree'}

    <a href="https://modules4presta.io/index.php?action=redirectToModule&fc=module&module=mfp_license_manager&controller=ajax&modulename=m4p_msclaritypro" target="_blank">{l s='Show more'}</a>
   </b>
</div>
<div class="alert alert-warning d-print-none" role="alert">
    <div class="alert-text">
        <p>

            {l s='This module collects data for analysis purposes. Consider adding it to the analytical cookie files.' mod='m4p_msclarityfree'}
        </p>
    </div>
</div>

<div class="panel">
    <div class="panel-heading" style="background:#2d2d2d;color:#fff;">
        <img class="logo img-fluid" src="https://modules4presta.io/img/logo-1686239238.jpg" alt="Modules4Presta.io" width="200" height="50">
        <h2><a href="https://modules4presta.io" target="_blank"  style="color:#fff;">Modules4Presta.io</a> {l s='Poleca' mod='m4p_barinfofree'}</h2>
    </div>
    <div class="row">
        {foreach $modules_ads as $module}
            {if $module.name[1]}
                <div class="col-12 col-md-3">
                    <a href="{$module.link}" target="_blank">
                        <img src="https://{$module.image_link}" alt="{$module.name[1]}">
                        <h4 style="color:#000;">{$module.name[1]}</h4>

                        {if $module.price == 0}
                            <p style="color:#000;">GRATIS</p>
                        {else}
                            <p style="color:#000;">{Tools::displayPrice($module.price)}</p>
                        {/if}
                    </a>
                </div>
            {/if}

        {/foreach}
    </div>
</div>