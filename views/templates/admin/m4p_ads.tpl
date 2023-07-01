<div class="panel">
    Ten moduł zbiera dane do analizy. Rozważ dopisanie go do analitycznych plików cookie.
</div>

<div class="panel">
    <div class="panel-heading" style="background:#2d2d2d;color:#fff;">
        <img class="logo img-fluid" src="https://modules4presta.io/img/logo-1686239238.jpg" alt="Modules4Presta.io" width="200" height="50">
        <h2>{l s='Modules4Presta Polecane moduły'}</h2>
    </div>
    <div class="row">
        {foreach $modules_ads as $module}
            {if $module.name[1]}
                <div class="col-12 col-md-3">
                    <a href="{$module.link}">
                        <img src="https://{$module.image_link}" alt="{$module.name[1]}">
                        <h4>{$module.name[1]}</h4>

                        {if $module.price == 0}
                            <p>FREE</p>
                        {else}
                            <p>{Tools::displayPrice($module.price)}</p>
                        {/if}
                    </a>
                </div>
            {/if}

        {/foreach}
    </div>
</div>