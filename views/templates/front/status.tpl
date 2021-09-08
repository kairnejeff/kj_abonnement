{extends file='page.tpl'}

{block name="page_content"}

    <div class="status">
        <h2 class="<?php echo $ordStatus; ?>">{$msg}</h2>
        {if isset($abonnement) &&!empty($abonnement)}
            <h3>Payment Information</h3>
            <p><b>Reference Number:</b>{$abonnement.id_transaction}</p>
            <p><b>Period start:</b>{$abonnement.date_start}</p>
            <p><b>Status:</b>{$abonnement.status}</p>
        {/if}
    </div>
    <a href="index.php" class="btn-link">Back to Subscription Page</a>
{/block}