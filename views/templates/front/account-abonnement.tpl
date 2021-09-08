<div class="info-bloc">
    <h2 class="infor-bloc-title">{l s='My abonnement' d='Shop.Theme.Customeraccount'}</h2>
    <div class="info-bloc-content">
        <h3 class="font3">{l s='Abonnement' d='Shop.Theme.Customeraccount'}</h3>
        <div class="row">

        {foreach $myAbonnements as $myAbonnement}
            <div class="col-lg-6 col-md-12 col-sm-12">
                <p>Name abonnement: {$myAbonnement.abonnement.titre}</p>
                <p>Transaction id: {$myAbonnement.id_transaction}</p>
                <form method="post" action="{$link}">
                    <input name='id_transaction' type="hidden" value="{$myAbonnement.id_transaction}" class="hidden" />
                    <button type="submit" class="btn btn-primary"> {l s='cancel abonnement' d='Shop.Theme.Customeraccount'}</button>
                </form>
            </div>
        {/foreach}

        </div>

    </div>
</div>