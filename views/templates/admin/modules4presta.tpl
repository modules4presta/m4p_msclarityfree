<div class="panel">
    <div class="panel-heading">
        <h2>{l s='Requirements' mod='m4p_msclarityfree'}</h2>
    </div>

    {foreach $requirements as $requirement}
        {if $requirement.status == 1}
            <p style="color:#00aa00"><span style="font-size: 22px">&#10004;</span> {$requirement.name|escape:'html':'UTF-8'}</p>
        {else}
            <p style="color:#ff0000">&#10060; {$requirement.name|escape:'html':'UTF-8'}</p>
        {/if}
    {/foreach}
</div>
