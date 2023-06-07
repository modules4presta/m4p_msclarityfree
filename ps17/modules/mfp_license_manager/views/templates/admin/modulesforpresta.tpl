<div class="panel">
    <div class="panel-heading">
        <h2>{l s='Requaierments' mod='mfp_license_manager'}</h2>
    </div>

    {foreach $requaierments as $requaierment}
        {if $requaierment.status == 1}
            <p style="color:#00ff00"><span style="font-size: 22px">&#10004;</span> {$requaierment.name}</p>
        {else}
            <p style="color:#ff0000">&#10060; {$requaierment.name}</p>
        {/if}
    {/foreach}
</div>